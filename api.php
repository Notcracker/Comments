<?php 


  $host = "localhost";
  $user = "root";
  $pass = "Vfhnbim1";

  $databaseName = "comments";
  $tableName = "comments";
  $con = mysql_connect($host,$user,$pass);
  $createTable = "CREATE TABLE `$tableName` (  `id` smallint(5) unsigned NOT NULL auto_increment,  `parent_id` smallint(5) unsigned,   `message` text NOT NULL default '',   PRIMARY KEY (`id`),  FOREIGN KEY (`parent_id`) REFERENCES `$tableName`(`id`) ON DELETE CASCADE  ) COMMENT='List of comments';";


  if (!$con) {
     echo 'Could not connect: ' . mysql_error();
  }

  $db= mysql_select_db($databaseName, $con);


if (!$db) {
  // If we couldn't, then it either doesn't exist, or we can't see it.
  $sql = "CREATE DATABASE $databaseName";

  if (mysql_query($sql)) {
      echo "Database my_db created successfully\n";
       mysql_select_db($databaseName, $con);
      if(mysql_query($createTable)){
        echo "Table created!";

      } else {
        echo 'Error creating table:'.mysql_error() . "\n";
      }
    }

  } 

 

 

  
  
  

   function getComments($tableName){
   



    $result = mysql_query("SELECT * FROM $tableName WHERE parent_id is NULL;");          
    
    echo '<ul>';

    while ($row = mysql_fetch_assoc($result)) {
    
      echo "<li><blockquote><p><h4>".$row['message']."</p></h4></blockquote><a onclick='comment(".$row['id'].")' id=".$row['id'].">Comment</a>\n\n<a onclick='deleteCom(".$row['id'].")' id=".$row['id'].">Delete</a></li>";


      $me = $row['id'];
      $children = mysql_query("SELECT * FROM $tableName WHERE parent_id = $me;");

      if($children){
        echo "<ul>";
        while ($chi1 = mysql_fetch_assoc($children)) {
          echo "<li><blockquote><p><h4>".$chi1['message']."</p></h4></blockquote><a onclick='comment(".$chi1['id'].")' id=".$chi1['id'].">Comment</a>\n\n<a onclick='deleteCom(".$chi1['id'].")' id=".$chi1['id'].">Delete</a></li>";

          $me1 = $chi1['id'];
          $children2 = mysql_query("SELECT * FROM $tableName WHERE parent_id = $me1;");

          if($children2){
           
            echo "<ul>";
            while ($chi2 = mysql_fetch_assoc($children2)){
              
              echo "<li><blockquote><p><h4>".$chi2['message']."</p></h4></blockquote><a onclick='comment(".$chi2['id'].")' id=".$chi2['id'].">Comment</a>\n\n<a onclick='deleteCom(".$chi2['id'].")' id=".$chi2['id'].">Delete</a></li>";

              $me2 = $chi2['id'];
              $children3 = mysql_query("SELECT * FROM $tableName WHERE parent_id = $me2;");
              
              if($children3){
                echo "<ul>";
                while ($chi3 = mysql_fetch_assoc($children3)){
                  
                  echo "<li><blockquote><p><h4>".$chi3['message']."</p></h4></blockquote><a onclick='comment(".$chi3['id'].")' id=".$chi3['id'].">Comment</a>\n\n<a onclick='deleteCom(".$chi3['id'].")' id=".$chi3['id'].">Delete</a></li>";
                
                  $me3 = $chi3['id'];
                  $children4 = mysql_query("SELECT * FROM $tableName WHERE parent_id = $me3;");
                  
                  if($children4){
                    echo "<ul>";
                    while ($chi4 = mysql_fetch_assoc($children4)){
                  
                      echo "<li><blockquote><p><h4>".$chi4['message']."</p></h4></blockquote><a onclick='comment(".$chi4['id'].")' id=".$chi4['id'].">Comment</a>\n\n<a onclick='deleteCom(".$chi4['id'].")' id=".$chi4['id'].">Delete</a></li>";
                      $me4 = $chi4['id'];
                      $children5 = mysql_query("SELECT * FROM $tableName WHERE parent_id = $me4;");

                      if($children5){
                        echo "<ul>";
                        while ($chi5 = mysql_fetch_assoc($children5)){
                          echo "<li><blockquote><p><h4>".$chi5['message']."</p></h4></blockquote><a onclick='deleteCom(".$chi5['id'].")' id=".$chi5['id'].">Delete</a></li>";

                        }
                        echo "</ul>";
                      }
                    }

                    echo "</ul>";
                  }
                }
                echo "</ul>";
              }
            }
            echo "</ul>";
          }
        }
        echo "</ul>";
      }
      
    
    }
    echo '</ul>';
   
  }
  
if($_SERVER['REQUEST_METHOD']=="GET"){
  getComments($tableName);
}
elseif ($_SERVER['REQUEST_METHOD']=="POST") {

 

  
  parse_str($_POST['vals'], $data);
  parse_str($_POST['parent_id'], $parent_id);

  $first_key = key($parent_id);
  

  $message = $data['text'];

  if ($first_key){
    $result = mysql_query("INSERT INTO comments SET message = '$message', parent_id = '$first_key';");
  } else {
    $result = mysql_query("INSERT INTO comments SET message = '$message';");
  }
  


  getComments($tableName);
}
elseif ($_SERVER['REQUEST_METHOD']=="PUT") {

    
    parse_str(file_get_contents("php://input"), $id);
    $id = $id['id'];
    $result = mysql_query("DELETE FROM $tableName WHERE id='$id';");
    getComments($tableName);
}

?>
