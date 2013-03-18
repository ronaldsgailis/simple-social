<?php
/*
Plugin Name: Simple Social
Plugin URI: http://gail.is/simple-social
Description: Adds facebook like and tweet button to posts without loading remote javascript libraries.
Version: 0.1
Author: Ronalds Gailis
Author URI: http://gail.is
Author Email: ronaldsg@gmail.com
License:

  Copyright 2013 Ronalds Gailis (ronaldsg@gmail.com)

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License, version 2, as 
  published by the Free Software Foundation.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
  
*/

class SimpleSocial {
	
	/**
	 * Initializes the plugin by setting localization, filters, and administration functions.
	 */
	function __construct() {
		
		//Load translations
		add_action('init', array($this, 'load_textdomain'));
	
		//Register site styles and scripts
		add_action('wp_enqueue_scripts', array($this, 'register_plugin_styles'));
		add_action('wp_enqueue_scripts', array($this, 'register_plugin_scripts'));
	
		//Register hooks that are fired when the plugin is activated and uninstalled.
		register_activation_hook(__FILE__, array($this, 'activate'));
		register_uninstall_hook(__FILE__, 'uninstall');
		
		if(is_admin()) {

			// create custom plugin settings menu
			add_action('admin_menu', array($this, 'create_admin_menu'));

			//call register settings function
			add_action('admin_init', array($this, 'register_settings'));
		}

		//Register filter that will handle plugin functionallity
	    add_filter('the_content', array($this, 'add_social_buttons'));

	}
	
	/**
	 * Run when plugin is activated
	 *
	 * @param	boolean	$network_wide	True if WPMU superadmin uses "Network Activate" action, false if WPMU is disabled or plugin is activated on an individual blog 
	 */
	public function activate($network_wide) {
		// create settings fields
		add_option('simple-social-fb_app_id', null);
		add_option('simple-social-twitter_name', null);

	}
	
	
	/**
	 * Fired when the plugin is uninstalled.
	 *
	 * @param	boolean	$network_wide	True if WPMU superadmin uses "Network Activate" action, false if WPMU is disabled or plugin is activated on an individual blog 
	 */
	public function uninstall($network_wide) {

		// delete all plugin settings
		add_option('simple-social-fb_app_id', null);
		add_option('simple-social-twitter_name', null);

	}

	/**
	 * register user accessible settings
	 */
	public function register_settings() {

		register_setting('simple-social-settings-group', 'simple-social-fb_app_id');
		register_setting('simple-social-settings-group', 'simple-social-twitter_name');
	}

	public function create_admin_menu() {

		add_plugins_page(__('Simple Social settings'), __('Simple Social'), 'install_plugins', 'simple-social-menu', array($this, 'settings_page'));

	}

	public function settings_page() {

		return include_once 'simple-social-settings.php';

	}

	/**
	 * Loads the plugin text domain for translation
	 */
	public function load_textdomain() {
	
		$domain = 'simple-social';
		$locale = apply_filters('plugin_locale', get_locale(), $domain);
        load_plugin_textdomain($domain, FALSE, dirname(plugin_basename(__FILE__ )) . '/lang/');

	}
	
	/**
	 * Registers and enqueues plugin-specific styles.
	 */
	public function register_plugin_styles() {
	
		wp_enqueue_style('simple-social-plugin-style', plugins_url('simple-social/css/style.css'));
	
	}
	
	/**
	 * Registers and enqueues plugin-specific scripts.
	 */
	public function register_plugin_scripts() {

		wp_enqueue_script('jquery');
		wp_enqueue_script('simple-social-plugin-script', plugins_url('simple-social/js/script.js'));
	
	}

	/**
	 * appends social button html to the end of post content
	 * @param string $content post content
	 */
	function add_social_buttons($content) {

		global $post;

	    $the_url =  urlencode(get_permalink());
	    $title = urlencode(get_the_title());
	    $fb_app_id = get_option('simple-social-fb_app_id');
		$fb_url = "https://www.facebook.com/dialog/feed?app_id=".$fb_app_id;
		$site_url = site_url();
		$redirect_url = get_permalink();//site_url('thank-you');
    	$fb_url .= "&link=".$site_url;

    	if(has_post_thumbnail()) {
    		$image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'thumbnail');
    		$fb_url .= "&picture=".urlencode($image[0]);
    	}

		$fb_url .= "&name=".$title;
		$fb_url .= "&redirect_uri=".$redirect_url;
		$fb_url .= "&description=".$post->post_excerpt;

		$twitter_url = 'https://twitter.com/intent/tweet?url='.$the_url.'&text='.$title;
		$twitter_name = get_option('simple-social-twitter_name');
		
		//if twitter name is not set in plugin options, then skip adding via to tweet
		if(!$twitter_name) {
			$twitter_url .= '&via='.$twitter_name;
		}

		$twitter_name = get_option('simple-social-twitter_name');
	    $button_html = 
	    '<ul class="social clearfix">
	        <li>
	        	<a href="'.$twitter_url.'" class="twitter" target="_blank" rel="nofollow">'.__('Tweet').'</a>
	        </li>';

	    if($fb_app_id) {
	    	$button_html .=
	        '<li>
		        <a href="'.$fb_url.'" class="facebook" target="_blank" rel="nofollow">'.__('Share').'</a>
	        </li>';
	    }
	    $button_html .= '</ul>';

	return $content.$button_html;

	}
}

$simple_social = new SimpleSocial();
?>