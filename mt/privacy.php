<?php

 #
 # MiniApps - framework
 #
 # info: main folder copyright file
 #
 #


# load config and  language file
if (!isset($MA_CONFIG_DIR)){
    if (file_exists("config/config.php")){
	    include("config/config.php");
    }
    if (file_exists("$MA_CONFIG_DIR/$MA_LANGFILE")){
	    include("$MA_CONFIG_DIR/$MA_LANGFILE");
    }
}


for ($i=0;$i<count($MA_LIB);$i++){
	if (file_exists("$MA_INCLUDE_DIR/$MA_LIB[$i]")){
		include("$MA_INCLUDE_DIR/$MA_LIB[$i]");
	}
}

# local app files
if (file_exists("$MA_CONTENT_DIR/$MA_APPFILE[0]")){
	include("$MA_CONTENT_DIR/$MA_APPFILE[0]");
}
for ($i=0;$i<count($MA_APPFILE);$i++){
	if (file_exists("$MA_CONTENT_DIR/$MA_APPFILE[$i]")){
		include("$MA_CONTENT_DIR/$MA_APPFILE[$i]");
	}
}

# prepare system
startcookies();
setcss();

$MA_PRIVACY_PAGE=true;
$MA_BACKPAGE=true;

# build page: header
$mainpage=refererpage();
page_header();

# privacy data to screen
#$MA_NOPAGE=true;

# load local app jsfile
for ($i=0;$i<count($MA_APPJSFILE);$i++){
	if (file_exists("$MA_CONTENT_DIR/$MA_APPJSFILE[$i]")){
		include("$MA_CONTENT_DIR/$MA_APPJSFILE[$i]");
	}
}

if (function_exists("privacypage")){
	privacypage();
}

button_back();

# page footer
page_footer();

?>
