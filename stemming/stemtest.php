<?php 

    include 'porter.php';
    $file_content = file_get_contents("voc.txt") or die("not openned");
    $words = preg_split('/[\s]+/', $file_content, -1, PREG_SPLIT_NO_EMPTY);
    
    foreach($words as $word)
    {
        $stem = PorterStemmer::Stem($word);
        echo $stem."<br>";
    }

?>