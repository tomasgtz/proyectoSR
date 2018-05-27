
function saveUser(){

    var webMethod = "http://test.mbledteq.com/serviciosWizad.php/NewUserLanding";
	
	var name = $('#namer').val();
	var email = $('#emailr').val();
	
	if(name === "" || email === ""){
		return;
	}
	
    var params = {
					"name_p" : "",
					"password_p" : "",
					"company_p" : "",
					"homephone_p" : "",
					"mobilephone_p" : ""
				}
				
				var randomstring = Math.random().toString(36).slice(-8);
				
				params.name_p 			= decodeURIComponent(email);
				params.password_p 		= randomstring;
				params.company_p 		= 4;
				params.homephone_p 		= "111111111";
				params.mobilephone_p 	= "111111111";

    $.ajax({
        type: "POST",
        url: webMethod,
        data: params,
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        success: function(data) {
            alert(data);
			$("#namer").val("");
			$("#emailr").val("");
        },
        error: function(e){
            
        }
    });
}

function Registro()
{
	var name = $('#namer').val();
	var email = $('#emailr').val();
	var randomstring = Math.random().toString(36).slice(-8);
	
	$.ajax({
		type: 'POST',
		url: 'http://test.mbledteq.com/serviciosWizad.php/NewUserLanding',
		dataType: "json",
		data : { name_p : email, password_p: randomstring, company_p: 4,  homephone_p: '', mobilephone_p: ''},	
		success: function(response){

			alert(response);
			
		},
		error: function(err){
			
 		}
		
	});
}
