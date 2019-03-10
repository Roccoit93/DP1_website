<?php
require_once 'session.php';
require_once 'cookie.php';
require_once 'funct.php';
require_once 'db_func.php';
?>

<!DOCTYPE HTML>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Login</title>
<link href="css_file.css" rel="stylesheet" type="text/css">
<script>
  function reset_form(){
    document.getElementById("UserData").reset();
  }
</script>
</head>
<body>

<?php
  if(isset($_POST['uname']) && isset($_POST['psw']))
    login($_POST['uname'],$_POST['psw']);

    echo "
        <div id='header'>
          <h1>Login</h1>
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
            <form id='UserData' method='post' action='login.php' >
  					    <input type='text' title='Fill out this field' placeholder='Enter your email' name='uname' required>
                <br/>
  					    <input type='password' title='Fill out this field' placeholder='Enter your password' name='psw' required>
                <br/>
                <button title='Click the button to login' type='submit'>Login</button>
                <button  title='Click the button to delete the fields' type='button' class='cancelbtn'  onclick='reset_form()'>Cancel</button>
                <br/>
                <br/><br/>
       				</form>
          </div>
          </body>
          </html>
          ";
      if(isset($msg))
        printMsg($msg);
?>
