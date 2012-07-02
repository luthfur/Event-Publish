function hideEditAccountForm() {
	
	// clean form before hiding
	
	var form = document.getElementById("edit_account");
	form.style.display = "none";
}



function showEditAccountForm() {
	
	// load data before showing
	
	var form = document.getElementById("edit_account");
	form.style.display = "block";
}



function hideNewAccountForm() {
	
	//clean form before hiding
	
	var form = document.getElementById("new_account");
	form.style.display = "none";
}



function showNewAccountForm() {
	
	var form = document.getElementById("new_account");
	form.style.display = "block";
	
}


function addNewAccount() {
	
	document.getElementById("user_name_error").style.display = "none";
	document.getElementById("password_error").style.display = "none";
	document.getElementById("user_email_error").style.display = "none";
	
	//if(validateNewAccount() == true) {
		document.getElementById("new_account_form").submit();
	//}
}

function validateNewAccount() {

	var errors = 0;
	
	// check user name
	if (document.getElementById("user_name").value.trim() == "") {
		
		// display user_name error
		document.getElementById("user_name_error").style.display = "inline";
		
		errors++;
	}
	
	// check password
	if (document.getElementById("password").value.trim() == "" && document.getElementById("auto_password").checked == false) {
		
		// display password error
		document.getElementById("password_error").style.display = "inline";
		
		errors++;
	}
	
	//check email
	if (document.getElementById("user_email").value.trim() == "" || /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(document.getElementById("user_email").value) != true) {
		
		// display user_email error
		document.getElementById("user_email_error").style.display = "inline";
		
		errors++;
	}
	
	
	if(errors > 0) return false;
	
	return true;

}


function togglePassword() {
	
	
	if(document.getElementById("auto_password").checked) {
		document.getElementById("password").style.display = "none";
	} else {
		document.getElementById("password").style.display = "inline";
	}
	
}


function sendNewPassword(){
	
	var account_id = document.getElementById("account_id");
	var user_email = document.getElementById("user_email");
	
	// show processing message
	document.getElementById("password_info").style.display = "none";
	document.getElementById("sending_message").style.display = "inline";
	document.getElementById("password_sent_message").style.display = "none";
	document.getElementById("error_sending_password").style.display = "none";
	
	
	var query_string = "account_id=" + account_id.value + "&user_email=" + user_email.value;
	var loader = new net.ContentLoader('process/new_password.php', showPasswordMessage, showError, 'POST', query_string);

}



function showPasswordMessage(){
	
	var response  = this.req.responseText;	
	
	//alert(response);
	
	// hide processing message
	document.getElementById("sending_message").style.display = "none";
	
	if(response == "1") {
		
		//show success message
		document.getElementById("password_sent_message").style.display = "inline";
		
	} else {
		
		// show error message
		document.getElementById("error_sending_password").style.display = "inline";
		
	}
	
	
	

}




function validateAccountUpdate() {

	var errors = 0;
	
	//check email
	if (document.getElementById("user_email").value.trim() == "" || /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(document.getElementById("user_email").value) != true) {
		
		// display user_email error
		document.getElementById("user_email_error").style.display = "inline";
		
		errors++;
	}	
	
	if(errors > 0) return false;
	
	return true;

}


function updateAccount() {
	if(validateAccountUpdate() == true) {
		document.getElementById("account_update").submit();
	}
}





