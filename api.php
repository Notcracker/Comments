<?php 


  $host = "localhost";
  $user = "root";
  $pass = "password";

  $databaseName = "comments";
  $tableName = "comments";
  $con = mysql_connect($host,$user,$pass);
  $createTable = "CREATE TABLE `$tableName` (  `id` smallint(5) unsigned NOT NULL auto_increment,  `parent_id` smallint(5) unsigned,   `message` text NOT NULL default '',  `depth` smallint(5) unsigned, PRIMARY KEY (`id`),  FOREIGN KEY (`parent_id`) REFERENCES `$tableName`(`id`) ON DELETE CASCADE  ) COMMENT='List of comments';";


  if (!$con) {
     echo 'Could not connect: ' . mysql_error();
  }

  $db= mysql_select_db($databaseName, $con);

//create db and table if not exist:
if (!$db) {
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

 

//fetching comments
 function gC($id){
  if ($id==="NULL"){
    $result = mysql_query("SELECT * FROM comments WHERE parent_id is $id;");
  } else {
    $result = mysql_query("SELECT * FROM comments WHERE parent_id = $id;");
  }
   
   if($result){
   echo "<ul>";

   while ($row = mysql_fetch_assoc($result)) {
     if ($row['depth']<5){
       echo "<li><blockquote><p><h4>".$row['message']."</p></h4></blockquote><a onclick='comment(".$row['id'].','.$row['depth'].")'>Comment</a>\n\n<a onclick='deleteCom(".$row['id'].")' id='".$row['id']."'>Delete</a></li>";
       $id = $row['id'];
       gC($id);
    } else {
       echo "<li><blockquote><p><h4>".$row['message']."</p></h4></blockquote><a onclick='deleteCom(".$row['id'].")' id='".$row['id']."'>Delete</a></li>";
       
    }
   }

   echo "</ul>";

  }

 }




// treatment of ajax calls

if($_SERVER['REQUEST_METHOD']=="GET"){
  gC("NULL");
}
elseif ($_SERVER['REQUEST_METHOD']=="POST") {

 

  
  parse_str($_POST['vals'], $data);
  parse_str($_POST['parent_id'], $parent_id);
  parse_str($_POST['depth'], $depth);

 
  $parent_id = key($parent_id);
  $depth = key($depth);

  $message = $data['text'];
  
  if ($parent_id){
    $result = mysql_query("INSERT INTO comments SET message = '$message', parent_id = '$parent_id', depth = '$depth';");
  } else {
    $result = mysql_query("INSERT INTO comments SET message = '$message', depth = '$depth';");
  }
  


  gC("NULL");
}
elseif ($_SERVER['REQUEST_METHOD']=="PUT") {

    
    parse_str(file_get_contents("php://input"), $id);
    $id = $id['id'];
    $result = mysql_query("DELETE FROM $tableName WHERE id='$id';");
    gC("NULL");
}

?>
