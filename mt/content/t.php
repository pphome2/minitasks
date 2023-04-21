<?php

 #
 # MiniApp
 #
 # info: main folder copyright file
 #
 #


if (function_exists(su_loadusers)){
	su_loadusers();
}


function searchpage(){
	global $T_SEARCH_TEXT,$L_BUTTON_NEXT,$L_SEARCH;

	searchview($T_SEARCH_TEXT,$L_BUTTON_NEXT,$L_SEARCH);
}


function privacypage(){
    global $T_PRIV_TEXT,$MA_APPPRIVACYFILE;

    privacyview($T_PRIV_TEXT,$MA_APPPRIVACYFILE);
}


function printpage(){

    echo("<a href='start.php' style='text-decoration:none;color:black;'>");
    #t_print();
    echo("</a>");
}


function t_header(){
    echo("<header></header>");
}


function t_footer(){
    echo("<footer></footer>");
}


function t_data(){
    global $MA_MENU_FIELD,$T_MENUCODE,$T_AMENUCODE;

    #echo("<div class=spaceline></div>");
    echo("<div class=content>");
    if (isset($_GET[$MA_MENU_FIELD])){
        switch ($_GET[$MA_MENU_FIELD]){
            case $T_MENUCODE[0]:
          		t_tableall();
                break;
            case $T_AMENUCODE[0]:
          		su_user();
                break;
            default:
                t_table();
                break;
        }
    }else{
        t_table();
    }
    echo("</div>");
    #echo("<div class=spaceline></div>");
}

function main(){
    #loadplugin("table");
    #loadplugin("cards");
    sql_install();
    t_header();
    t_data();
    t_footer();
}

function view(){
    #loadplugin("table");
    #loadplugin("cards");
    t_header();
    t_view();
    t_footer();
}


?>
