<?php
namespace traq\plugins;

use avalon\http\Router;
use avalon\Autoloader;
use avalon\Database;

use FishHook;
use HTML;

/**
 * Google Analytics Plugin.
 *
 * @package Traq
 * @subpackage Plugins
 * @author arturo182
 * @copyright (c) arturo182
 */
class Analytics extends \traq\libraries\Plugin
{
	public static function info()
	{
		return array(
			'name' => HTML::link('Google Analytics', '/admin/plugins/analytics'),
			'version' => '0.1',
			'author' => 'arturo182'
		);
	}
	
	public static function init()
	{
		Autoloader::registerNamespace('analytics', __DIR__);
	
		Router::add('/admin/plugins/analytics', 'analytics::controllers::Analytics.settings');
		
		FishHook::add('template:layouts/default/head', function()
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
		});
	}

	public static function __install()
	{
		Database::connection()->insert(array('setting' => 'analytics'))->into('settings')->exec();
	}

	public static function __uninstall()
	{
		Database::connection()->delete()->from('settings')->where('setting', 'analytics')->exec();
	}

}