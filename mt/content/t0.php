<?php

 #
 # MiniApp
 #
 # info: main folder copyright file
 #
 #
 
 
function t_genid(){
	$id=date('YmdHis');
	return($id);
}



function t_taskdel(){
	global $T_TASK_TITLE_DEL,$T_OK,$T_ERROR;

	if (isset($_POST['idd'])){
		$id=$_POST['idd'];
		$sqlc="delete from mt_tasks where id=$id;";
		#echo($sqlc);
		if (sql_run($sqlc)){
			mess_ok($T_TASK_TITLE_DEL.": ".$T_OK.".");
		}else{
			mess_error($T_TASK_TITLE_DEL.": ".$T_ERROR.".");
		}
	}
}



function t_taskdata($new){
	global $MA_SQL_RESULT,$T_TASK_FIELDS,$MA_ADMINFILE,
			$T_SAVE,$T_TASK_TITLE_NEW,$T_TASK_TITLE_CHANGE,
			$T_OK,$T_ERROR,$T_TASK_DEL,$MA_USERNAME;

	$db=count($T_TASK_FIELDS);
	$form=true;
	if ($new){;
		$title=$T_TASK_TITLE_NEW;
		if (isset($_POST['0'])){
			$form=false;
			$da="\"".$_POST[0]."\"";
			for($i=1;$i<$db;$i++){
				$da=$da.", \"".$_POST[$i]."\"";
			}
			$sqlc="insert into mt_tasks (id,datum,hdatum,rdatum,feladat,felelos,megbizo,leiras,tulajdonos) values ($da);";
			if (sql_run($sqlc)){
				mess_ok($T_TASK_TITLE_NEW.": ".$T_OK.".");
			}else{
				mess_error($T_TASK_TITLE_NEW.": ".$T_ERROR.".");
			}
		}
		$d[0]=t_genid();
		$d[1]=date('Y.m.d');
		$d[2]=date('Y.m.d');
		for($i=3;$i<$db;$i++){
			$d[$i]="";
		}
	}else{
		$title=$T_TASK_TITLE_CHANGE;
		if (isset($_POST['id'])){
			if (isset($_POST['id2'])){
				$form=false;
				$id2=$_POST['id2'];
				$sqlc="update mt_tasks set";
				$sqlc=$sqlc." id = ".$_POST[0].", ";
				$sqlc=$sqlc." datum = \"$_POST[1]\", ";
				$sqlc=$sqlc." hdatum = \"$_POST[2]\", ";
				$sqlc=$sqlc." rdatum = \"$_POST[3]\", ";
				$sqlc=$sqlc." feladat = \"$_POST[4]\", ";
				$sqlc=$sqlc." felelos = \"$_POST[5]\", ";
				$sqlc=$sqlc." megbizo = \"$_POST[6]\", ";
				$sqlc=$sqlc." leiras = \"$_POST[7]\", ";
				$sqlc=$sqlc." tulajdonos = \"$_POST[8]\" ";
				$sqlc=$sqlc." where id=$id2;";
				#echo($sqlc);
				if (sql_run($sqlc)){
					mess_ok($T_TASK_TITLE_CHANGE.": ".$T_OK.".");
				}else{
					mess_error($T_TASK_TITLE_CHANGE.": ".$T_ERROR.".");
				}
			}
			$id=$_POST['id'];
			$sqlc="select * from mt_tasks where id=$id;";
			if (sql_run($sqlc)){
				$r=$MA_SQL_RESULT[0];
				for($i=0;$i<$db;$i++){
					$d[$i]=$r[$i];
				}
			}else{
				$d[0]=r_genid();
				for($i=1;$i<$db;$i++){
					$d[$i]="";
				}
			}
		}
	}
	if ($form){
		echo("<div class=spaceline></div>");
		echo("<h3>$title</h3>");
		echo("<div class=spaceline></div>");
		echo("<form method=post>");
		echo("<input type=hidden id=0 name=0 value=\"$d[0]\">");
		$dat=array(2,3);
		$ro=array(1);
		for($i=1;$i<$db-2;$i++){
			echo("<div class=frow>");
			echo("<div class=fcol1>$T_TASK_FIELDS[$i]");
			echo("</div>");
			echo("<div class=fcol2>");
			$ronly="";
			if (in_array($i,$ro)){
				$ronly="readonly";
			}
			if (in_array($i,$dat)){
				echo("<input type=date id=$i name=$i placeholder=\"$T_TASK_FIELDS[$i]\" value=\"$d[$i]\" $ronly>");
			}else{
				echo("<input type=text id=$i name=$i placeholder=\"$T_TASK_FIELDS[$i]\" value=\"$d[$i]\" $ronly>");
			}
			echo("</div>");
			echo("</div>");
		}
		echo("<div class=frow>");
		echo("<div class=fcol1>$T_TASK_FIELDS[$i]");
		echo("</div>");
		echo("<div class=fcol2>");
		#echo("<input type=text id=$i name=$i placeholder=\"$T_TASK_FIELDS[$i]\" value=\"$d[$i]\">");
		echo("<textarea rows=10 id=$i name=$i>$d[$i]</textarea>");
		echo("</div>");
		echo("</div>");
		$i++;
		echo("<input type=hidden id=$i name=$i value='$MA_USERNAME'>");
		echo("<div class=frow><br /></div>");
		if ($new){
			echo("<input type=hidden id=id name=id value=\"$d[0]\">");
			echo("<input type=submit id=newt name=newt value=\"$T_SAVE\">");
			echo("</form>");
		}else{
			echo("<input type=hidden id=id name=id value=\"$d[0]\">");
			echo("<input type=hidden id=id2 name=id2 value=\"$d[0]\">");
			echo("<input type=submit id=cht name=cht value=\"$T_SAVE\">");
			echo("</form>");
			echo("<div class=frow><br /></div>");
			echo("<form method=post>");
			echo("<input type=hidden id=idd name=idd value=\"$d[0]\">");
			echo("<input  type=submit id=delt name=delt value=\"$T_TASK_DEL\">");
			echo("</form>");
		}
		return(false);
	}
	return(true);
}


