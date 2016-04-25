<?php
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
       // while there are rows
       while($row = $result->fetch_assoc())
       {
           $name = $row["name"];
           $link = $row["link"];

         //   open rss
           $parser = new DOMDocument();
           $parser->load($link);

         //   class for getting main content
            require '../php-readability/Readability.inc.php';
           // loop through all documents
           $x = $parser->getElementsByTagName('item');
           set_time_limit(300); // to avoid fatal error
           for ($i=0; $i<$x->length; $i++)
           {
            //  $item_title=$x->item($i)->getElementsByTagName('title')->item(0)->childNodes->item(0)->nodeValue;
             $item_link=$x->item($i)->getElementsByTagName('link')->item(0)->childNodes->item(0)->nodeValue;
            //  $item_desc=$x->item($i)->getElementsByTagName('description')->item(0)->childNodes->item(0)->nodeValue;
            //  echo ("<p><a href='" . $item_link. "'>" . $item_title . "</a>");
            //  echo (" (<a href='" . $link. "'>" . $name . "</a>)");
            //  echo ("<br>");
            //  echo ($item_desc . "</p>");

            $html = file_get_contents($item_link);
            $readability = new Readability($html);
            try {
               $readabilityData = $readability->getContent();
            } catch (Exception $e) {
               continue;
            }
            echo "<p><h1>".$readabilityData['title']."</h1>";
            echo $readabilityData['content']."</p><hr>";
          }
       }
   } else
   {
       echo "0 results";
   }
 ?>
