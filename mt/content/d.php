<?php

 #
 # MiniApp
 #
 # info: main folder copyright file
 #
 #


function searchpage(){
    global $D_TITLE,$MA_BUTTON_TEXT,$MA_SEARCH_TEXT;

    searchview($D_TITLE,$MA_BUTTON_TEXT,$MA_SEARCH_TEXT);
}


function privacypage(){
    global $D_TITLE,$MA_APPPRIVACYFILE;

    privacyview($D_TITLE,$MA_APPPRIVACYFILE);
}


function printpage(){

    echo("<a href='start.php' style='text-decoration:none;color:black;'>");
    #d_print();
    echo("</a>");
}


function d_header(){
    echo("<header></header>");
}


function d_footer(){
    echo("<footer></footer>");
}


function d_table(){
    echo("123...");
}


function d_data(){
    global $MA_MENU_FIELD,$I_MENUCODE;;

    echo("<div class=spaceline></div>");
    echo("<div class=content>");
    if (isset($_GET[$MA_MENU_FIELD])){
        switch ($_GET[$MA_MENU_FIELD]){
            case $I_MENUCODE[0]:
                break;
            default:
                d_table();
                break;
        }
    }else{
        d_table();
    }
    echo("</div>");
    echo("<div class=spaceline></div>");
}

function d_view(){
    echo("<div class=spaceline></div>");
    echo("<div class=content>");
    echo("</div>");
    echo("<div class=spaceline></div>");
}

function main(){
    #loadplugin("table");
    #loadplugin("cards");
    d_header();
    d_data();
    d_footer();
}

function view(){
    #loadplugin("table");
    #loadplugin("cards");
    d_header();
    d_view();
    d_footer();
}


?>
