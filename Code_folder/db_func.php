<?php
/**This file contains the functions that interact with database**/
$db_host="localhost";
$db_user="root";
$db_pass="";
$db_name="s243917";

$conn=@mysqli_connect($db_host,$db_user,$db_pass,$db_name);
if(!$conn){
  $_SESSION['msg243917']="The connection with database is not possible!";
  header( "Location: whitepage.php");
}

function sanitizeString($var){
  global $conn;
  if(!$conn){
    $_SESSION['msg243917']="The connection with database is not possible!";
    header( "Location: whitepage.php");
  }

	$var=strip_tags($var); #strip the string from html tag
	$var=htmlentities($var); # convert characters to HTML entities.
	$var=stripslashes($var);#remove backslashes
	$var=mysqli_real_escape_string($conn,$var);#escape special characters in a string for use in an SQL statement.
	return $var;
}

function signup($user, $pwd) {
  global $msg;
  global $conn;
  if (!$conn) {
    $_SESSION['msg243917']="The connection with database is not possible!";
    header( "Location: whitepage.php");
  }
  $username = sanitizeString($user);
  $password = md5($pwd);

  if($username==''||$password=='')
    return;

  mysqli_autocommit($conn,FALSE);
  $res = mysqli_query($conn, "SELECT COUNT(*) FROM users WHERE username='$username' LOCK IN SHARE MODE"); //LOCK in SHARE MODE - lock while the table in write mode for preventing a concurrency access
  $row =mysqli_fetch_row($res);// mysqli_fetch_row extracts the rows from $res and put it in an array
  if ($row[0] != 0) {
    mysqli_rollback($conn);
    mysqli_autocommit($conn,TRUE);
    $msg = 'The username is already registered';
    return;
  }
  else{
    $res = mysqli_query($conn, "INSERT INTO users(username,password) VALUES ('$username','$password')");
    if (!$res) {
      mysqli_rollback($conn);
      mysqli_autocommit($conn,TRUE);
      $msg ="The insert in database it was not successful!";
      return;
    }
    mysqli_commit($conn);
    mysqli_autocommit($conn,TRUE);
    $msg ="The registration is completed!";
    login($user, $pwd);
  }
}


function login($user, $pwd) {
    global $conn;
    global $msg;
    if (!$conn) {
      $_SESSION['msg243917']="The connection with database is not possible!";
      header( "Location: whitepage.php");
    }
    $username =sanitizeString($user);
    $password =md5($pwd); // Password can contains special characters then i didn't sanitize it
    $res = mysqli_query($conn,"SELECT COUNT(*) FROM users WHERE username='$username' AND password='$password'");
    $row =mysqli_fetch_row($res);// mysqli_fetch_row extracts the rows from $res and put it in an array

    if ($row[0] == 1) { // if the query returns that count is equal to 1 I set the session variables and I go to homepage
        $_SESSION['user243917'] = $username;
        $_SESSION['password243917'] = $pwd;
        $_SESSION['time243917'] = time();
        echo"
          <script type='text/javascript'>
          setTimeout(function(){window.location.href='index.php'},0)</script>";
    }
    else
       $msg = "Wrong username or password! Please check it!";
       return;
  }

  function getMap(){
  global $conn;
  global $msg;
  if (!$conn) {
      $_SESSION['msg243917']="The connection with database is not possible!";
      header( "Location: whitepage.php");
  }

  $res=mysqli_query($conn,"SELECT * FROM locations");
  if (!$res) {
      $msg ="Failure of query!";
      return;
  }
  return createMap($res);
}

function createMap($query){
  $map=array();
  while($row=mysqli_fetch_assoc($query)){
    $point = array("user_id" =>  $row['user_id'],"x" =>  $row['x'] ,"y" =>  $row['y'],"timestamp" => $row['timestamp']);
    array_push($map, $point);
  }
  return $map;
}

