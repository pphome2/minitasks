<?php

 #
 # MiniTasks - document manager for website
 #
 # info: main folder copyright file
 #
 #


include("config/config.php");
include("config/$MT_LANGFILE");

if (isset($_POST[$MT_STYLEPARAM_NAME])){
    $styleindex=htmlspecialchars($_POST[$MT_STYLEPARAM_NAME]);
}else{
    if (isset($_GET[$MT_STYLEPARAM_NAME])){
        $styleindex=htmlspecialchars($_GET[$MT_STYLEPARAM_NAME]);
    }else{
	$styleindex=0;
    }
}
if ($styleindex>count($MT_CSS)){
    $styleindex=0;
}

include("$MT_HEADER");
include("$MT_JS_BEGIN");


echo("<div class=\"content\">");
echo("<h1>".$L_SITENAME."</h1>");
echo("<div class=\"spaceline\"></div>");



function dirlist($dir) {
	global $MT_CONFIG_DIR;

    $result=array();
    $cdir=scandir($dir);
    foreach ($cdir as $key => $value){
		if (!in_array($value,array(".","..",$MT_CONFIG_DIR))){
			$result[]=$value;
		}
	}
	return $result;
}


function vinput($d) {
    $d=trim($d);
    $d=stripslashes($d);
    $d=strip_tags($d);
    $d=htmlspecialchars($d);
    return $d;
}



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




$utime=time();
$loggedin=FALSE;
$passw="";

if (isset($_POST["password"])){
	$passw=md5($_POST["password"]);
	$passw=vinput($passw);
	if ($passw==$MT_ADMIN_PASS){
		$loggedin=TRUE;
		$ADMIN_USER=true;
	}else{
		if ($passw==$MT_PASS){
			$loggedin=TRUE;
			$ADMIN_USER=false;
		}
	}
}
if (isset($_POST["passwordh"])){
	$passw=$_POST["passwordh"];
	$passw=vinput($passw);
	if (($passw==$MT_PASS)or($passw==$MT_ADMIN_PASS)){
		if (isset($_POST["utime"])){
			$outime=$_POST["utime"];
			$outime=vinput($outime);
			$utime2=$utime-$outime;
			if ($utime2<$LOGIN_TIMEOUT){
				$loggedin=TRUE;
			}
		}else{
			$loggedin=TRUE;
		}
		if ($passw==$MT_ADMIN_PASS){
			$ADMIN_USER=TRUE;
		}
	}
}








