<?php
/*
Plugin Name: SampleOptionsPage
Plugin URI: http://dev.wp-plugins.org/SmallOptions
Description: This creates an options page that uses the SmallOptions, if it's enabled.
Version: 1.0
Author: Owen Winkler
Author URI: http://www.asymptomatic.net
*/
/*
SampleOptionsPage - This creates an options page that uses 
the SmallOptions, if it's enabled.
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

class SampleOptionsPage
{
	function options_page_contents()
	{
		/** Commit changed options if posted **/
		if($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			update_option('SampleOptionsPage_options', $_POST['SampleOptionsPage_options']);
			update_option('SampleOptionsPage_settings', $_POST['SampleOptionsPage_settings']);
		}
		echo '<h2>Sample Options Page</h2>';
		echo '<p>This here is a sample options page.  It doesn\'t actually do anything except accept option settings.</p>';
		echo '<ul>';
		echo '<li><label for="option_one"><input type="checkbox" id="option_one" name="SampleOptionsPage_options[]" value="option_one"' . SampleOptionsPage::checkflag('option_one') . ' /> Check Option One</label></li>';
		echo '<li><label for="option_two"><input type="checkbox" id="option_two" name="SampleOptionsPage_options[]" value="option_two"' . SampleOptionsPage::checkflag('option_two') . ' /> Check Option Two</label></li>';
		echo '<li><label for="setting_one">Setting One: <input type="text" id="setting_one" name="SampleOptionsPage_settings[setting_one]" value="' . SampleOptionsPage::form_setting('setting_one') . '" /></label></li>';
		echo '<li><label for="setting_two">Setting Two: <input type="text" id="setting_two" name="SampleOptionsPage_settings[setting_two]" value="' . SampleOptionsPage::form_setting('setting_two') . '" /></label></li>';
		echo '</ul>';
	}
	
	function checkflag($optname)
	{
		$options = get_settings('SampleOptionsPage_options');
		if(!is_array($options)) return '';
		return in_array($optname, $options) ? ' checked="checked"' : '';
	}
	
	function form_setting($optname)
	{
		$options = get_settings('SampleOptionsPage_settings');
		return htmlspecialchars($options[$optname], ENT_QUOTES);
	}

	function options_page()
	{
		/** Display "saved" notification on post **/
		if(isset($_POST['SampleOptionsPage_submit']))
		{
			echo '<div class="updated"><p><strong>' . __('Options saved.', 'SmallOptions') . '</strong></p></div>';
		}

		echo '<form method="post"><div class="wrap">';
		
		SampleOptionsPage::options_page_contents();
		
	  echo '<p class="submit"><input type="submit" name="SampleOptionsPage_submit" value="Update Options &raquo;" /></p></div>';
		echo '</form>';
	}
	
	function admin_menu()
	{
		if(class_exists('SmallOptions'))
			add_action('small_options_page', array('SampleOptionsPage', 'options_page_contents'));
		else
			add_options_page('Sample Options Page', 'Sample', 5, basename(__FILE__), array('SampleOptionsPage', 'options_page'));
	}
}

add_action('admin_menu', array('SampleOptionsPage', 'admin_menu'));
?>