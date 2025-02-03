<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Exception;

class DataProcessor
{
    public function __construct()
    {

    }

    public function getKeywords(string $phrase): array
    {
        // Define a basic list of common stop words (you can extend this list as needed)
        $stopWords = [
            'a', 'an', 'and', 'are', 'as', 'at', 'be', 'by', 'for',
            'from', 'has', 'he', 'in', 'is', 'it', 'its', 'of',
            'on', 'that', 'the', 'to', 'was', 'were', 'will', 'with','so', 'therefore','though',
            'them','her','his'
        ];

        // Normalize the phrase: lowercase and split into words
        $words = preg_split('/\s+/', strtolower($phrase));

         // Filter out stop words, numbers, words with numbers, and clean punctuation
        $keywords = array_filter($words, function ($word) use ($stopWords) {
            // Remove punctuation from the word
            $cleanedWord = preg_replace('/[^\p{L}\p{N}\s]/u', '', $word);

            // Skip empty words, stop words, and words containing numbers
            return !empty($cleanedWord) &&
                !in_array($cleanedWord, $stopWords) &&
                !preg_match('/\d/', $cleanedWord);
        });

        // Clean punctuation and remove duplicates
        $keywords = array_map(function ($word) {
            return preg_replace('/[^\p{L}\p{N}]/u', '', $word); // Remove punctuation
        }, $keywords);

         return array_values(array_unique($keywords));

    }

    protected function getBodyTextFromHtml($htmlContent,$startWith='') {
        // Load HTML content into DOMDocument
           $dom = new \DOMDocument();
           libxml_use_internal_errors(true); // Suppress parsing errors
           $dom->loadHTML($htmlContent, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
           libxml_clear_errors();

           // Extract the body element
           $body = $dom->getElementsByTagName('body')->item(0);
           if (!$body) {
               return ''; // Return empty if no body tag is found
           }

           // Remove unwanted tags
           $xpath = new \DOMXPath($dom);
           foreach ($xpath->query('//script | //style | //noscript | //template | //iframe') as $element) {
               $element->parentNode->removeChild($element);
           }

           // Extract visible text content
           $bodyText = '';
           foreach ($body->childNodes as $child) {
               if ($child->nodeType === XML_TEXT_NODE || $child->nodeType === XML_ELEMENT_NODE) {
                   $bodyText .= ' ' . $child->textContent;
               }
           }

           // Clean up whitespace and filter non-UTF-8 characters
           $bodyText = trim(preg_replace('/\s+/', ' ', $bodyText));
           $bodyText = mb_convert_encoding($bodyText, 'UTF-8', 'UTF-8');

           // Filter non-UTF-8 characters
           $bodyText = preg_replace('/[^\x20-\x7E\xA0-\xFF]/', '', $bodyText);
             // Remove common unwanted phrases
           $garbagePatterns = [
               '/Image source.*?Image caption/i',
               '/\b(cookie settings|advertisement|sponsored|related articles?|terms of use|privacy policy|contact us|about us|accessibility help|bbc|copyright)\b/i',
               '/\b(?:Terms of Use|Privacy Policy|Cookies|Accessibility Help|sex|Sex|Parental Guidance|Contact us|Get Personalised Newsletters|Why you can trust the BBC|Advertise with us)\b/i',
               '/\b(?:All rights reserved|Copyright \d{4}|The BBC is not responsible for the content of external sites)\b/i',
               '/\b(?:Read about our approach to external linking)\b/i',
               '/© \d{4} .+?\.|all rights reserved/i',
               '/read about our approach to external linking/i'
           ];
           $bodyText = preg_replace($garbagePatterns, '', $bodyText);



           // Apply start text filtering if specified
           $pos = stripos($bodyText, $startWith);
           if ($pos !== false) {

                   $filteredText  = substr($bodyText, $pos);
                   $relevantEnd = preg_split('/(?:\bRelated\b|\bSponsored\b|\bAdvertisement\b|\.{2,})/', $filteredText, 2);
                   $bodyText= trim($relevantEnd[0]);

                    // Remove any invalid UTF-8 characters
                   $bodyText = mb_convert_encoding($bodyText, 'UTF-8', 'UTF-8');

                   // Optional: Remove any remaining non-UTF-8 characters (if any invalid sequences remain)
                   $bodyText = preg_replace('/[^\x{0000}-\x{FFFF}]/u', '', $bodyText);

           }
           else
           {
                $bodyText = '';
           }


            return $bodyText;
       }


       public function saveImageFromUrl($url, $savePath)
       {
            $saved_ok = false;
            // Validate URL
            if (filter_var($url, FILTER_VALIDATE_URL))
            {
                // Get the content of the image from URL
                try
                {
                    $imageContent = file_get_contents($url);

                    if ($imageContent !== false) {
                        // Save the image content to a file
                    Storage::put($savePath, $imageContent);
                        $saved_ok = true;
                    }
                }
                catch( Exception $e)
                {
                    $saved_ok = false;
                }
            }
            return ($saved_ok);
        }


        public function print_articles($cat_name,$articles)
        {
            echo " Category: ".$cat_name."\n";
            echo "################################\n";
            foreach ($articles as $article)
            {
                echo "title: ".$article->title."\n";
                echo "author: ".$article->author."\n";
                echo "image_name: ".$article->image_name."\n";
                echo "\n\n";
            }
        }


        public function get_unique_image_name($basename)
        {
            $counter=0;
            $image_name = $basename;
            $path = "images/".$image_name;
            if (Storage::exists($path))
            {
                do
                {
                    list ($name,$ext) = explode(".",$basename);
                    $image_name = $name.rand(100,999).".".$ext;
                    $path = "images/".$image_name;
                    $counter++;
                } while( Storage::exists($path) && $counter<11 );
                if ($counter===11 && Storage::exists($path) )
                {
                    $image_name = null;
                }
            }

           return($image_name);
        }

        public function get_articles($category)
        {
            $cat_articles = [];
            $month_back = date('Y-m-d', strtotime('-28 days'));

            $api_key = env('API_KEY');
            $url = "https://newsapi.org/v2/everything?q=".$category."&searchin=title&language=en&from=".$month_back."&sortBy=popularity";
            $ch = curl_init();
            curl_setopt($ch,CURLOPT_URL,$url);
            curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
            curl_setopt($ch,CURLOPT_CONNECTTIMEOUT, 4);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'User-Agent: Blogs/1.0 (danatal49@gmail.com)',  // Use a unique User-Agent string for your app
                'X-API-KEY: '.$api_key,
            ]);


