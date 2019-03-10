<?php
require_once 'session.php';
require_once 'cookie.php';
require_once 'db_func.php';
require_once 'funct.php';

if(isset($_SESSION['user243917'])){
  if(isset($_POST['points_to_insert'])){
    InsertReservationInDb($_SESSION['user243917'],$_POST['points_to_insert']);
  }
  if(isset($_POST['remove'])){
    RemoveReservationInDb($_SESSION['user243917']);
  }
}
?>

<!DOCTYPE HTML>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Home page</title>
<link rel="stylesheet" type="text/css" href="css_file.css" >
<script type="text/javascript" src="js_functions.js"></script>
</head>
<body>

<?php
echo "
  <div id='wrap'>";
    if(!isset($_SESSION['user243917'])){
      echo"
        <div id='header'>
          <h1>Home page</h1>
        </div>
        <div id='left-sidebar'>
          <ul>
            <li><a href='index.php'>Home</a></li>
            <li><a id='login' href='login.php'> Login </a></li>
            <li><a id='logout' href='signup.php'>Sign up </a></li>
          </ul>
        </div>";
    }
    else {
      echo "
        <div id='header'>
          <h1>Welcome</h1>
        </div>
        <div id='left-sidebar'>
          <div id='welcome'><p>Welcome ".$_SESSION['user243917']. " !</p></div>
          <ul>
            <li><a id='login' href='logout.php'> Logout </a></li>
          </ul>
        </div>";
    }
    echo"
      <div id='main'>";
        showMap();
    echo"
      </div>
  </div>
</body>
</html>";

  if(isset($msg))
    printMsg($msg);
?>