if ($loggedin){
	$ARCHIV=FALSE;
	# files
	$schemafile="./".$MT_TASKS_ROOT."/".$MT_SCHEMA_FILE;
	$taskfile=$MT_FIRST_TASKS_FILE;
	$taskfile=$MT_TASKS_ROOT."/".$taskfile;
	# delete task fromtable
	if ($_POST["del"]<>""){
		$line=vinput($_POST["del"]);
		if (file_exists($taskfile)){
			$tf=file_get_contents($taskfile);
			$tfa=explode(PHP_EOL,$tf);
			$db=count($tfa);
			$k=0;
			for($i=0;$i<$db;$i++){
				if ($i<>$line){
					if ($tfa[$i]<>""){
						$tfa2[$k]=$tfa[$i].PHP_EOL;
						$k++;
					}
				}
			}
			file_put_contents($taskfile,$tfa2);
		}
		$line++;
		#mess_ok("$line - $L_DELETEDTASK");
		mess_ok("$L_DELETEDTASK");
	}
	# new task from form
	if (isset($_POST["submitall"])){
		$new=vinput($_POST["0"]).$MT_SEPARATE_CHAR;
		$new=$new.vinput($_POST["1"]).$MT_SEPARATE_CHAR;
		$new=$new.vinput($_POST["2"]).$MT_SEPARATE_CHAR;
		$new=$new.vinput($_POST["3"]).$MT_SEPARATE_CHAR;
		$new=$new.vinput($_POST["4"]).$MT_SEPARATE_CHAR;
		$new=$new.vinput($_POST["5"]).PHP_EOL;
		$new=strip_tags($new);
		if (file_exists($taskfile)){
			$tf=file_get_contents($taskfile);
			$tf=$tf.$new;
			file_put_contents($taskfile,$tf);
			mess_ok($L_OK);
		}
	}else{
		if (isset($_POST["submitall"])){
			mess_error($L_NODATA);
		}
	}
	# archive form
	if (isset($_POST["submitar"])){
		$d=date("YmdHis");
		$arfile=$MT_TASKS_ROOT."/".$d;
		if (isset($_POST["sect"])){
			if (substr($_POST["sect"],0,1)=="2"){
				$ARCHIVE=TRUE;
				$taskfile=$MT_TASKS_ROOT."/".vinput($_POST["sect"]);
				$taskfile=str_replace(":","",$taskfile);
				$taskfile=str_replace(".","",$taskfile);
				$taskfile=str_replace(" ","",$taskfile);
			}
		}else{
			if (copy($taskfile,$arfile)){
				mess_ok($L_OK);
			}
		}
	}else{
		if (isset($_POST["submitar"])){
			mess_error($L_NODATA);
		}
	}
	# load data from file
	$filterb=array();
	if ($ARCHIVE){
		$n=substr($taskfile,strlen($MT_TASKS_ROOT)+1,strlen($taskfile));
		$n=substr($n,0,4).".".substr($n,4,2).".".substr($n,6,2).". ".substr($n,8,2).":".substr($n,10,2);
		$n=$L_ARCHIVEFILE." ".$n;
		mess_ok($n);
	}

	# generate table
	$d=dirlist($MT_TASKS_ROOT);
	if (file_exists($schemafile)){
		if (!file_exists($taskfile)){
			touch($taskfile);
		}
		if (file_exists($taskfile)){
			$sch=file_get_contents($schemafile);
			$scha=explode($MT_SEPARATE_CHAR,$sch);
			$db=count($scha);
			for ($i=0;$i<$db;$i++){
				if (substr($scha[$i],0,1)==$MT_SEPARATE_CHAR_FILTER){
					$scha[$i]=substr($scha[$i],1,strlen($scha[$i])-1);
					$filter[]=$i;
				}
			}
			//echo('<input class="" type="text" placeholder="'.$n.'" id="filterin" onkeyup="tfilter(1)">');
			$db=count($filter);
			if ($db>0){
				echo('
					<div class="card">
						<span onclick="cardopenclose(cardbodyf)">
							<div class="card-header topleftmenu1">'.$L_FILTER.'
						</div>
						</span>
						<div class="cardbody" id="cardbodyf" style="display:none;"><div class="insidecontent">
				');
				for ($i=0;$i<$db;$i++){
					$n=$L_SEARCH." ".$scha[$filter[$i]];
					echo('<input class="" type="text" placeholder="'.$n.'" id="filterin'.$i.'" 
							onkeyup="tfilter(\'filterin'.$i.'\','.$filter[$i].')"
							onclick="this.value=\'\';tfilter(\'filterin'.$i.'\','.$filter[$i].')">');
				}
				echo('</div>');
				echo('</div>');
				echo('</div>');
			}
			$db=count($scha);
			echo("<table id=tasktable class=mt-table-all><thead><tr class=mt-red>");
			for ($i=0;$i<$db;$i++){
				echo("<th>$scha[$i]</th>");
			}
			if (!$ARCHIVE){
				echo("<th style=\"text-align:center;\" >$L_DELETELINE</th>");
			}
			echo("</tr></thead>");
			$tf=file_get_contents($taskfile);
			$tfa=explode(PHP_EOL,$tf);
			$db=count($tfa);
			for ($i=0;$i<$db;$i++){
				if ($tfa[$i]<>""){
					echo("<tr>");
					$tfal=explode($MT_SEPARATE_CHAR,$tfa[$i]);
					$db2=count($tfal);
					for ($k=0;$k<$db2;$k++){
						echo("<td>$tfal[$k]</td>");
					}
					if (!$ARCHIVE){
						if ($ADMIN_USER){
							$link=htmlspecialchars($tfa[$i]);
							$link=str_replace(" ","_",$link);
							echo("<td width=10% class=\"center\">");
							echo("<form action=$MT_ADMINFILE id=2 method=post enctype=multipart/form-data>");
							echo("	<input type='hidden' name='passwordh' id='passwordh' value='$passw'>");
							echo("	<input type='hidden' name='$MT_STYLEPARAM_NAME' id='$MT_STYLEPARAM_NAME' value='$styleindex'>");
							echo("	<input type='hidden' name='utime' id='passwordh' value='$utime'>");
							echo("	<input type='hidden' name='del' id='del' value='$i'>");
							echo("	<input type=submit id=submitdel name=submitdel value='$L_DELETELINEBUTTON'>");
							echo("</form></td>");
						}else{
							echo("<td width=10% class=\"center\">-</td>");
						}
					}
					echo("</tr>");
				}
			}
			echo("</table>");
			echo('<div class="spaceline100"></div>');
			echo('
				<div class="card">
					<span onclick="cardopenclose(cardbody0)">
						<div class="card-header topleftmenu1">'.$L_NEWDATA.'
						</div>
					</span>
					<div class="cardbody" id="cardbody0" style="display:none;"><div class="insidecontent">
			');
			echo("<form action=$MT_ADMINFILE id=1 method=post enctype=multipart/form-data>");
			echo("    <input type='hidden' name='passwordh' id='passwordh' value='$passw'>");
			echo("    <input type='hidden' name='$MT_STYLEPARAM_NAME' id='$MT_STYLEPARAM_NAME' value='$styleindex'>");
			echo("    <input type='hidden' name='utime' id='passwordh' value='$utime'>");
			$db=count($scha);
			for ($i=0;$i<$db;$i++){
				echo("<label for=$i>$scha[$i] :</label>");
				if (($AUTO_DATE_TO_FIRST)and($i==0)){
					$date=date('Y.m.d.');
					echo("<input name=$i id=$i type=text value=\"$date\" disabled>");
				}else{
					echo("<input name=$i id=$i type=text placeholder=\"$scha[$i]\">");
				}
			}
			echo("<input type=submit id=submitall name=submitall value=$L_BUTTON_ALL>");
			echo("</form>");
			echo('</div></div></div>');
			echo('<div class="spaceline"></div>');
			echo('
				<div class="card">
					<span onclick="cardopenclose(cardbody1)">
						<div class="card-header topleftmenu1">'.$L_NEWARCHIV.'
						</div>
					</span>
					<div class="cardbody" id="cardbody1" style="display:none;"><div class="insidecontent">
				');
			if (!$ARCHIVE){
				echo("<form action=$MT_ADMINFILE id=2 method=post enctype=multipart/form-data>");
				echo("    <input type='hidden' name='passwordh' id='passwordh' value='$passw'>");
				echo("    <input type='hidden' name='$MT_STYLEPARAM_NAME' id='$MT_STYLEPARAM_NAME' value='$styleindex'>");
				echo("    <input type='hidden' name='utime' id='passwordh' value='$utime'>");
				echo("<input type=submit id=submitar name=submitar value=$L_BUTTON_ALL>");
				echo("</form>");
			}
			echo("<form action=$MT_ADMINFILE id=2 method=post enctype=multipart/form-data>");
			echo("    <input type='hidden' name='passwordh' id='passwordh' value='$passw'>");
			echo("    <input type='hidden' name='$MT_STYLEPARAM_NAME' id='$MT_STYLEPARAM_NAME' value='$styleindex'>");
			echo("    <input type='hidden' name='utime' id='passwordh' value='$utime'>");
			echo("<label>$L_OPENARCHIVE</label>");
			echo("<select name=sect id=sect>");
			echo("<option value='$L_ACTUAL'>$L_ACTUAL");
			rsort($d);
			$db=count($d);
			if ($db>$MT_ARCHIVE_MAXNUM){
				$dbx=$MT_ARCHIVE_MAXNUM;
			}else{
				$dbx=$db;
			}
			for ($i=0;$i<$db;$i++){
				if ((substr($d[$i],0,1)=="2")and(strlen($d[$i])>5)and($dbx>0)) {
					$n=substr($d[$i],0,4).".".substr($d[$i],4,2).".".substr($d[$i],6,2).". ".substr($d[$i],8,2).":".substr($d[$i],10,2);
					echo("<option value=$d[$i]>$n");
					$dbx--;
				}
			}
			echo("</select>");
			echo("<input type=submit id=submitar name=submitar value=$L_BUTTON_ALL>");
			echo("</form>");
			echo('</div></div></div>');
			echo('<div class="spaceline"></div>');
			echo('
				<div class="card">
					<span onclick="cardopenclose(cardbody2)">
						<div class="card-header topleftmenu1">'.$L_PRINT.'
						</div>
					</span>
					<div class="cardbody" id="cardbody2" style="display:none;"><div class="insidecontent">
			');
			echo("<div class=insidecontent><a target=_blank href=$MT_PRINTFILE><input type=submit id=submitar name=submitar value=$L_PRINT></a></div>");
			echo('</div></div></div>');
			echo('<div class="spaceline"></div>');
		}else{
			mess_error($L_TASKFILENOTFOUND);
		}
	}else{
		mess_error($L_FILENOTFOUND);
	}
}else{
	echo("<div class=spaceline100></div>");
	echo("<form  method='post' enctype='multipart/form-data'>");
	echo("    <input type='hidden' name='$MT_STYLEPARAM_NAME' id='$MT_STYLEPARAM_NAME' value='$styleindex'>");
	echo("    $L_PASS:");
	echo("    <input type='password' name='password' id='password' autofocus>");
	echo("<div class=spaceline></div>");
	echo("    <input type='submit' value='$L_BUTTON_ALL' name='submit'>");
	echo("</form>");
	echo("<div class=spaceline></div>");
}



include("$MT_JS_END");
include("$MT_FOOTER");

?>
