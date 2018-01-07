<?php

 #
 # MiniTasks - document manager for website
 #
 # info: main folder copyright file
 #
 #

# configuration - need change it


include("config/config.php");
include("$MT_HEADER");
include("$MT_JS_BEGIN");


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

$d=dirlist($MT_TASKS_ROOT);

# files
$schemafile="./".$MT_TASKS_ROOT."/".$MT_SCHEMA_FILE;
$taskfile=$MT_TASKS_ROOT."/".$MT_FIRST_TASKS_FILE;

# delete task fromtable
if ($_GET[$MT_PARAM_DEL]<>""){
	$line=$_GET[$MT_PARAM_DEL];
	if (file_exists($taskfile)){
		$tf=file_get_contents($taskfile);
		$tfa=explode(PHP_EOL,$tf);
		$sor=$_GET[$MT_PARAM_DATA];
		$li=htmlspecialchars($tfa[$line]);
		$li=str_replace(" ","_",$li);
		#echo($sor."?".$li);
		if ($li<>$sor){
			$line=1000000;
		}
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
	echo("<section id=message>$line - $L_DELETEDTASK</section>");
}


# new task from form
if (isset($_POST["submitall"])){
	echo("<section id=message>");

	if (isset($_POST["userpass"])){
		$p=$_POST["userpass"];
		if (md5($p)==$MT_PASS){
			#$p1=$_POST["userpass"];
			$new=$_POST["0"].$MT_SEPARATE_CHAR;
			$new=$new.$_POST["1"].$MT_SEPARATE_CHAR;
			$new=$new.$_POST["2"].$MT_SEPARATE_CHAR;
			$new=$new.$_POST["3"].$MT_SEPARATE_CHAR;
			$new=$new.$_POST["4"].$MT_SEPARATE_CHAR;
			$new=$new.$_POST["5"].PHP_EOL;
			$new=strip_tags($new);
			if (file_exists($taskfile)){
				$tf=file_get_contents($taskfile);
				$tf=$tf.$new;
				file_put_contents($taskfile,$tf);
				echo($L_OK."<br />");
			}
		}else{
			echo($L_NOACCESS."<br />");
		}
	}
	echo("</section>");
}else{
	if (isset($_POST["submitall"])){
		echo("<section id=message>");
		echo($L_NODATA."<br />");
		echo("</section>");
	}
}


# archive form
if (isset($_POST["submitar"])){
	echo("<section id=message>");

	if (isset($_POST["userpass"])){
		$p=$_POST["userpass"];
		if (md5($p)==$MT_PASS){
			$d=date("YmdHis");
			$arfile=$MT_TASKS_ROOT."/".$d;
			if (copy($taskfile,$arfile)){
				echo($L_OK."<br />");
			}
		}else{
			echo($L_NOACCESS."<br />");
		}
	}
	echo("</section>");
}else{
	if (isset($_POST["submitar"])){
		echo("<section id=message>");
		echo($L_NODATA."<br />");
		echo("</section>");
	}
}



# load data from file

if (file_exists($schemafile)){
	if (file_exists($taskfile)){
		$sch=file_get_contents($schemafile);
		$scha=explode($MT_SEPARATE_CHAR,$sch);
		echo("<section id=st>");
		$db=count($scha);
		echo("<table class=mt-table-all><thead><tr class=mt-red>");
		for ($i=0;$i<$db;$i++){
			echo("<th>$scha[$i]</th>");
		}
		echo("<th>$L_DELETELINE</th>");
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
				$link=htmlspecialchars($tfa[$i]);
				$link=str_replace(" ","_",$link);
				echo("<td><a href=?$MT_PARAM_DEL=$i&$MT_PARAM_DATA=$link><button class=button>$L_DELETELINEBUTTON</button></a></td>");
				echo("</tr>");
			}
		}
		echo("</table>");
		echo("</section>");

		echo("<section id=s1>");
		echo("<button class=accordion>$L_NEWDATA</button>");
		echo("<div class=panel>");
		echo("<section id=form1>");
		echo("<form action=$MT_ADMINFILE id=1 method=post enctype=multipart/form-data>");
		echo("<br />");
		echo("<label for=userpass>$L_PASS : </label>");
		echo("<input name=userpass id=userpass type=password placeholder=\"$L_PASS\"><br /><br />");
		$db=count($scha);
		for ($i=0;$i<$db;$i++){
			echo("<label for=$i>$scha[$i] :</label>");
			echo("<input name=$i id=$i type=text placeholder=\"$scha[$i]\"><br /><br />");
		}
		echo("<input type=submit id=submitall name=submitall value=$L_BUTTON_ALL>");
		echo("</form><br />");
		echo("</section>");
		echo("</div>");
		echo("</section>");


		echo("<section id=s1>");
		echo("<button class=accordion>$L_NEWARCHIV</button>");
		echo("<div class=panel>");
		echo("<br />");
		echo("<br />");
		echo("<form action=$MT_ADMINFILE id=2 method=post enctype=multipart/form-data>");
		echo("<br />");
		echo("<label for=userpass>$L_PASS : </label>");
		echo("<input name=userpass id=userpass type=password placeholder=\"$L_PASS\"><br /><br />");
		echo("<input type=submit id=submitar name=submitar value=$L_BUTTON_ALL>");
		echo("</form><br />");
		echo("<br />");
		echo("</div>");
		echo("</section>");


		echo("<section id=s1>");
		echo("<button class=accordion>$L_PRINT</button>");
		echo("<div class=panel>");
		echo("<br />");
		echo("<a href=$MT_PRINTFILE><input type=submit id=submitar name=submitar value=$L_PRINT></a>");
		echo("<br />");
		echo("</div>");

		echo("</section>");
	}else{
		echo("<section id=message>$L_TASKFILENOTFOUND</section>");
	}
}else{
	echo("<section id=message>$L_FILENOTFOUND</section>");
}

include("$MT_JS_END");
include("$MT_FOOTER");

?>
