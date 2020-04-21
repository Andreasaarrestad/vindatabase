<?php


session_start();

include 'api/bruker/session.php';

$content = '<h2>Min vinkjeller</h2>

        <div class="table-responsive">
            <table id="viner" class="table table-hover">
                    <thead>
                        <tr>
                            <th>Varenummer</th>
                            <th>Varenavn</th>
                            <th>Årgang</th>
                            <th>Vintype</th>
                            <th>Produsent</th>
                            <th>Land</th>
                            <th>Distrikt</th>
                            <th>Underdistrikt</th>
                            <th>Beholdning</th>
                            <th>Dato</th>
                            <th>Handling</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Varenummer</th>
                            <th>Varenavn</th>
                            <th>Årgang</th>
                            <th>Vintype</th>
                            <th>Produsent</th>
                            <th>Land</th>
                            <th>Distrikt</th>
                            <th>Underdistrikt</th>
                            <th>Beholdning</th>
                            <th>Dato</th>
                            <th>Handling</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            
            
            <br>
            
            <h4>Legg til ny vin i vinkjelleren</h4>
        
            <form role="form" class="form-inline">
                <div class="form-group mb-2">
                    <label for="varenummer" class="sr-only">Varenummer</label>
                    <input type="text" placeholder="varenummer" id="varenummer" class="form-control ">
                </div>
                <div class="form-group mx-sm-3 mb-2">
                    <label for="beholdning" class="sr-only">Beholdning</label>
                    <input type="text" placeholder="beholdning" id="beholdning" class="form-control">
                </div>
                <button type="submit" onclick="nyvin()" class="btn btn-primary mb-2">Legg til</button>
            </form>
            
            
            <div class="alert alert-success" id="success-alert">
              <button type="button" class="close" data-dismiss="alert">x</button>
              <strong>Success! </strong> La til en ny vin i vinkjelleren
            </div>




';   
  

            

include 'master.php';

?>

<script>
    $(document).ready(function() {
        $("#success-alert").hide();
       
    });  
    
    
    
    $(document).ready(function(){
        $.ajax({
            type: "POST",
            url: "api/entry/read.php",
            dataType: 'json',
            data: {
                    brukernavn: "<?php echo $login_session;?>"
                },
            success: function(data) {
                var response="";
                for(var row in data){

                    response += "<tr>"+
                    "<td>"+data[row].varenummer+"</td>"+
                    "<td>"+data[row].varenavn+"</td>"+
                    "<td>"+data[row].aargang+"</td>"+
                    "<td>"+data[row].vintype+"</td>"+
                    "<td>"+data[row].produsent+"</td>"+
                    "<td>"+data[row].land+"</td>"+
                    "<td>"+data[row].distrikt+"</td>"+
                    "<td>"+data[row].underdistrikt+"</td>"+
                    "<td>"+data[row].beholdning+"</td>"+
                    "<td>"+data[row].dato+"</td>"+
                    "<td><a href='mer.php?entryId="+data[row].entryId+"'>Mer</a> | <a href='#' onclick=remove('"+data[row].entryId+"')>Slett</a></td>"+
                    "</tr>";
                }
                $(response).appendTo($("#viner"));
            }
        });
    });
  
  function nyvin() {
        
        $.ajax(
        {
            type: "POST",
            url: 'api/entry/newentry.php',
            dataType: 'json',
            data: {
                varenummer: $("#varenummer").val(),
                brukernavn: "<?php echo $login_session;?>",
                beholdning: $("#beholdning").val()        
            },
            error: function (result) {
                alert(result.responseText);
            },
            success: function (result) {
                if (result['status'] == true) {
                    
                    $("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
                        $("#success-alert").slideUp(500);
                    });
                    
                    
                    //window.location.href = 'vinkjeller.php';
                }
                else {
                    alert(result['message']);
                    console.log(result['message']);
                }
            }
        });
    }
    
    function remove(entryId){
    var result = confirm("Sikker på at du vil fjerne vinen fra vinkjelleren?"); 
        if (result == true) { 
            $.ajax(
            {
                type: "POST",
                url: 'api/entry/deleteentry.php',
                dataType: 'json',
                data: {
                    entryId: entryId
                    
                },
                error: function (result) {
                    alert(result.responseText);
                },
                success: function (result) {
                    if (result['status'] == true) {
                        alert("Successfully fjerna vin");
                        window.location.href = 'vinkjeller.php';
                    }
                    else {
                        alert(result['message']);
                        window.location.href = 'vinkjeller.php';
                    }
                }
            });
        }
    }
    
    
    

  
  </script>