function t_tasks(){
	global $MA_SQL_RESULT,$T_TASK_NEW,$T_TASK_TABLE_TITLE,$MA_USERNAME,
			$T_WORK,$T_SEARCH,$T_PAGEROW,$T_PAGE_LEFT,$T_PAGE_RIGHT;

	$ptable=true;
	if (isset($_POST['newt'])){
		$ptable=t_taskdata(true);
	}
	if (isset($_POST['delt'])){
		t_taskdel();
	}
	if (isset($_POST['cht'])){
		$ptable=t_taskdata(false);
	}
	if ($ptable){
		if (isset($_POST['page'])){
			$page=(int)$_POST['page'];
			$first=$T_PAGEROW*$page;
		}else{
			$page=0;
			$first=0;
		}
		$last=false;
		if (sql_run("select count(*) from mt_tasks;")){
			$r=$MA_SQL_RESULT[0];
			$odb=$r[0];
			$adb=$first+$T_PAGEROW;
			if ($adb>=$odb){
				$last=true;
			}
		}
		echo("<form method=post>");
		echo("<input type=submit id=newt name=newt value=\"$T_TASK_NEW\">");
		echo("</form>");
		echo("<input type=text id=search onkeyup='searchtable()' placeholder=\"$T_SEARCH\">");
		sql_run("select * from mt_tasks where tulajdonos=\"$MA_USERNAME\" and rdatum=\"\" order by datum desc limit $first,$T_PAGEROW;");
		echo("<center>");
		echo("<table class='df_table_full' id=ptable>");
		echo("<tr class='df_trh'>");
		echo("<th class='df_th'>$T_TASK_TABLE_TITLE[0]</th>");
		echo("<th class='df_th'>$T_TASK_TABLE_TITLE[1]</th>");
		echo("<th class='df_th'>$T_TASK_TABLE_TITLE[2]</th>");
		echo("<th class='df_th'>$T_TASK_TABLE_TITLE[3]</th>");
		echo("<th class='df_th'>$T_TASK_TABLE_TITLE[4]</th>");
		echo("<th class='df_th'>$T_TASK_TABLE_TITLE[5]</th>");
		echo("<th class='df_th'>$T_TASK_TABLE_TITLE[6]</th>");
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
			echo("<td class='df_td'>");
			echo("<center>");
			echo("<form method=post>");
			echo("<input type=hidden id=id name=id value=\"$r[0]\">");
			echo("<input class='tbutton' style=\"width:20%;padding:0px 50px 0px 30px;margin:0px;\" type=submit id=cht name=cht value=\"$T_WORK\">");
			echo("</form>");
			echo("</td>");
			echo("</tr>");
		}
		echo("</table>");
		echo("<div class=frow>");
		echo("<div class=pcol2>");
		if (($page>0)and($first>0)){
			echo("<form method=post>");
			$p=$page-1;
			echo("<input type=hidden id=page name=page value=\"$p\">");
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
			echo("<input type=hidden id=page name=page value=\"$p\">");
			echo("<input type=submit id=p name=p value=\"$T_PAGE_RIGHT\">");
			echo("</form>");
		}else{
			echo("<span style=\"color:transparent;\">?</span>");
		}
		echo("</div>");
		echo("</div>");
	}
}


function t_table(){
	t_tasks();
}


?>
