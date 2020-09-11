<?php

 #
 # MiniApps - framework
 #
 # info: main folder copyright file
 #
 #
 #

# userpage

# load config 
if (file_exists("config/config.php")){
	include("config/config.php");
}

echo($MA_DOCTYPE);
 
for ($i=0;$i<count($MA_LIB);$i++){
	if (file_exists("$MA_LIB[$i]")){
		include("$MA_LIB[$i]");
	}
}

if (file_exists("$MA_CONFIG_DIR/$MA_LANGFILE")){
	include("$MA_CONFIG_DIR/$MA_LANGFILE");
}

$MA_USERPAGE=true;

# css setting
setcss();

# load local app file
if (file_exists("$MA_APPFILE")){
	include("$MA_APPFILE");
}
# header, page, footer
if (function_exists("userpage")){
	userpage();
}

# end local app file
if (file_exists("$MA_JS_END")){
	include("$MA_JS_END");
}


?>
