<?php

 #
 # MiniTasks - task manager for website
 #
 # info: main folder copyright file
 #
 #




function searchpage(){
	global $L_SEARCH;

	echo("<div class=\"content\">");
	echo("<h1>".$L_SEARCH."</h1>");
	echo("<div class=\"spaceline\"></div>");
	echo("<p>".$L_SEARCH."</p>");
	echo("</div>");
}

	
function privacypage(){
	global $L_PRIVACY_HEADER,$L_PRIVACY_TEXT, $L_BACKPAGE, $MA_NOPAGE;

	echo("<div class=\"content\">");
	echo("<h1>".$L_PRIVACY_HEADER."</h1>");
	echo("<div class=\"spaceline\"></div>");
	echo("<p>".$L_PRIVACY_TEXT."</p>");
	echo("</div>");
}

function printpage(){
	global $MT_TASKS_ROOT, $MT_SCHEMA_FILE, $MT_FIRST_TASKS_FILE,$MT_SEPARATE_CHAR,$MT_SEPARATE_CHAR_FILTER,
			$L_TASKFILENOTFOUND, $L_FILENOTFOUND, $MA_NOPAGE;

	# files
	$schemafile="./".$MT_TASKS_ROOT."/".$MT_SCHEMA_FILE;
	$taskfile=$MT_TASKS_ROOT."/".$MT_FIRST_TASKS_FILE;
	# load data from file
	if (file_exists($schemafile)){
		if (!file_exists($taskfile)){
			touch($taskfile);
		}
		if (file_exists($taskfile)){
			$sch=file_get_contents($schemafile);
			$scha=explode($MT_SEPARATE_CHAR,$sch);
			echo("<section id=st>");
			$db=count($scha);
			echo("<table class=mt-table-all><thead><tr class=mt-red>");
			for ($i=0;$i<$db;$i++){
				$n=$scha[$i];
				if (substr($n,0,1)==$MT_SEPARATE_CHAR_FILTER){
					$n=substr($n,1,strlen($n));
				}
				echo("<th>$n</th>");
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
					echo("</tr>");
				}
			}
			echo("</table>");
			echo("</section>");
		}else{
			echo("<section id=message>$L_TASKFILENOTFOUND</section>");
		}
	}else{
		echo("<section id=message>$L_FILENOTFOUND</section>");
	}
	
}



function main(){
	global $ARCHIVE,
			$MA_ADMINFILE,$MA_PRINTFILE,
			$MT_SCHEMA_FILE,$MT_FIRST_TASKS_FILE,$MT_TASKS_ROOT,$MT_SEPARATE_CHAR_FILTER,
			$MT_SEPARATE_CHAR,$MA_ADMIN_USER,$MT_AUTO_DATE_TO_FIRST,$MT_ARCHIVE_MAXNUM,
			$L_SITENAME,$L_DELETEDTASK,$L_OK,$L_NODATA,$L_FILTER,$L_SEARCH,$L_DELETELINE,
			$L_DELETELINEBUTTON,$L_NEWDATA,$L_NEWARCHIV,$L_OPENARCHIVE,$L_ACTUAL,
			$L_BUTTON_ALL,$L_PRINT,$L_TASKFILENOTFOUND,$L_FILENOTFOUND;

	#echo("<h1>".$L_SITENAME."</h1>");
	#echo("<div class=\"spaceline\"></div>");

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

	# generate table and function box
	
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
					$n=$L_SEARCH.": ".$scha[$filter[$i]];
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
						if ($MA_ADMIN_USER){
							$link=htmlspecialchars($tfa[$i]);
							$link=str_replace(" ","_",$link);
							echo("<td width=10% class=\"center\">");
							echo("<form action=$MA_ADMINFILE id=2 method=post enctype=multipart/form-data>");
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

			# new data box
			
			echo('<div class="spaceline50"></div>');
			echo('
				<div class="card">
					<span onclick="cardopenclose(cardbody0)">
						<div class="card-header topleftmenu1">'.$L_NEWDATA.'
						</div>
					</span>
					<div class="cardbody" id="cardbody0" style="display:none;"><div class="insidecontent">
			');
			echo("<form action=$MA_ADMINFILE id=1 method=post enctype=multipart/form-data>");
			$db=count($scha);
			for ($i=0;$i<$db;$i++){
				echo("<label for=$i>$scha[$i] :</label>");
				if (($MT_AUTO_DATE_TO_FIRST)and($i==0)){
					$date=date('Y.m.d.');
					echo("<input name=$i id=$i type=text value=\"$date\" readonly>");
				}else{
					echo("<input name=$i id=$i type=text placeholder=\"$scha[$i]\">");
				}
			}
			echo("<input type=submit id=submitall name=submitall value=$L_BUTTON_ALL>");
			echo("</form>");
			echo('</div></div></div>');

			# archiv data box

			echo('<div class="spaceline25"></div>');
			echo('
				<div class="card">
					<span onclick="cardopenclose(cardbody1)">
						<div class="card-header topleftmenu1">'.$L_NEWARCHIV.'
						</div>
					</span>
					<div class="cardbody" id="cardbody1" style="display:none;"><div class="insidecontent">
				');
			if (!$ARCHIVE){
				echo("<form action=$MA_ADMINFILE id=2 method=post enctype=multipart/form-data>");
				echo("<input type=submit id=submitar name=submitar value=$L_BUTTON_ALL>");
				echo("</form>");
			}
			echo("<form action=$MA_ADMINFILE id=2 method=post enctype=multipart/form-data>");
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

			# print box

			echo('<div class="spaceline25"></div>');
			echo('
				<div class="card">
					<span onclick="cardopenclose(cardbody2)">
						<div class="card-header topleftmenu1">'.$L_PRINT.'
						</div>
					</span>
					<div class="cardbody" id="cardbody2" style="display:none;"><div class="insidecontent">
			');
			echo("<div class=insidecontent><a target=_blank href=$MA_PRINTFILE><input type=submit id=submitar name=submitar value=$L_PRINT></a></div>");
			echo('</div></div></div>');
			echo('<div class="spaceline"></div>');
		}else{
			mess_error($L_TASKFILENOTFOUND);
		}
	}else{
		mess_error($L_FILENOTFOUND);
	}

}




?>
