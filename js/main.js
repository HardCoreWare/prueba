// el documento debe estar listo
$(document).ready(function(){

    $("#btnSend").click(function(){

        var req = new Request("#inputOld","#inputNew");

        var json = req.getJson();
        
        $.ajax({

            url:"request.php",

            method:"POST",

            data: {"req":json},

            success: function(response){

                if(response!="error"){

                    console.log(response);

                    var table = new Table("Facturas",response,"#fileTable");

                }

                else{
                    
                    alert("not found"); 
                
                }

                
            }

        });

    });

});