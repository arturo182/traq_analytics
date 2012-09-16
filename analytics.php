<?php
/*!
 * Traq
 * Copyright (C) 2009-2012 Traq.io
 * 
 * This file is part of Traq.
 * 
 * Traq is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; version 3 only.
 * 
 * Traq is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with Traq. If not, see <http://www.gnu.org/licenses/>.
 */

use avalon\Database;

/**
 * Google Analytics Plugin.
 *
 * @package Traq
 * @subpackage Plugins
 * @author Jack P.
 * @copyright (c) Jack P.
 */
class Plugin_analytics extends PluginBase
{
	public static function info()
	{
		return array(
			'name' => HTML::link('Google Analytics', '/admin/plugins/analytics'),
			'version' => '0.1',
			'author' => 'arturo182'
		);
	}

	public static function __install()
	{
		Database::connection()->insert(array('setting' => 'analytics'))->into('settings')->exec();
	}

	public static function __uninstall()
	{
		Database::connection()->delete()->from('settings')->where('setting', 'analytics')->exec();
	}

	public static function init()
	{
		Router::add('/admin/plugins/analytics', 'Analytics::settings');
		FishHook::add('template:layouts/default/head', array('Plugin_analytics', 'head_script'));
	}
	
	public static function head_script()
	{
		$settings = settings('analytics');
		$settings = unserialize($settings);

		if(count($settings)) {
			echo '<script type="text/javascript" src="http://www.google-analytics.com/ga.js"></script>'.PHP_EOL;
			echo '		<script type="text/javascript">'.PHP_EOL;
			echo "			var _gaq = _gaq || [];".PHP_EOL;
			echo "			_gaq.push(['_setAccount', '{$settings['tracking_id']}']);".PHP_EOL;

			if(isset($settings['subdomains']) && isset($settings['domain']))
				echo "			_gaq.push(['_setDomainName', '{$settings['domain']}']);".PHP_EOL;

			if(isset($settings['multidomains']))
				echo "			_gaq.push(['_setAllowLinker', true]);".PHP_EOL;


			echo "			_gaq.push(['_trackPageview']);".PHP_EOL;
			echo '		</script>'.PHP_EOL;
		}
	}
}