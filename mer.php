<?php

session_start();

include 'api/bruker/session.php';

$entryId = $_GET['entryId'];

$content = '
        
        
            <div class="row">
                <div class="col-md-2">
                    <img id="vinBilde"  class="col-sm-12">
                </div>
                <div class="col-md-10">
                     
                     <h2 id="varenavn">Vinnavn + årgang</h2>
                     <p style="text-transform:uppercase;" id="vintype"><small>Vintype</small></p>
                     <h4 id="lokasjon"></h4>
                        
                        <div class="row">
                            <div class="col-md-10">
                                <fieldset class="rating">
                                    <input type="radio" id="star10" name="rating" value="10" /><label class = "full" for="star10" title="10"></label>
                                    <input type="radio" id="star9" name="rating" value="9" /><label class = "full" for="star9" title="9"></label>
                                    <input type="radio" id="star8" name="rating" value="8" /><label class = "full" for="star8" title="8"></label>
                                    <input type="radio" id="star7" name="rating" value="7" /><label class = "full" for="star7" title="7"></label>
                                    <input type="radio" id="star6" name="rating" value="6" /><label class = "full" for="star6" title="6"></label>
                                    <input type="radio" id="star5" name="rating" value="5" /><label class = "full" for="star5" title="5"></label>
                                    <input type="radio" id="star4" name="rating" value="4" /><label class = "full" for="star4" title="4"></label>
                                    <input type="radio" id="star3" name="rating" value="3" /><label class = "full" for="star3" title="3"></label>
                                    <input type="radio" id="star2" name="rating" value="2" /><label class = "full" for="star2" title="2"></label>
                                    <input type="radio" id="star1" name="rating" value="1" /><label class = "full" for="star1" title="1"></label>
                                </fieldset>
                            </div>
                            <div class="col-md-2">
                                <input type="number" class="col-md-12" id="beholdning" min="0" max="9999"> 
                            </div>
                        </div>

                        <br><br>   
                        <form>
                            <div class="form-group">
                                
                                <textarea id="notater" rows="12" class="col-sm-12 form-control" placeholder="Skriv et notat">
                                </textarea>
                            </div>
                        </form>
                        
                        <br>
                    
                        
                        

                        

                </div>
            </div>
           
           
        
        
            
        
        
        
           
    
            
            
            
            <br>

         
            
           
            
           ';
            

        
                    
            
include 'master.php';

?>

<script>
    
    
    $(document).ready(function(){
        $.ajax({    
            type: "GET",
            url: "api/entry/readsingle.php?entryId=<?php echo $entryId; ?>",
            dataType: 'json',
            success: function(data) {  
                
                
                document.getElementById("vinBilde").src = "https://bilder.vinmonopolet.no/cache/515x515-0/"+data['varenummer']+"-1.jpg";
                
                
                document.getElementById("varenavn").innerHTML = data['varenavn'] + ", " + data['aargang'];
                document.getElementById("vintype").innerHTML = data['vintype'];
                
                var lokasjon = data['land'];
                
                if (data['distrikt'] != "") {
                    lokasjon += ", " + data['distrikt'];
                    
                    if (data['underdistrikt'] != "") {
                        lokasjon += ", " + data['underdistrikt'];
                    }
                }
                
                
               
                
                document.getElementById("lokasjon").innerHTML = lokasjon;
                
                document.getElementById("notater").innerHTML = data['notater'];
                document.getElementById("beholdning").value = data['beholdning'];
                
                
                
                if(!isNaN(parseInt(data['minvurdering']))) {
                    var ele = document.getElementsByName('rating'); 
                    ele[10-parseInt(data['minvurdering'])].checked = true;
                }
                
                

            },
            error: function (result) {
                    console.log(result);
            }
        });
    });
    
    window.onbeforeunload = closingCode;
    function closingCode(){
        $.ajax({
            type: "POST",
            url: 'api/entry/updateentry.php',
            dataType: 'json',
            data: {
                entryId: "<?php echo $_GET['entryId']; ?>",
                minvurdering: getRadioValue(),
                beholdning: document.getElementById("beholdning").value,
                notater: document.getElementById("notater").value
                

            },
            error: function (result) {
                alert(result.responseText);
            },
            success: function (result) {
                if (result['status'] == false) {
                    console.log(result['message']);
                    
                }
                
            }
        });
    };
    
    function getRadioValue() { 
        var ele = document.getElementsByName('rating'); 

        for(i = 0; i < ele.length; i++) { 
            if(ele[i].checked) {
                return ele[i].value;
            } 
        }
    }
  </script>