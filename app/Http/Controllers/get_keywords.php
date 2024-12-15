<?php

// Sample article text
$article = "PHP is a popular general-purpose scripting language that is especially suited to web development. It is a fast, flexible, and pragmatic language.";

// Function to remove stop words from the article text
function removeStopWords($text) {
    $stopWords = array("a", "an", "the", "and", "but", "or", "for", "nor", "on", "at", "by", "with", "as", "to", "of", "in", "from", "that", "which", "who", "whom", "this", "these", "those", "there", "is", "are", "was", "were", "will", "shall", "have", "had", "do", "does", "did", "I", "you", "he", "she", "it", "we", "they");

    $words = explode(" ", $text);  // Split text into words
    $filteredWords = array_filter($words, function($word) use ($stopWords) {
        return !in_array(strtolower($word), $stopWords);  // Exclude stop words
    });

    return implode(" ", $filteredWords);
}

// Function to get keywords from the article
function getKeywords($article) {
    // Clean and prepare the article
    $article = removeStopWords($article);  // Remove stop words
    $article = strtolower($article);  // Convert to lowercase
    $article = preg_replace("/[^a-z0-9\s]/", "", $article);  // Remove non-alphanumeric characters

    // Tokenize the article into words
    $words = explode(" ", $article);

    // Count word frequency
    $wordCount = array_count_values($words);

    // Sort words by frequency in descending order
    arsort($wordCount);

    // Get top N keywords (e.g., top 5 keywords)
    $keywords = array_slice($wordCount, 0, 5);

    return $keywords;
}

// Get the keywords from the article
$keywords = getKeywords($article);

// Display the keywords
echo "Top keywords from the article:\n";
print_r($keywords);

?>
