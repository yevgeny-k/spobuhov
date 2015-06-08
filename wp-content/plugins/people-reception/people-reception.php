<?php
/*
Plugin Name: Народная приемная
Plugin URI: https://github.com/yevgeny-k/spobuhov
Description: Плагин, реализующий функциональность, необходимую порталу www.spobuhov.ru. В основном, создает просто необходимые сущности без полей. Поля добаляются сторонними плагинами.
Version: 1.0
Author: Yevgeny Kozin
Author URI: https://www.facebook.com/evgn.kozin
Domain Path: /languages
Text Domain: reception
*/

if(!class_exists('People_Reception_Plugin'))
{
	class People_Reception_Plugin
	{
		public function __construct()
		{
			// Регистрируем сущности
			require_once(sprintf("%s/post-types/appeal.php", dirname(__FILE__)));
			require_once(sprintf("%s/post-types/book.php", dirname(__FILE__)));
			require_once(sprintf("%s/post-types/bill.php", dirname(__FILE__)));
			require_once(sprintf("%s/post-types/transcript.php", dirname(__FILE__)));
			require_once(sprintf("%s/post-types/voting.php", dirname(__FILE__)));			

			$appeal = new Appeal();
			$book = new Book();
			$bill = new Bill();
			$transcript = new Transcript();
			$voting = new Voting();
		}

		public static function activate()
		{
		}

		public static function deactivate()
		{
		}
	}
}

if(class_exists('People_Reception_Plugin'))
{
	register_activation_hook(__FILE__, array('People_Reception_Plugin', 'activate'));
	register_deactivation_hook(__FILE__, array('People_Reception_Plugin', 'deactivate'));
	$people_reception_plugin = new People_Reception_Plugin();
}

// Языковая поддержка
function reception_load_textdomain() {
	load_plugin_textdomain('reception', false, dirname(plugin_basename( __FILE__ )) . '/languages'); 
}
add_action('plugins_loaded', 'reception_load_textdomain');
?>