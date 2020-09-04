
<?php

 #
 # MiniApps - framework
 #
 # info: main folder copyright file
 #
 #



# backpage button
function button_back(){
	global $L_BACKPAGE;
	
	echo("<div class=\"spaceline\"></div>");
	echo("<div class=insidecontent><a onclick=\"window.history.back();\"><input type=submit id=submitar name=submitar value=$L_BACKPAGE></a></div>");
	echo("<div class=\"spaceline\"></div>");
}


# print button
function button_print(){
	global $L_PRINT,$MA_PRINTFILE;
	
	echo("<div class=\"spaceline\"></div>");
	echo("<div class=insidecontent><a href=$MA_PRINFILE><input type=submit id=submitar name=submitar value=$L_PRINT></a></div>");
	echo("<div class=\"spaceline\"></div>");
}



# messages functions
function mess_error($m){
	echo('
	<div class="message">
  		<div onclick="this.parentElement.style.display=\'none\'" class="toprightclose"></div>
  		<p class="insidecontent">'.$m.'</p>
	</div>
	');
}


function mess_ok($m){
	echo('
		<div class="card">
  			<div onclick="this.parentElement.style.display=\'none\'" class="toprightclose"></div>
  			<div class=card-header>
  				<span onclick="var x=document.getElementById(\'cardbody\');if (x.style.display==\'none\'){x.style.display=\'block\'}else{x.style.display=\'none\'}"
  				class="topleftmenu1"></span></div>
  			<div class="cardbody" id="cardbody">
  				<p class="insidecontent">'.$m.'</p>
  			</div>
		</div>
	');
}


# login box
function login_form(){
	global $MA_COOKIE_STYLE,$MA_STYLEINDEX,$L_PASS,$MA_COOKIE_PASSWORD,$L_BUTTON_NEXT;
	
	echo("<div class=spaceline100></div>");
	echo("<form  method='post' enctype='multipart/form-data'>");
	echo("	<input type='hidden' name='$MA_COOKIE_STYLE' id='$MA_COOKIE_STYLE' value='$MA_STYLEINDEX'>");
	echo("	$L_PASS:");
	echo("	<input type='password' name='$MA_COOKIE_PASSWORD' id='$MA_COOKIE_PASSWORD' autofocus>");
	echo("	<div class=spaceline></div>");
	echo("	<input type='submit' value='$L_BUTTON_NEXT' name='submit'>");
	echo("</form>");
	echo("<div class=spaceline></div>");
}


?>
