<?php 


  

   function getComments($value=''){
    $host = "localhost";
    $user = "root";
    $pass = "Vfhnbim1";

    $databaseName = "comments";
    $tableName = "comments";

    
    $con = mysql_connect($host,$user,$pass);
    $dbs = mysql_select_db($databaseName, $con);



    $result = mysql_query("SELECT * FROM $tableName WHERE parent_id is NULL;");          
    
    echo '<ul class="col-md-offset-2">';
    while ($row = mysql_fetch_assoc($result)) {
    
      echo "<li><blockquote><p><h4>".$row['message']."</p></h4></blockquote><a onclick='comment(".$row['id'].")' id=".$row['id'].">Comment</a></li>";


      $me = $row['id'];
      $children = mysql_query("SELECT * FROM $tableName WHERE parent_id = $me;");

      if($children){
        echo "<ul>";
        while ($chi1 = mysql_fetch_assoc($children)) {
          echo "<li><blockquote><p><h4>".$chi1['message']."</p></h4></blockquote><a onclick='comment(".$chi1['id'].")' id=".$chi1['id'].">Comment</a></li>";

          $me1 = $chi1['id'];
          $children2 = mysql_query("SELECT * FROM $tableName WHERE parent_id = $me1;");

          if($children2){
           
            echo "<ul>";
            while ($chi2 = mysql_fetch_assoc($children2)){
              
              echo "<li><blockquote><p><h4>".$chi2['message']."</p></h4></blockquote><a onclick='comment(".$chi2['id'].")' id=".$chi2['id'].">Comment</a></li>";

              $me2 = $chi2['id'];
              $children3 = mysql_query("SELECT * FROM $tableName WHERE parent_id = $me2;");
              
              if($children3){
                
                while ($chi3 = mysql_fetch_assoc($children3)){
                  
                  echo "<li><blockquote><p><h4>".$chi3['message']."</p></h4></blockquote><a onclick='comment(".$chi3['id'].")' id=".$chi3['id'].">Comment</a></li>";
                }
                
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
  getComments();
}
if ($_SERVER['REQUEST_METHOD']=="POST") {

  $host = "localhost";
  $user = "root";
  $pass = "Vfhnbim1";

  $databaseName = "comments";
  $tableName = "comments";

 
  $con = mysql_connect($host,$user,$pass);
  $dbs = mysql_select_db($databaseName, $con);

  parse_str($_POST['vals'], $data);
  $message = $data['text'];

  
  $result = mysql_query("INSERT INTO comments SET message = '$message';");
  
  


  getComments();
}
  ?>
