<?php
function test_input($var){
    $var=strip_tags($var);
    $var=stripslashes($var); #remove backslashes
    $var=htmlentities($var); # convert characters to HTML entities.
	return $var;
}

/**It checks if all the necessary values for registration of a new user are set in $_POST variable **/
function ValidateRegistrationValues(){
	$ret = true;
	if( empty($_POST['username']) ){
		echo "<p>The username is not set!</p>";
		$ret = false;
	}
	if( empty($_POST['password']) ){
		echo "<p>The password is not set!</p>";
		$ret = false;
	}
	if( empty($_POST['confirmpwd']) ){
		echo "<p>You don't fill the field of confirmation password!</p>";
		$ret = false;
	}
	if(!filter_var(test_input($_POST['username']),FILTER_VALIDATE_EMAIL)){
		echo"<p>Invalid email format</p>";
		$ret=false;
	}
	else{
		if(($_POST['password'])===($_POST['confirmpwd'])){// non faccio il test_input sulla pwd xk contiene caratteri speciali la password
			if(preg_match("/[\'\/~`\!@#\$%\^&\*\(\)_\-\+=\{\}\[\]\|;:\"\<\>,\.\?]{2,}/",test_input($_POST['password'])))
				$ret=true;
			else{
				echo"<p>Password must contains already 2 special characters</p>";
				$ret=false;}
			}
		else {
			echo"<p>Passwords must be the same! Please check it!</p>";
			$ret=false;
		}
	}
	return $ret;
}

function printMsg($msg){
  echo "<p>".$msg."</p>";
}

function showPoint($map){
  echo"
  <script>
    var array=[];
  </script>";
  for($i=0;$i<10;$i++){
    $x=$map[$i]['x'];
    $y=$map[$i]['y'];
    $user_id=$map[$i]['user_id'];
    $timestamp=$map[$i]['timestamp'];

    echo"
    <script >";
      if(isset($_SESSION['user243917'])){
        if($_SESSION['user243917']==$user_id ){
        echo"
        var points=[$x,$y,'yellow','$timestamp'];
        array[$i]=[points];
        showMappoints($x,$y,'yellow')";
        }
      else if ($_SESSION['user243917']!=$user_id && !empty($user_id)){
          echo"
          var points=[$x,$y,'green','$timestamp'];
          array[$i]=[points];
          showMappoints($x,$y,'green')";
        }
      else if (empty($user_id)){
          echo"
          var points=[$x,$y,'black','$timestamp'];
          array[$i]=[points];
          showMappoints($x,$y,'black')";
        }
      }
      else {
        if (isset($user_id) && !empty($user_id)){
          echo"
          var points=[$x,$y,'green','$timestamp'];
          array[$i]=[points];
          showMappoints($x,$y,'green')";
        }
        else {
          echo"
          var points=[$x,$y,'black','$timestamp'];
          array[$i]=[points];
          showMappoints($x,$y,'black')";
        }
      }
    echo"
    </script>";
   }
 }

function showMap(){
  global $map;
  if($map==null)
    $map=getMap();

  echo "
  <canvas id='myCanvas' width='600' height='400' ></canvas>
  <div id='output'></div>";
  if(isset($_SESSION['user243917'])){
    echo"
      <div id='form_div'> 
        <form id='reservation_submit' method='post' action='index.php' >
          <button id='send' title='Click the button to confirm your choice' name='send' type=submit> Submit</button>
          <input type=hidden id='points_to_insert' name='points_to_insert' value=''>
        </form>
        <form id='reservation_remove' method='post' action='index.php' >
          <button id='remove' title='Click the button to remove the last assignment made' name='remove' type=submit>Remove</button>
        </form>
      </div>  ";
  }
    echo"
      <script>
        var canvas = document.getElementById('myCanvas');
        ctx = canvas.getContext('2d');
        var rect = {};
        var drag = false;
        var coord;
        var j=0;
        var o=document.getElementById('output');

        function showCoordinates(){
          var lista=[];
          var lista_screen=[];
          var screenstartY=400-rect.startY;
          var endx=rect.startX+rect.w;
          var endy=400-(rect.startY+rect.h);
          ctx.setLineDash([4]);
          var str='RECT: '+rect.startX+' '+screenstartY+' '+rect.w+' '+rect.h;
          ctx.strokeRect(rect.startX, rect.startY, rect.w, rect.h);
          ctx.rect(rect.startX, rect.startY, rect.w, rect.h);

          for(var k=0;k<array.length;k++){
              var x=array[k][0][0];
              var y=canvas.height-array[k][0][1];
              var timestamp=array[k][0][3];
              var color=array[k][0][2];
                if(check_inside(x,y,rect.startX,rect.startY,rect.w,rect.h)){
                  if(array[k][0][2]!='yellow'){
                    var coordscreen =x+' '+array[k][0][1]+'<br/>';
                    var coord=x+','+y+','+timestamp+','+color;
                    lista.unshift(coord);
                    lista_screen.unshift(coordscreen);
                  }
                }
          }

          document.getElementById('points_to_insert').value=lista.join(';');
          o.innerHTML=lista_screen.join(' ');
          for(var l=0;l<lista.length;l++){
            highlights(lista[l]);
          }
       }


       function check_inside(x,y,startx,starty,w,h){
          var x1=Math.min(startx,startx+w);
          var x2= Math.max(startx,startx+w);
          var y1= Math.min(starty,starty+h);
          var y2= Math.max(starty,starty+h);
          if(x>=x1 && y>=y1 && y<=y2 && x<=x2 ){
            return true;
          }
          else{
            return false;
          }
        }

      function draw() {
        for (var i=0;i<10;i++){
          showMappoints(array[i][0][0],array[i][0][1],array[i][0][2]);
        }
      }

      function mouseDown(e) {
        j=j+1;
        if(j==2){
          ctx.clearRect(0,0,canvas.width,canvas.height);
          draw();
          o.innerHTML='';
          j=j-1;
        }
        rect.startX = e.pageX - this.offsetLeft;
        rect.startY = e.pageY - this.offsetTop;
        drag = true;
      }

      function mouseUp() {
        drag = false;
        showCoordinates();
      }

      function mouseMove(e) {
        if (drag) {
          rect.w = (e.pageX - this.offsetLeft) - rect.startX;
          rect.h = (e.pageY - this.offsetTop) - rect.startY ;
        }
      }

      function init() {
        canvas.addEventListener('mousedown', mouseDown, false);
        canvas.addEventListener('mouseup', mouseUp, false);
        canvas.addEventListener('mousemove', mouseMove, false);
      }

      function showMappoints(x,y,color){
        ctx.beginPath();
        ctx.arc(x,canvas.height-y,4,0,2*Math.PI);
        ctx.closePath();
        ctx.fillStyle=color;
        ctx.fill();
      }

      function highlights(coordi){
        coordinates=coordi.split(',');
        coord_x=coordinates[0];
        coord_y=coordinates[1];
        ctx.beginPath();
        ctx.arc(coord_x,coord_y,8,0,2*Math.PI);
        ctx.closePath();
        ctx.stroke();
      }
    </script>";
  if(isset($_SESSION['user243917'])){
    echo"
    <script>
      init();
    </script>";
  }
  showPoint($map);
}

?>
