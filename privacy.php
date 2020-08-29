<?php

 #
 # MiniTasks - task manager for website
 #
 # info: main folder copyright file
 #
 #


include("config/config.php");
include("config/$MT_LANGFILE");

if (isset($_POST[$MT_STYLEPARAM_NAME])){
    $styleindex=htmlspecialchars($_POST[$MT_STYLEPARAM_NAME]);
}else{
    if (isset($_GET[$MT_STYLEPARAM_NAME])){
        $styleindex=htmlspecialchars($_GET[$MT_STYLEPARAM_NAME]);
    }else{
		$styleindex=0;
    }
}
if ($styleindex>count($MT_CSS)){
    $styleindex=0;
}

include("$MT_HEADER");
include("$MT_JS_BEGIN");



echo("<div class=\"content\">");
echo("<h1>".$L_PRIVACY_HEADER."</h1>");
echo("<div class=\"spaceline\"></div>");


echo("<p>".$L_PRIVACY_TEXT."</p>");

echo("<div class=\"spaceline\"></div>");

echo("<div class=insidecontent><a onclick=\"window.history.back();\"><input type=submit id=submitar name=submitar value=$L_BACKPAGE></a></div>");
			
include("$MT_JS_END");
include("$MT_FOOTER");

?>
