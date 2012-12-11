<?php
namespace analytics\controllers;

use traq\controllers\admin\AppController;
use avalon\http\Request;
use avalon\output\View;
use avalon\Database;

class Analytics extends AppController
{
	public function action_settings()
	{
		if (Request::method() == 'post') {
			$settings = Request::$post['settings'];
			$settings = serialize($settings);

			Database::connection()->update('settings')->set(array('value' => $settings))->where('setting', 'analytics')->exec();
			Request::redirect('/admin/plugins');
		}

		$settings = settings('analytics');
		$settings = unserialize($settings);

		if(!isset($settings['multidomains']))
			$settings['multidomains'] = 0;

		if(!isset($settings['subdomains']))
			$settings['subdomains'] = 0;

		View::set('settings', $settings);
	}
};
?>