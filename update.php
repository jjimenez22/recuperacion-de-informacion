<?php
   // functions for cleaning content
   require 'text_processor.php';
   //   class for getting main content of a doc
   require 'php-readability/Readability.inc.php';

   function count_stems($text, &$charvec, $item_title)
   {
      $words = extract_words($text);
      foreach ($words as $word) // for each word in current p tag
      {
         $clean_word = clean_word($word);
         if($clean_word != '')
         {
            if($charvec != NULL && array_key_exists($item_title, $charvec) && array_key_exists($clean_word, $charvec[$item_title])) // exists word already in document with name item_title
            {
               $charvec[$item_title][$clean_word]++; // aparitions of that word
            }else {
               $charvec[$item_title][$clean_word]=1;
            }
         }
      }
   }

   function update_index()
   {
      $changes_made = false;
      // db connection
      $con = new mysqli('localhost', 'root', '', 'ri');
      if($con->connect_error)
      {
         die('error: '.$com->connect_error);
      }

      // db query
      $sql = "SELECT * FROM rss";
      $result = $con->query($sql);
      $con->close();

      // RSSs interation
      if ($result->num_rows > 0)
      {
         // load persistent data from #aparitions of words
         $json_file = file_get_contents('docsvecs.json');
         if ($json_file !== false) {
            $charvec = json_decode($json_file, true);
         } else {
            $charvec = array();
         }
         // load persistent data from showable content of a doc
         $json_file = file_get_contents('showablecontent.json');
         if ($json_file !== false) {
            $showable_content = json_decode($json_file, true);
         } else {
            $showable_content = array();
         }

         // while there are rows
          while($row = $result->fetch_assoc())
          {
              $name = $row["name"];
              $link = $row["link"];

            //   open rss
              $parser = new DOMDocument();
              $parser->load($link);

              // loop through all documents
              $x = $parser->getElementsByTagName('item');
            //   set_time_limit(300); // to avoid fatal error
              for ($i=0; $i<$x->length; $i++)
              {
                $item_title=$x->item($i)->getElementsByTagName('title')->item(0)->childNodes->item(0)->nodeValue;
                if($charvec != NULL && array_key_exists($item_title, $charvec))
                  continue;
                $changes_made = true;
                $item_link=$x->item($i)->getElementsByTagName('link')->item(0)->childNodes->item(0)->nodeValue;
                $item_desc=$x->item($i)->getElementsByTagName('description')->item(0)->childNodes->item(0)->nodeValue;
               //  echo ("<p><a href='" . $item_link. "'>" . $item_title . "</a>");
               //  echo (" (<a href='" . $link. "'>" . $name . "</a>)");
               //  echo ("<br>");
               //  echo ($item_desc . "</p>");

               $showable_content[$item_title]['link'] = $item_link;
               $showable_content[$item_title]['description'] = $item_desc;

               // extract que main content
               $html = file_get_contents($item_link);
               $readability = new Readability($html);
               try {
                  $readabilityData = $readability->getContent();
               } catch (Exception $e) {
                  continue;
               }
               $content = $readabilityData['content']; // main content
               $showable_content[$item_title]['content'] = $content;
               $d_content = new DOMDocument();
               libxml_use_internal_errors(true); // this is because there are errors with html 5
               $d_content->loadHTML($content);
               libxml_clear_errors();
               $content_nodes = $d_content->getElementsByTagName('p'); // main content is distributed within p tags

               foreach ($content_nodes as $p ) // for each p tag in the content
               {
                  count_stems($p->textContent, $charvec, $item_title);
                  // if($charvec !== NULL)
                  //    break;
               }
             }
          }
      }
      // echo '<table border="1">';
      // echo '<tr>';
      // echo '<th>doc/stem</th>';
      // foreach ($charvec as $doc => $stem_list) {
      //    foreach ($stem_list as $stem => $n_aparitions) {
      //       echo '<th>'.$stem.'</th>';
      //    }
      // }
      // echo '</th>';
      // foreach ($charvec as $doc => $stem_list) {
      //    echo '<tr>';
      //    echo '<th>'.$doc.'</th>';
      //    foreach ($stem_list as $stem => $n_aparitions) {
      //       echo '<td>'.$n_aparitions.'</td>';
      //    }
      //    echo '</tr>';
      // }
      // echo '</table>';
      file_put_contents('docsvecs.json', json_encode($charvec));
      file_put_contents('showablecontent.json', json_encode($showable_content));
      
      return $changes_made;
   }
 ?>