function InsertReservationInDb($user,$list_points){
  global $conn;
  //global $msg;
  $k=0;
  $blackpoints=0;
  $list_points_sorted=array();

  $list_points_array=preg_split("/;/",$list_points);
  if (!$conn) {
    $_SESSION['msg243917']="The connection with database is not possible!";
    header( "Location: whitepage.php");
  }

  $totpoints=sizeof($list_points_array);

  for($j=0;$j<sizeof($list_points_array);$j++){
    $single_point_array_to_sort=preg_split("/,/",$list_points_array[$j]);
    $x=intval($single_point_array_to_sort[0]);
    if($x==0){
      $_SESSION['msg243917'] =' Your selection is not valid! Please select green or black circles!';
      header( "Location: whitepage.php");}

    if($single_point_array_to_sort[3]=='black'){
      $blackpoints=$blackpoints+1;
      $val=$list_points_array[$j];
      array_unshift($list_points_sorted,$val);
    }
    else if ($single_point_array_to_sort[3]=='green') {
      $list_points_sorted[sizeof($list_points_array)-$k-1]=$list_points_array[$j];
      $k=$k+1;
   }

  }

  $greenpoints=$totpoints-$blackpoints;
  for($i=0;$i<sizeof($list_points_sorted);$i++){
    $single_point_array=preg_split("/,/",$list_points_sorted[$i]);
    $x=intval($single_point_array[0]);
    $num=400;
    $y=intval($single_point_array[1]);
    $y_fin=$num-$y;
    mysqli_autocommit($conn,FALSE);
    $res=mysqli_query($conn,"UPDATE locations SET user_id='$user',timestamp=now() WHERE user_id='' and x='$x'and y='$y_fin'");

    if (mysqli_affected_rows($conn)==0) {
      if($blackpoints==1 && $greenpoints>1){
      $_SESSION['msg243917'] ='<strong>Partial failure of the selection!</strong><br> '.$greenpoints.' of selected points were already assigned and they are not selectable!<br> '.$blackpoints.' of selected points was not assigned and it has been selected!';
      }
      if($blackpoints>1 && $greenpoints>1){
      $_SESSION['msg243917'] ='<strong>Partial failure of the selection!</strong><br> '.$greenpoints.' of selected points were already assigned and they are not selectable! <br>'.$blackpoints.' of selected points were not assigned and they have been selected!';
      }
      if($blackpoints==0 && $greenpoints>1){
      $_SESSION['msg243917'] ='<strong>Failure of the selection!</strong><br> The'.$greenpoints.' selected points were already assigned and they are not selectable! ';
      }
      if($blackpoints==0 && $greenpoints==1){
      $_SESSION['msg243917'] ='<strong>Failure of the selection!</strong><br> The selected point was already assigned and it is not selectable! ';
      }
      if($blackpoints==1 && $greenpoints==1){
      $_SESSION['msg243917'] ='<strong>Partial failure of the selection!</strong><br> '.$greenpoints.' of selected points was already assigned and it is not selectable! <br>'.$blackpoints.' of selected points was not assigned and it has been selected!';
      }
      mysqli_rollback($conn);
      mysqli_autocommit($conn,TRUE);
      header( "Location: whitepage.php");
      }
    else{
      mysqli_commit($conn);
      mysqli_autocommit($conn,TRUE);
      //$msg='Commit! Reservation inserted!';
      }
    }
      return;
}

function RemoveReservationInDb($user){
  global $conn;
  //global $msg;

  if (!$conn) {
    $_SESSION['msg243917']="The connection with database is not possible!";
    header( "Location: whitepage.php");
  }

  mysqli_autocommit($conn,FALSE);
  $res=mysqli_query($conn,"SELECT COUNT(*) FROM `locations` WHERE user_id='$user' and  timestamp =(SELECT MAX(timestamp) FROM `locations` WHERE user_id='$user' FOR UPDATE)");
  if (!$res) {
      mysqli_rollback($conn);
      mysqli_autocommit($conn,TRUE);
      //$msg='Failure of query! Rollbacked';
      return;
  }

  $row =mysqli_fetch_row($res);
  $num=$row[0];
  $res=mysqli_query($conn," UPDATE locations SET user_id='',timestamp=now() WHERE user_id='$user ' ORDER BY timestamp DESC LIMIT $num ");
  if (mysqli_affected_rows($conn)==0) {
      mysqli_rollback($conn);
      mysqli_autocommit($conn,TRUE);
     $_SESSION['msg243917']='There are not locations to remove for '.$user.'';
     header( "Location: whitepage.php");
  }
  else{
    mysqli_commit($conn);
    mysqli_autocommit($conn,TRUE);
  //$msg='The last assignment made by '.$user.' has been deleted';
  }
  return;
}

?>
