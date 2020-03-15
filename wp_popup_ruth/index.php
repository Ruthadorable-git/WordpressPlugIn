<?php
/*
Plugin Name: Ruth Popup
Plugin URI: http://www.ruthannadorable.com
Version: 1.0
Author: Ruth Ann ADORABLE
Author URI: http://www.ruthannadorable.com
License: GPL2
Text Domain :wp_popup_ruth
*/
function ruth_popup_page(){
//dd_menu_page('Plugin de Popup | Reglages','Reglages de la popup', 'administrator','popup_jb','popup_jb_function','dashicons-format-aside',40);
	add_submenu_page('options-general.php','Plugin de Popup | Reglages','Reglages de la popup', 'administrator','popup_ruth','popup_ruth_function');
}
add_action('admin_menu','ruth_popup_page');
function popup_ruth_function(){
	include ('ruth_popup_admin.php');
};


function ruth_popup_admin_js(){

	wp_enqueue_script('jquery_admin',plugins_url('ruth_popup_admin.js',__FILE__),array('jquery'),'1.0');
	wp_enqueue_style('admin_css',plugins_url('ruth_popup_admin.css',__FILE__));
}

add_action('admin_menu','ruth_popup_admin_js');

function ruth_popup_jscss(){
	wp_enqueue_script('wp_popup_ruth_js',plugins_url('ruth_popup.js',__FILE__),array('jquery'),'1.0');
	wp_enqueue_style('wp_popup_ruth_css',plugins_url('ruth_popup.css',__FILE__)
	);
}
add_action('wp_head','ruth_popup_jscss');

function ruth_popup_content_display(){
	$contenu_popup=get_option('popup_ruth_contenu'); //aller chercher le contenu de l'option en bd
	$contenu_popup=stripslashes($contenu_popup);
	echo '

<!-- Popup Div Starts Here -->
<div id="popupContact">
<!-- Contact Us Form -->
<form action="#" id="form" method="post" name="form">
<img id="close" src="images/3.png" onclick ="div_hide()">
<h2>Contact Us</h2>
<hr>
<input id="name" name="name" placeholder="Name" type="text">
<input id="email" name="email" placeholder="Email" type="text">
<textarea id="msg" name="message" placeholder="Message"></textarea>
<a href="javascript:%20check_empty()" id="submit">Send</a>
</form>
</div>
<!-- Popup Div Ends Here -->
</div>
<!-- Display Popup Button -->
<h1>Click Button To Popup Form Using Javascript</h1>
<button id="popup" onclick="div_show()">Popup</button>

';
}
function jb_popup_display_options(){

$popup_ruth_actif=get_option('popup_ruth_actif'); //aller chercher le contenu de l'option en bd
$popup_ruth_display=get_option('popup_ruth_display'); //aller chercher le contenu de l'option en bd
$popup_ruth_display_pages=get_option('popup_ruth_display_pages'); //aller chercher le contenu de l'option en bd
if($popup_ruth_actif=='oui'){
	if($popup_ruth_display==1){//sur la page d'accueil uniquement
		if(is_front_page() || is_home() ){
				add_action('wp_footer','ruth_popup_content_display');
		}

	}else if($popup_ruth_display==2){//sur toutes les pages
		add_action('wp_footer','ruth_popup_content_display');

	}else{//sur certaines pages uniquement
		$page_id=get_the_ID();
		if(in_array($page_id, $popup_ruth_display_pages)){
			if(is_page()){
				add_action('wp_footer','ruth_popup_content_display');
			}
		}
	}
}
}
add_action('wp_head','ruth_popup_display_options');




add_action('wp_footer','ruth_popup_content_display');
//Fonction à rajouter pour rendre  le plugin traduisible
function ruth_popup_load_text_domain(){
	load_plugin_textdomain('wp_popup_jb',false,dirname(plugin_basename(__FILE__)).'/languages/');
}
add_action('plugins_loaded','ruth_popup_load_text_domain');
?>
