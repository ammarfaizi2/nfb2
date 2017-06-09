<?php

namespace App\Controllers;


use System\Controller;

use App\Models\IframeHandler;
use App\Controllers\newuser;

class iframe extends Controller
{
	/**
	 *
	 * Constructor.
	 *
	 *
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 *
	 * Default method.
	 *
	 */
	public function index()
	{
		if (!isset($_GET['user'])) {
			$this->load->error(404);
		} else {
			$iframe = new IframeHandler();
			if ($iframe->haveUser($_GET['user'])) {
				$iframe->loadConfig($_GET['user']);
				if (isset($_GET['add'])) {
					$iframe->add($_GET['add']);
				} else {
					$iframe->run((isset($_GET['url']) ? $_GET['url'] : "https://m.facebook.com"));
				}
			} else {
				(new newuser)->index();
			}
		}
	}
	public function geturl()
	{
		isset($_GET['offset']) or die;
		$this->set->header("Content-type","application/json");
		$val = explode("\n", file_get_contents(data."/a.txt"));
		print json_encode(array($val[(int)$_GET['offset']]));
	}
}