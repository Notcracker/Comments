
<html>
  <head>    
  <script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
    <link rel="stylesheet" href="https://bootswatch.com/cerulean/bootstrap.min.css">
  
  </head>
  <body>

 
  
 <div class='container-fluid'>
    <div class='jumbotron'>
      <h1>Some Article</h1>
    </div>
  </div>
  <hr>
  <div id="output"></div>
  <hr>
  <form class="form-horizontal" name="feedbackForm" id='idForm' novalidate>               
      <div class="form-group">
          <label for="comment" class="col-sm-2 control-label">Your Comment</label>
          <div class="col-md-4">
              <textarea class="form-control" rows="12" id='comment' name='text'></textarea>
          </div>
      </div> 
      <div class="form-group">
          <div class="col-md-4 col-md-offset-2">
              <button type="submit" class="btn btn-primary">Send Comment</button>
          </div>
      </div>
  </form>

  <script id="source" language="javascript" type="text/javascript">

  $(function () 
  {
    $.ajax({
      url: 'api.php',                         
      data: "",                        
      dataType: 'html',                      
        success: function(data)          
      {
      
        $('#output').html(data); //Set output element html
       
      } 
        });

      $("#idForm").submit(function(e) {


        $.ajax({
                   type: "POST",
                   url: 'api.php',
                   data: {'vals' : $("#idForm").serialize(), 'parent_id':null}, 
                   success: function(data)
                   {
                      
                       alert(data);
                       $('#output').html(data);  
                   }
                 });
        $('#idForm textarea').val('');
            e.preventDefault(); 
        });


      
      }); 


      function comment(a){
        var commentForm = '<form class="form-horizontal" name="feedbackForm" id=' + a + 'nnn' + ' novalidate><div class="form-group"><label for="feedback"  control-label">Your Comment</label><div class="col-md-3"><textarea class="form-control" rows="12" id="Mir" name="text"></textarea></div></div><div class="form-group"> <div class="col-md-3 col-md-offset-2"><button type="submit" class="btn btn-primary">Send Comment</button></div></div></form>';

        if($("#"+a+'nnn').length===0){
         
          $('#' + a).after(commentForm);
          

        } else {
          $("#"+a+'nnn').remove();
          
          console.log($("#"+a+'nnn'));
        }


      $("#"+a+'nnn').submit(function(e) {


        $.ajax({
                   type: "POST",
                   url: 'api.php',
                   data: {'vals' : $("#"+a+'nnn').serialize(),'parent_id':a}, 
                   success: function(data)
                   {
                       $('#output').html(data);  
                   }
                 });
          e.preventDefault();
        });

      };

      function deleteCom(a) {

        $.ajax({
                   type: "PUT",
                   url: 'api.php',
                   data: {'id':a}, 
                   success: function(data)
                   {
                       $('#output').html(data);  
                   }
                 });
        
      }
  </script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
  </body>
</html>
