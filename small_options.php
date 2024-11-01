<?php
/*
Plugin Name: SmallOptions
Plugin URI: http://dev.wp-plugins.org/SmallOptions
Description: Provides a location for plugins with a small options interface to conveniently insert their options without cluttering the admin UI.
Version: 1.0
Author: Owen Winkler
Author URI: http://www.asymptomatic.net
*/
/*
SmallOptions - Provides a location for plugins with a small 
options interface to conveniently insert their options without 
cluttering the admin UI.
Copyright (c) 2004 Owen Winkler

This program is free software; you can redistribute it
and/or modify it under the terms of the GNU General Public
License as published by the Free Software Foundation;
either version 2 of the License, or (at your option) any
later version.

This program is distributed in the hope that it will be
useful, but WITHOUT ANY WARRANTY; without even the implied
warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR
PURPOSE. See the GNU General Public License for more
details.

You should have received a copy of the GNU General Public
License along with this program; if not, write to the Free
Software Foundation, Inc., 59 Temple Place, Suite 330,
Boston, MA 02111-1307 USA
*/

load_plugin_textdomain('SmallOptions');

class SmallOptions
{
	function options_page()
	{
		global $submenu, $wp_filter;
		
		if(isset($_POST['SmallOptions_submit']))
		{
			echo '<div class="updated"><p><strong>' . __('Options saved.', 'SmallOptions') . '</strong></p>';
			do_action('small_options_submit');
			echo '</div>';
		}
		
		echo '<div class="wrap"><h2>' . __('Plugin Options', 'SmallOptions') . '</h2>';
		_e('<p>This page allows you to set options for several installed plugins at once.</p>  <p>Set the options in each section, then click "Update Options" at the bottom of the page to apply your choices.</p>', 'SmallOptions');
		echo '</div>';
		echo '<form method="post">';
		
		SmallOptions::small_options_page('small_options_page');
		
	  echo '<div class="wrap"><p class="submit"><input type="submit" name="SmallOptions_submit" value="' . __("Update Options &raquo;", 'SmallOptions') . '" /></p></div>';
		echo '</form>';
	}
	
	function small_options_page() {
		global $wp_filter;

		$args = array('');
		
		merge_filters('small_options_page');
		
		if (!isset($wp_filter['small_options_page'])) {
			return;
		}
		echo '<div class="wrap">';
		foreach ($wp_filter['small_options_page'] as $priority => $functions) {
			if (!is_null($functions)) {
				foreach($functions as $function) {
					$all_args = array_merge(array($string), $args);
					$function_name = $function['function'];
					$args = $all_args;
					$string = call_user_func_array($function_name, $args);
				}
			}
		}
		echo '</div>';
	}

	function admin_menu()
	{
		add_options_page(__('Plugin Options', 'SmallOptions'), __('Plugins', 'SmallOptions'), 5, basename(__FILE__), array('SmallOptions', 'options_page'));
	}
}

add_action('admin_menu', array('SmallOptions', 'admin_menu'), 9999);
?>