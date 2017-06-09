<?php

namespace App\Controllers;


use System\Controller;


class index extends Controller
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
		$this->load->helper("url");
		$this->load->helper("assets");
	}

	/**
	 *
	 * Default method.
	 *
	 */
	public function index()
	{
		$this->load->view("actor");
	}
}