<?php

 #
 # MiniApps - framework
 #
 # info: main folder copyright file
 #
 #

# configuration

# copyright link
$MA_COPYRIGHT="© ".date("Y").". <a href=https://github.com/pphome2>Github</a>";

# need md5 passcode -- user password: password - admin password: adminpassword
$MA_ADMIN_PASS="e3274be5c857fb42ab72d786e281b4b8";
$MA_USER_PASS="5f4dcc3b5aa765d61d8327deb882cf99";

# title, home link
$MA_SITENAME="MiniApp - frame";
$MA_SITE_HOME="http://www.google.com";
$MA_DOCTYPE="<!DOCTYPE HTML>";

# directories
$MA_CONFIG_DIR="config";
$MA_INCLUDE_DIR="inc";
$MA_CONTENT_DIR="content";

$MA_COOKIE_STYLE="st";
$MA_COOKIE_PASSWORD="passw";
$MA_COOKIE_TIME="ltime";

# include files
$MA_ADMINFILE="start.php";
$MA_PRIVACY="privacy.php";
$MA_PRINTFILE="print.php";
$MA_CSS=array(
			"$MA_INCLUDE_DIR/sitew.css",
			"$MA_INCLUDE_DIR/siteb.css"
			);
$MA_CSSPRINT="$MA_INCLUDE_DIR/sitepr.css";
$MA_JS_BEGIN="$MA_INCLUDE_DIR/js_begin.js";
$MA_JS_END="$MA_INCLUDE_DIR/js_end.js";
$MA_HEADER="$MA_INCLUDE_DIR/header.php";
$MA_FOOTER="$MA_INCLUDE_DIR/footer.php";
$MA_LIB=array(
			"$MA_INCLUDE_DIR/lib.php",
			"$MA_INCLUDE_DIR/libview.php"
			);

# local app admin file
$MA_APPFILE="$MA_CONTENT_DIR/minitasks.php";

# language
$MA_LANGFILE="hu.php";

# search
$MA_SEARCH_ICON_HREF="search.php";
$MA_SEARCH_ICON_JS="";

# other variables
$MA_NOPAGE=false;
$MA_PASSWORD="";
$MA_LOGIN_TIME="";
$MA_LOGGEDIN=false;
$MA_STYLEINDEX=0;
$MA_LOGOUT_IN_HEADER=true;

# auto logout - second
$MA_LOGIN_TIMEOUT=600;
$MA_ENABLE_COOKIES=true;
$MA_ADMIN_USER=false;

# menu
$MA_MENU_FIELD="m";
$MA_MENU=array();

# if not enable cookie support:
# - all form need add this lines
#
#		<input type='hidden' name='$MA_COOKIE_PASSWORD' id='$MA_COOKIE_PASSWORD' value='$MA_PASSWORD'>
#		<input type='hidden' name='$MA_COOKIE_STYLE' id='$MA_COOKIE_STYLE' value='$MA_STYLEINDEX'>
#		<input type='hidden' name='$MA_COOKIE_TIME' id='$MA_COOKIE_TIME' value='$MA_LOGIN_TIME'>
#


############################################

# local app config, variables

$MA_MENU=array(
				array("Lista","list.php")
			);

$MA_SEARCH_ICON_JS="cardopenclose(cardbodyf);return false;";

$MT_AUTO_DATE_TO_FIRST=true;

$MT_CSSLIST="mt.css";

$MT_TASKS_ROOT="tasks";
$MT_SCHEMA_FILE="schema";
$MT_FIRST_TASKS_FILE="default";

$MT_ARCHIVE_MAXNUM=20;

$MT_SEPARATE_CHAR="|";
$MT_SEPARATE_CHAR_FILTER="#";
$MT_PARAM_DEL="del";
$MT_PARAM_DATA="dal";

?>