            $json_str = curl_exec($ch);
            if(!$json_str) {
                echo curl_error($ch);
            }
            curl_close($ch);
        $json_obj = json_decode($json_str);
        if ($json_obj->status==="ok")
        {
            $articles = $json_obj->articles;
            $i=0;
            $counter=0;
            $trials =0;
            do
            {
                    $article = $articles[$i];
                    if (!empty($article->title) && !empty($article->author) && !empty($article->description))
                    {
                        $title = $article->title;
                        $pattern = '/([a-zA-Z0-9]+)\.(jpg|jpeg|png|gif|bmp|webp)$/i';

                        if (!empty($article->urlToImage) && preg_match($pattern, basename($article->urlToImage), $matches)) // get image name from the url
                        {
                            $image_name = $matches[0];
                        }
                        else
                        {
                            $image_name = null;
                        }

                        try
                        {
                            $article->content = preg_replace('/… \[.*?\]/', '', $article->content);
                           // $text_content = $article->content;
                             $html_content = file_get_contents($article->url);
                             $text_content = $this->getBodyTextFromHtml($html_content,$title);
                                if (!empty($text_content) && !empty($image_name) && strlen($article->title)<191 )
                                {
                                    $article->long_content = $text_content;
                                    $article->image_name = $image_name;

                                    $pattern = '/\((.*?)\)/';

                                    if (preg_match($pattern, $article->author, $match)) // ensure clean author name
                                    {
                                        $article->author = $match[1];  // Output the text inside parentheses
                                    }
                                    $comma_position = strpos($article->author, ',');
                                    if ( $comma_position !== false)
                                    {
                                        $article->author = substr($article->author, 0, $comma_position);
                                    }

                                    $cat_articles[] = $article;
                                    $counter++;
                                }
                                $trials++;

                        }
                        catch( Exception $e)
                        {

                        }

                    }
                    $i++;

                    if ($trials >=30)
                    {
                        break;
                    }

            } while ($counter <3 );
        }
        else
        {
            echo "for category: ".$category."\n";
            var_dump($json_obj);
        }
        return ($cat_articles);
        }

}
