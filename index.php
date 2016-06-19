                                        

<!---------------------------------------------------------------------------
Example client script for JQUERY:AJAX -> PHP:MYSQL example
---------------------------------------------------------------------------->

<html>
  <head>    
  <script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
    <link rel="stylesheet" href="https://bootswatch.com/cerulean/bootstrap.min.css">
  <script id="source" language="javascript" type="text/javascript">
  </script>
  </head>
  <body>

  <!-------------------------------------------------------------------------
  1) Create some html content that can be accessed by jquery
  -------------------------------------------------------------------------->
  <div class='col-md-offset-2'>
    <h2> Client example </h2>
    <h3>Output: </h3>
  </div>
  <div id="output">this element will be accessed by jquery and this text replaced</div>
  <form class="form-horizontal" name="feedbackForm" id='idForm' novalidate>
      <div class="form-group">
          <label for="firstname" class="col-sm-2 control-label">Name</label>
          <div class="col-md-6">
              <input type="text" class="form-control" id="firstname" name="name" placeholder="Enter Name"  required>
          </div>
      </div>                 
      <div class="form-group">
          <label for="feedback" class="col-sm-2 control-label">Your Comment</label>
          <div class="col-md-6">
              <textarea class="form-control" rows="12" id='Mir' name='text'></textarea>
          </div>
      </div> 
      <div class="form-group">
          <div class="col-md-6 col-md-offset-2">
              <button type="submit" class="btn btn-primary">Send Comment</button>
          </div>
      </div>
  </form>

  <script id="source" language="javascript" type="text/javascript">

  $(function () 
  {
    //-----------------------------------------------------------------------
    // 2) Send a http request with AJAX http://api.jquery.com/jQuery.ajax/
    //-----------------------------------------------------------------------
    $.ajax({
      url: 'api.php',                  //the script to call to get data          
      data: "",                        //you can insert url argumnets here to pass to api.php
                                       //for example "id=5&parent=6"
      dataType: 'html',                //data format      
        success: function(data)          //on recieve of reply
      {
      //  var id = data[0];              //get id
       // var vname = data[1];           //get name
        //--------------------------------------------------------------------
        // 3) Update html content
        //--------------------------------------------------------------------
       
        $('#output').html(data); //Set output element html
        //recommend reading up on jquery selectors they are awesome 
        // http://api.jquery.com/category/selectors/
      } 
        });

      $("#idForm").submit(function(e) {


        $.ajax({
                   type: "POST",
                   url: 'api.php',
                   data: {'vals' : $("#idForm").serialize()}, 
                   success: function(data)
                   {
                      console.log(data);
                       alert(data);
                       $('#output').html(data);  
                   }
                 });
        $('#idForm textarea').val('');
            e.preventDefault(); // avoid to execute the actual submit of the form.
        });


      
      }); 


      function comment(a){
        var commentForm = '<form class="form-horizontal" name="feedbackForm" id="'+a+'nnn'+'"" novalidate>
                            <div class="form-group">
                                <label for="firstname" class="col-sm-2 control-label">Name</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="firstname" name="name" placeholder="Enter Name"  required>
                                </div>
                            </div>                 
                            <div class="form-group">
                                <label for="feedback" class="col-sm-2 control-label">Your Comment</label>
                                <div class="col-md-6">
                                    <textarea class="form-control" rows="12" id="Mir" name="text"></textarea>
                                </div>
                            </div> 
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-2">
                                    <button type="submit" class="btn btn-primary">Send Comment</button>
                                </div>
                            </div>
                        </form>';

        if($("#"+a+'nnn').length===0){
         
          $('#' + a).after(commentForm);
          

        } else {
          $("#"+a+'nnn').remove();
          
          console.log($("#"+a+'nnn'));
        }
      };
  </script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
  </body>
</html>
