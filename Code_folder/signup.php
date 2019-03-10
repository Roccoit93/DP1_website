<?php
require_once 'session.php';
require_once 'funct.php';
require_once 'db_func.php';
require_once 'cookie.php';

if(isset($_POST['username']) && isset($_POST['password'])){
  if(ValidateRegistrationValues())
    signup($_POST['username'],$_POST['password']);
}
?>

<!DOCTYPE HTML>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Signup</title>
<link href="css_file.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="js_functions.js"></script>
</head>
<body>

<?php
    echo "
      <div id='header'>
        <h1>Sign Up</h1>
      </div>
      <div id='left-sidebar'>
        <ul>
          <li><a href='index.php'>Home</a></li>
          <li><a id='login' href='login.php'> Login </a></li>
          <li><a id='logout' href='signup.php'>Sign up </a></li>
        </ul>
      </div>
      <div id='main_form'>
        <br><br><br>
        <form id='UserData' method='post' action='signup.php' >
          <h4>Please fill in this form to create an account.</h4>
          <hr><br/>
          <input type='text' id='Username' name='username'  title='Fill out this field' placeholder='Enter your email' required>
          <br/>
          <input type='password' id='Password' name='password'  title='Fill out this field' placeholder='Enter your password' required>
          <br/>
          <input type='password' id='Confirmpwd' name='confirmpwd' title='Fill out this field' placeholder='Confirm Password' required>
          <br/>
          <button type='submit' title='Click the button to sign-up' class='signupbtn' onclick='return checkRegistrationValues()'>Sign Up</button>
          <button type='button' class='cancelbtn' title='Click the button to delete the fields' onclick='reset_form()'>Cancel</button>
          <br/>
          <br/><br/>
        </form>
    </div>
</body>
</html>";
    if(isset($msg))
      printMsg($msg);
?>
