<?php
 #
 # MiniApps
 #
 # info: main folder copyright file
 #
 #

# configuration
$MA_COPYRIGHT="<a href=https://google.com>Google</a>";

# title, home link
$MA_SITENAME="Tasks";
$MA_TITLE="T+";
$MA_CODENAME="mt";
$MA_ROOT_HOME="http://192.168.1.20";
$MA_ROOT_NAME="Intranet";
$MA_SITE_HOME="";
$MA_FAVICON="favicon.png";

# plugins directorys (load dirname.php .css, .js from directory)
$MA_PLUGINS=array();

# language
$MA_LANGFILE="hu.php";

# local app main and css file
$MA_APPFILE=array("$MA_LANGFILE",
                "tcfg.php",
                "tv.php",
                "t1.php",
                "t0.php",
                "su.php",
                "t.php"
            );

$MA_APPCSSFILE=array("t.css");
$MA_APPJSFILE=array("t.js");
$MA_APPPRIVACYFILE="$MA_CONTENT_DIR/privacy.txt";

# SQL
$MA_SQL_SERVER="localhost";
$MA_SQL_DB="demo";
$MA_SQL_USER="demo";
$MA_SQL_PASS="demopassword";

# menu
$MA_ADMINMENU=array();
$MA_FOOTERMENU=array();

# view
$MA_ENABLE_HEADER_VIEW=false;
$MA_ENABLE_FOOTER_VIEW=false;

?>
