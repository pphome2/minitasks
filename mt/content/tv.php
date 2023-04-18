<?php

 #
 # MiniApp
 #
 # info: main folder copyright file
 #
 #
 


function t_view(){
	global $MA_SQL_RESULT,$T_TASK_NEW,$T_TASK_TABLE_TITLE2,$MA_USERNAME,
			$T_WORK,$T_SEARCH,$T_PAGEROW,$T_PAGE_LEFT,$T_PAGE_RIGHT;

	$first=0;
	$last=false;
	if (sql_run("select count(*) from mt_tasks;")){
		$r=$MA_SQL_RESULT[0];
		$odb=$r[0];
		$adb=$first+$T_PAGEROW;
		if ($adb>=$odb){
			$last=true;
		}
	}
	echo("<input type=text id=search onkeyup='searchtable()' placeholder=\"$T_SEARCH\">");
	sql_run("select * from mt_tasks where tulajdonos=\"$MA_USERNAME\" and rdatum=\"\" order by datum desc limit $first,$T_PAGEROW;");
	echo("<center>");
	echo("<table class='df_table_full' id=ptable>");
	echo("<tr class='df_trh'>");
	echo("<th class='df_th'>$T_TASK_TABLE_TITLE2[0]</th>");
	echo("<th class='df_th'>$T_TASK_TABLE_TITLE2[1]</th>");
	echo("<th class='df_th'>$T_TASK_TABLE_TITLE2[2]</th>");
	echo("<th class='df_th'>$T_TASK_TABLE_TITLE2[3]</th>");
	echo("<th class='df_th'>$T_TASK_TABLE_TITLE2[4]</th>");
	echo("<th class='df_th'>$T_TASK_TABLE_TITLE2[5]</th>");
	echo("<th class='df_th'>$T_TASK_TABLE_TITLE2[6]</th>");
	echo("</tr>");
	$db=count($MA_SQL_RESULT);
	for($i=0;$i<$db;$i++){
		$r=$MA_SQL_RESULT[$i];
		echo("<tr class=df_tr>");
		echo("<td class='df_td'>$r[1]</td>");
		echo("<td class='df_td'>$r[2]</td>");
		echo("<td class='df_td'>$r[3]</td>");
		echo("<td class='df_td'>$r[4]</td>");
		echo("<td class='df_td'>$r[5]</td>");
		echo("<td class='df_td'>$r[6]</td>");
		$r[7]=str_replace(PHP_EOL,"<br />",$r[7]);
		echo("<td class='df_td'>$r[7]</td>");
		echo("</tr>");
	}
	echo("</table>");
	echo("<div class=frow>");
	echo("<div class=pcol2>");
	if (($page>0)and($first>0)){
		echo("<form method=post>");
		$p=$page-1;
		echo("<input type=hidden id=page name=page value=$p>");
		echo("<input type=submit id=p name=p value=\"$T_PAGE_LEFT\">");
		echo("</form>");
	}else{
		echo("<span style=\"color:transparent;\">?</span>");
	}
	echo("</div>");
	echo("<div class=pcol1>");
	echo("<div style=\"width:90%;float:middle;\">");
	echo("<span style=\"color:transparent;\">?</span>");
	echo("</div>");
	echo("</div>");
	echo("<div class=pcol2>");
	if (($db==$I_PAGEROW)and(!$last)){
		$p=$page+1;
		echo("<form method=post>");
		echo("<input type=hidden id=page name=page value=$p>");
		echo("<input type=submit id=p name=p value=\"$T_PAGE_RIGHT\">");
		echo("</form>");
	}else{
		echo("<span style=\"color:transparent;\">?</span>");
	}
	echo("</div>");
	echo("</div>");
}



?>
