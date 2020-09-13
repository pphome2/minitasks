<?php

 #
 # MiniTasks - task manager for website
 #
 # info: main folder copyright file
 #
 #




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

?>
