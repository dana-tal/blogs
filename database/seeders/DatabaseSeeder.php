<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Article;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Tag;
use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */

    protected function get_user($name)
    {
        $user = User::where('name', $name)->first();

        if (!$user)
        {
            // Create a new user
            $user = new User();
            $user->name = $name;
            $name_parts = explode(' ',$name);
            $email = implode('_',$name_parts).'.gmail.com';
            $user->email = $email;
            $user->password = bcrypt('123456'); // Always hash passwords
            $user->remember_token =  Str::random(10);
            $user->save();
        }
        return ($user->id);
    }

    protected function get_blog($user_id,$subject,$desc,$image)
    {
        $blog = Blog::where('user_id', $user_id)->first();
        if (!$blog)
        {
           $blog = new Blog();
           $blog->user_id = $user_id;
           $blog->subject = $subject;
           $blog->description = $desc;
           if (!empty($image))
           {
                $blog->image =$image;
           }
           $blog->save();
        }
        return ($blog->id);
    }

    protected function get_tag($name)
    {
        $tag = Tag::where('name',$name)->first();
        if (!$tag)
        {
            $tag = new Tag();
            $tag->name = $name;
            $tag->save();
        }
        return($tag->id);
    }

    protected function create_article($blog_id,$category_id,$title,$body,$article_image)
    {
        $article = new Article();
        $article->blog_id = $blog_id;
        $article->category_id = $category_id;
        $article->title = $title;
        $article->body = $body;
        $article->image = $article_image;
        $article->save();
        return ($article->id);
    }

    protected function getKeywords(string $phrase): array
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

        // Filter out stop words and return unique keywords
        //$keywords = array_diff($words, $stopWords);

        // Remove empty values and duplicates
       // $keywords = array_unique(array_filter($keywords));

        //return array_values($keywords);
    }


    protected function api_feed()
    {
        $this->call(CategorySeeder::class);
        $categories = Category::all();
        foreach ($categories as $cat)
        {
           $cat_name = strtolower($cat->name);
           $cat_articles =  $this->get_articles($cat_name);
           foreach ($cat_articles as $article)
           {
               $user_id = $this->get_user($article->author);
               echo "user_id=".$user_id."\n";
               $saved_ok = $this->saveImageFromUrl($article->urlToImage, "images/".$article->image_name);
               if ($saved_ok)
               {
                    $last_image = "images/".$article->image_name;
               }
               else
               {
                   $last_image = null; //'https://picsum.photos/200/300';
               }

               $blog_title = $article->author."'s Blog regarding ".$cat_name;
               $blog_id = $this->get_blog($user_id,$blog_title,$article->description,$last_image);
               echo "blog_id=".$blog_id."\n";
               $article_id = $this->create_article($blog_id,$cat->id,$article->title,$article->long_content,$last_image);
               echo "image_name: ".$article->image_name."\n";
               echo "article_id=".$article_id."\n\n";
               $keywords = $this->getKeywords($article->title);
               foreach ($keywords as $keyword)
               {
                    $tag_id = $this->get_tag($keyword);
                    DB::table('article_tag')->insert(['article_id'=>$article_id, 'tag_id'=>$tag_id]);
               }

           }
          // $this->print_articles($cat_name,$cat_articles);
          //echo strtolower($cat->name)."\n";
        }
    }

    public function run(): void
    {
       // $this->api_feed();


        $this->call(CategorySeeder::class);
        $this->call(UserSeeder::class);
        $this->call(BlogSeeder::class);
        $this->call(ArticleSeeder::class);
        $this->call(TagSeeder::class);
        $this->call(ArticleTagSeeder::class);
        $this->call(CommentSeeder::class);
    }

    protected function print_articles($cat_name,$articles)
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

    protected function saveImageFromUrl($url, $savePath)
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


    protected function get_articles($category)
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
           $j=0;
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
                    try
                    {
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
