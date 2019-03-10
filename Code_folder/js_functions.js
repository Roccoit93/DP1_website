function checkRegistrationValues(){
	/** Check password and email **/
	var user= document.getElementById('Username').value;
	var pwd=document.getElementById('Password').value;
	var conf_pwd=document.getElementById('Confirmpwd').value;
	var regex_pwd=/[\'\/~`\!@#\$%\^&\*\(\)_\-\+=\{\}\[\]\|;:\"\<\>,\.\?]{2,}/;
	var regex_email=/^([a-z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/;/**il dominio puo avere da 2 a 6 caratteri a causa del TLD specifico per nazione (.ny.us or .co.uk.)**/

	if( (user==="") || (pwd==="") || (conf_pwd==="")){
		window.alert("You miss a field! Please fill it before send your request!");
		return false;
	}
	else{
			/** Check if username is valid **/
		if(regex_email.test(user)==false){
			alert("Username is not well formed! Please insert a valid email address");
			return false;
		}
		else{
		/** If the passwords are the same **/
			if(pwd===conf_pwd){
			/** check that password contains at least 2 special characters **/
				if(regex_pwd.test(pwd)==true){
					//alert("Password is well formed");
					return true;
				}
				else {
					alert("Password must contain at least 2 special character! Please check it!");
					return false;
				}
			 }
			else{
				alert("Passwords must be the same! Please check it!")
				return false;
			}
 		}
 }
}

function reset_form(){
  document.getElementById("UserData").reset();
 }
