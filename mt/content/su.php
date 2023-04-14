<?php

 #
 # WSystem User - felhasználókezelés
 #
 # info: main folder copyright file
 #
 #


# nyelvi változók, amiket használ a modul
#$SU_OK="megtörtént";
#$SU_ERROR="hiba történt";
#$SU_SAVE="Mentés";
#$SU_SEARCH="Keresés...";
#
#$SU_GO=">>>";
#$SU_PAGE_RIGHT=">";
#$SU_PAGE_LEFT="<";
#$SU_BACK="Vissza";
#$SU_WORK=">>>";
#
#$SU_NEW="Új felhasználó";
#$SU_TITLE_NEW="Új felhasználó";
#$SU_TITLE_CHANGE="Felhasználó módosítása";
#$SU_TITLE_DEL="Felhasználó törlése";
#$SU_FIELDS=array("ID","Név","Jelszó","Adminisztrátor");
#$SU_TABLE_TITLE=array("Név","Jelszó","Adminisztrátor","Módosít");
#$SU_DEL_USER="Felhasználó törlése";
#
#$SU_USER_ROLE=array("Adminisztrátor","Felhasználó");

# !!! a fájl betöltése előbb legyen mint a vezérlő fájl betöltése

# vezérlő fájlba:
#if (function_exists(su_loadusers)){
#	su_loadusers();
#}

# sql struktúra:
#create table if not exists mt_user (
#    id bigint auto_increment primary key,
#    username varchar(40) charset utf8,
#    userpw varchar(40) charset utf8,
#    admin int,
#    key name (username(20))
#) engine=InnoDB default charset latin1;


# sql tábla neve
$SU_SQL_USER_TABLE="mt_user";



function su_loadusers(){
	global $MA_USERS_CRED,$SU_SQL_USER_TABLE,$MA_SQL_RESULT,$MA_USERS_ADMINUSERS;

	sql_run("select * from $SU_SQL_USER_TABLE order by id;");
	$index=count($MA_USERS_CRED);
	for($i=0;$i<count($MA_SQL_RESULT);$i++){
		$r=$MA_SQL_RESULT[$i];
		$x=$index+$i;
		$MA_USERS_CRED[$x]=array($r[1],$r[2]);
		if ($r[3]==0){
			$idx=count($MA_USERS_ADMINUSERS);
			$MA_USERS_ADMINUSERS[$idx]=$r[1];
		}
	}
}


function su_genid(){
	$id=date('YmdHis');
	return($id);
}


function su_userdel(){
	global $SU_TITLE_DEL,$SU_OK,$SU_ERROR,$SU_SQL_USER_TABLE;

		if (isset($_POST['idd'])){
			$id=$_POST['idd'];
			$sqlc="delete from $SU_SQL_USER_TABLE where id=$id;";
			if (sql_run($sqlc)){
				mess_ok($SU_TITLE_DEL.": ".$SU_OK.".");
			}else{
				mess_error($SU_TITLE_DEL.": ".$SU_ERROR.".");
			}
		}
}


