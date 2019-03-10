<?php
require_once 'session.php';
require_once 'cookie.php';

if(isset($_SESSION['msg243917'])){
  echo "<p>".$_SESSION['msg243917']."</p>";
}
  if($_SESSION['msg243917']!='The connection with database is not possible!'){
    echo"
      <p class='darkgray'>Click <a href='index.php'>here</a> to go back to the previous page!</p>";}
  else{
    echo"
      <p class='darkgray'>Please make the database visible and click <a href='index.php'>here</a> to go back to home page!</p>";
  }

  ?>
