<?php 
/*
  Plugin Name: زیگزاگ پُست مهمان
  Plugin URI: http://Mehr-shop.ir/
  Description: زیگزاگ :: مدیریت درج مطلب وبسایت زیگزاگ
  Version: 1.95.8
  Author: مهرگان سیستم
  Author URI: http://mehregan-system.com/
  License: GPLv2+
  Text Domain: zigzagguestpost
*/
if(session_id() == '') session_start();
class ZigZagGuestPost{
	function __construct() {
	global $wpdb;
	$this->pre='zigzagguestpost';
	//define table Name
	$this->tblGpost = $wpdb->prefix . $this->pre.'_post';
	
	$this->setting = get_option($this->pre."site");
	$this->ProductRow = 16;
	 
	//define show basket in page
	add_filter('the_content',array($this,'ViewGuestPost')); //
	add_action('admin_menu', array($this,'wpa_add_menu'));
	add_action('admin_enqueue_scripts', array($this, 'wpa_styles'));
	add_action('wp_enqueue_scripts', array($this, 'wpa_styles'));
	register_activation_hook(__FILE__, array($this, 'wpa_install'));
	register_deactivation_hook(__FILE__, array($this, 'wpa_uninstall'));

	//define show shopbox in post type
	//add_action('add_meta_boxes',array($this,'add_shopping'));
	//add_action('save_post',array($this,'cd_meta_box_save_shopping'));
}
//------------------------------------------------------------------
function wpa_add_menu(){//Admin Menu
	add_menu_page( 'مدیریت درج مطلب زیگزاگ', 'زیگزاگ مطلب', 'manage_options', 'zigzagpost-dashboard', array(__CLASS__,'wpa_page_file_path'), plugins_url('images/logo.jpg', __FILE__),'99.3.9');
	add_submenu_page( 'zigzagpost-dashboard', 'داشبورد', ' داشبورد', 'manage_options', 'zigzagpost-dashboard', array(__CLASS__,'wpa_page_file_path'));
	add_submenu_page( 'zigzagpost-dashboard', 'پُست ها', 'پُست ها', 'manage_options', 'zigzagpost-post', array(__CLASS__,'wpa_page_file_path'));
	//add_submenu_page( 'zigzagpost-dashboard', 'پلان ها', 'پلان ها', 'manage_options', 'zigzagpost-plan', array(__CLASS__,'wpa_page_file_path'));
	add_submenu_page( 'zigzagpost-dashboard', 'تنظیمات', 'تنظیمات', 'manage_options', 'zigzagpost-setting', array(__CLASS__,'wpa_page_file_path'));
}
//------------------------------------------------------------------
function wpa_page_file_path() {
	$screen = get_current_screen();
	if(strpos($screen->base, 'zigzagpost-post')!== false){include( dirname(__FILE__) . '/includes/posts.php' );}
	elseif (strpos($screen->base, 'zigzagpost-setting')!== false){include( dirname(__FILE__) . '/includes/setting.php' );}
	elseif (strpos($screen->base, 'zigzagpost-ordinfo')!== false){include( dirname(__FILE__) . '/includes/orderinfo.php' );}
	elseif (strpos($screen->base, 'zigzagpost-plan')!== false){include( dirname(__FILE__) . '/includes/plan.php' );}
	else {include( dirname(__FILE__) . '/includes/dashboard.php' );}
}
//------------------------------------------------------------------
function GetPostList($action="all",$col="",$data="")
{
	if($action=="all") $results = $GLOBALS['wpdb']->get_results("SELECT * FROM {$this->tblGpost} order by id desc",ARRAY_A );
	if($action=="userID") $results = $GLOBALS['wpdb']->get_results("SELECT * FROM {$this->tblGpost} where $col=$data order by id desc",ARRAY_A );
	if($action=="row") $results = $GLOBALS['wpdb']->get_row("SELECT * FROM {$this->tblGpost} where $col=$data order by id desc",ARRAY_A );
	return $results;
}
//------------------------------------------------------------------
function wpa_styles($page){
	wp_enqueue_style('wp-analytify-style',plugins_url('css/style.css',__FILE__));
}
//------------------------------------------------------------------
function wpa_install() {
	include(dirname(__FILE__).'/includes/db/database.php');
}
//------------------------------------------------------------------
function wpa_uninstall() {
}
//------------------------------------------------------------------
function ViewGuestPost($content='') {
	if($this->setting['enable']==1 and is_page($this->setting['f4']))
	{
		if($this->setting['guest']==1)
		{
			$current_user = wp_get_current_user();
			if(isset($current_user->id))
			$content=include_once(dirname(__FILE__).'/includes/add_post.php');
			else
			$content="این بخش فقط برای اعضای سایت قابل دسترسی می باشد.";
		}
		else
		$content=include_once(dirname(__FILE__).'/includes/add_post.php');
	}
	return $content;
}
//------------------------------------------------------------------
}
$query=new ZigZagGuestPost();
?>