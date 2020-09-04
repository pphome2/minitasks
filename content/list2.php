<?php

 #
 # MiniTasks - task manager for website
 #
 # info: main folder copyright file
 #
 #



# load config
if (file_exists("../config/config.php")){
	include("../config/config.php");
}
if (file_exists("$MA_LIB")){
	include("$MA_LIB");
}
if (file_exists("../$MA_CONFIG_DIR/$MA_LANGFILE")){
	include("../$MA_CONFIG_DIR/$MA_LANGFILE");
}


# build page
echo("<html><head>");
echo("<title>$MT_SITENAME</title>");
echo("<meta http-equiv=\"refresh\" content=\"60;\"><style>");
include("../$MA_CONTENT_DIR/$MT_CSSLIST");
echo("</style></head><body onclick=\"window.close;\">");
echo("<a href=\"../$MT_ADMINFILE\">");

# files
$schemafile="../".$MT_TASKS_ROOT."/".$MT_SCHEMA_FILE;
$taskfile="../".$MT_TASKS_ROOT."/".$MT_FIRST_TASKS_FILE;

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

echo("</a></body></html>");

?>