function su_userdata($new){
	global $MA_SQL_RESULT,$SU_FIELDS,$MA_ADMINFILE,$SU_SQL_USER_TABLE,
			$SU_SAVE,$SU_TITLE_NEW,$SU_TITLE_CHANGE,
			$SU_OK,$SU_ERROR,$SU_DEL_USER,$SU_USER_ROLE;

	$form=true;
	$db=count($SU_FIELDS);
	if ($new){
		$title=$SU_TITLE_NEW;
		if (isset($_POST['0'])){
			$form=false;
			$da=$_POST[0];
			$da=$da.", '".$_POST[1]."'";
			$da=$da.", '".md5($_POST[2])."',";
			$da=$da.$_POST[3];
			$sqlc="insert into $SU_SQL_USER_TABLE (id,username,userpw,admin) values ($da);";
			if (sql_run($sqlc)){
				mess_ok($SU_TITLE_NEW.": ".$SU_OK.".");
			}else{
				mess_error($SU_TITLE_NEW.": ".$SU_ERROR.".");
			}
		}
		$d[0]=su_genid();
		for($i=1;$i<$db;$i++){
			$d[$i]="";
		}
	}else{
		$title=$SU_TITLE_CHANGE;
		if (isset($_POST['id'])){
			if (isset($_POST['id2'])){
				$form=false;
				$id2=$_POST['id2'];
				$sqlc="update $SU_SQL_USER_TABLE set";
				$sqlc=$sqlc." id = ".$_POST[0].", ";
				$sqlc=$sqlc." username = \"$_POST[1]\", ";
				if ($_POST['pw']<>$_POST[2]){
					$pw=md5($_POST[2]);
				}else{
					$pw=$_POST[2];
				}
				$sqlc=$sqlc." userpw = \"".$pw."\", ";
				$sqlc=$sqlc." admin = $_POST[3] ";
				$sqlc=$sqlc." where id=$id2;";
				if (sql_run($sqlc)){
					mess_ok($SU_TITLE_CHANGE.": ".$SU_OK.".");
				}else{
					mess_error($SU_TITLE_CHANGE.": ".$SU_ERROR.".");
				}
			}
			$id=$_POST['id'];
			$sqlc="select * from $SU_SQL_USER_TABLE where id=$id;";
			if (sql_run($sqlc)){
				$r=$MA_SQL_RESULT[0];
				for($i=0;$i<$db;$i++){
					$d[$i]=$r[$i];
				}
			}else{
				$d[0]=su_genid();
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
		echo("<input type=hidden id=0 name=0 value='$d[0]'>");
		echo("<div class=frow>");
		echo("<div class=fcol1>$SU_FIELDS[1]");
		echo("</div>");
		echo("<div class=fcol2>");
		echo("<input type=text id=1 name=1 placeholder='$SU_FIELDS[1]' value='$d[1]'>");
		echo("</div>");
		echo("</div>");
		echo("<div class=frow>");
		echo("<div class=fcol1>$SU_FIELDS[2]");
		echo("</div>");
		echo("<div class=fcol2>");
		echo("<input type=password id=2 name=2 placeholder='$SU_FIELDS[2]' value='$d[2]'>");
		echo("</div>");
		echo("</div>");
		echo("<div class=frow>");
		echo("<div class=fcol1>$SU_FIELDS[3]");
		echo("</div>");
		echo("<div class=fcol2>");
		echo("<select id=3 name=3>");
		for($i=0;$i<count($SU_USER_ROLE);$i++){
			echo("<option value=$i>$SU_USER_ROLE[$i]</option>");
		}
		echo("</select>");
		echo("</div>");
		echo("</div>");
		echo("<div class=frow><br /></div>");
		if ($new){
			echo("<input type=hidden id=id name=id value=\"$d[0]\">");
			echo("<input type=submit id=newu name=newu value=\"$SU_SAVE\">");
			echo("</form>");
		}else{
			echo("<input type=hidden id=id name=id value=\"$d[0]\">");
			echo("<input type=hidden id=id2 name=id2 value=\"$d[0]\">");
			echo("<input type=hidden id=pw name=pw value=\"$d[2]\">");
			echo("<input type=submit id=chu name=chu value=\"$SU_SAVE\">");
			echo("</form>");
			echo("<div class=frow><br /></div>");
			echo("<form method=post>");
			echo("<input type=hidden id=idd name=idd value=\"$d[0]\">");
			echo("<input  type=submit id=delu name=delu value=\"$SU_DEL_USER\">");
			echo("</form>");
		}
		return(false);
	}
	return(true);
}


function su_user(){
	global $MA_SQL_RESULT,$SU_NEW,$SU_TABLE_TITLE,$SU_USER_ROLE,$SU_SQL_USER_TABLE,
			$SU_WORK,$SU_SEARCH,$SU_PAGEROW,$SU_PAGE_LEFT,$SU_PAGE_RIGHT;

	if(!isset($SU_PAGEROW)){
		$SU_PAGEROW=100;
	}
	$ptable=true;
	if (isset($_POST['newu'])){
		$ptable=su_userdata(true);
	}
	if (isset($_POST['delu'])){
		su_userdel();
	}
	if (isset($_POST['chu'])){
		$ptable=su_userdata(false);
	}
	if ($ptable){
		$page=0;
		$first=0;
		if (isset($_POST['page'])){
			$page=(int)$_POST['page'];
			$first=$SU_PAGEROW*$page;
		}
		$last=false;
		if (sql_run("select count(*) from $SU_SQL_USER_TABLE;")){
			$r=$MA_SQL_RESULT[0];
			$odb=$r[0];
			$adb=$first+$SU_PAGEROW;
			if ($adb>=$odb){
				$last=true;
			}
		}
		echo("<form method=post>");
		echo("<input type=submit id=newu name=newu value=\"$SU_NEW\">");
		echo("</form>");
		echo("<input type=text id=search onkeyup='searchtable()' placeholder=\"$SU_SEARCH\">");
		sql_run("select * from $SU_SQL_USER_TABLE order by id limit $first,$SU_PAGEROW;");
		echo("<center>");
		echo("<table class='df_table_full' id=ptable>");
		echo("<tr class='df_trh'>");
		echo("<th class='df_th'>$SU_TABLE_TITLE[0]</th>");
		echo("<th class='df_th'>$SU_TABLE_TITLE[1]</th>");
		echo("<th class='df_th'>$SU_TABLE_TITLE[2]</th>");
		echo("<th class='df_th'>$SU_TABLE_TITLE[3]</th>");
		echo("</tr>");
		$db=count($MA_SQL_RESULT);
		for($i=0;$i<$db;$i++){
			$r=$MA_SQL_RESULT[$i];
			echo("<tr class=df_tr>");
			echo("<td class='df_td'>$r[1]</td>");
			echo("<td class='df_td'>$r[2]</td>");
			$xid=$r[3];
			echo("<td class='df_td'>$SU_USER_ROLE[$xid]</td>");
			echo("<td class='df_td'>");
			echo("<center>");
			echo("<form method=post>");
			echo("<input type=hidden id=id name=id value=\"$r[0]\">");
			echo("<input class='tbutton' style=\"width:20%;padding:0px 50px 0px 30px;margin:0px;\" type=submit id=chu name=chu value=\"$SU_WORK\">");
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
			echo("<input type=hidden id=page name=page value=$p>");
			echo("<input type=submit id=p name=p value=\"$SU_PAGE_LEFT\">");
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
		if (($db==$SU_PAGEROW)and(!$last)){
			$p=$page+1;
			echo("<form method=post>");
			echo("<input type=hidden id=page name=page value=$p>");
			echo("<input type=submit id=p name=p value=\"$SU_PAGE_RIGHT\">");
			echo("</form>");
		}else{
			echo("<span style=\"color:transparent;\">?</span>");
		}
		echo("</div>");
		echo("</div>");
	}
}


?>
