<?php
    session_start();
	  $SessionTime=120; #2 minutes
    $page= basename($_SERVER['PHP_SELF']);/**Ritorna il base name del percorso **/
    $protocol=$_SERVER['REQUEST_SCHEME'];

    //non c'è bisogno di https
    if($protocol=="https" && $page== "index.php" && !isset($_SESSION['user243917']))
    {
        header('HTTP/1.1 307 Temporary redirect');
        header("location: http://" . $_SERVER['HTTP_HOST'] .$_SERVER['REQUEST_URI']);
        exit();
    }

    //There is need of https
    if($protocol=="http" && ( $page== "login.php"|| $page== "signup.php"))
    {
        header('HTTPS/1.1 307 temporary redirect');
        header("location: https://" . $_SERVER['HTTP_HOST'] .$_SERVER['REQUEST_URI']);
    }

    //Validation of the session
    if(isset($_SESSION['user243917'])){
        $user=$_SESSION['user243917'];
      if(isset($_SESSION['time243917'])) // time243917 is the last access
      {
        if(time()-$_SESSION['time243917']<$SessionTime)
        {
          $_SESSION['time243917']=time();
          if(empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == '')
          {
              header('HTTPS/1.1 307 temporary redirect');
              header("location: https://" . $_SERVER['HTTP_HOST'] .$_SERVER['REQUEST_URI']);
          }
        }
        else
        {
            destroySession();
            header('HTTP/1.1 307 temporary redirect');
            header("location: http://" . $_SERVER['HTTP_HOST'] .$_SERVER['REQUEST_URI']);
            exit("Timeout Expired!");
        }
      }
      else
      {
        $_SESSION[time243917]=time();
      }
    }


function destroySession()
{
    $_SESSION=array();//array vuoto
    if(ini_get("session.use_cookies") ) // session_id() !="" || isset($_COOKIE[session_name()])
    {
      $params = session_get_cookie_params();
      //invalido cookie
      setcookie(session_name(),'', time()-3600*24, $params["path"],$params["domain"],$params["secure"],$params["httponly"]);
    }
    session_destroy();
}
?>
