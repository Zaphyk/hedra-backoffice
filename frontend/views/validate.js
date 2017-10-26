

function validate(){
	if(testMode) return;
	
	jQuery.ajaxSetup({async:false});
    $.get("https://hedra-account-system.herokuapp.com/request?type=validate_token&token="+Cookies.get("token")+"&user="+Cookies.get("user"), function (data) {
    	if(JSON.parse(data) == false){
            window.location.href = "login.html";
		}
    });
	jQuery.ajaxSetup({async:true});
}

validate();