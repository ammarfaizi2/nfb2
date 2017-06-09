<?php

namespace App\Controllers;


use System\Controller;
use App\Models\IframeHandler;

class newuser extends Controller
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
	}

	/**
	 *
	 * Default method.
	 *
	 */
	public function index()
	{
		$this->load->view("login");
	}

	public function create_new_user()
	{
		$iframe = new IframeHandler();
		if ($iframe->haveUser($this->input->post("username"))) {
			die("user sudah ada !");
		} else {
			$iframe->create("".$this->input->post("username"),"".$this->input->post("email"),"".$this->input->post("password"));
			header("location:".router_url()."/iframe/?user=".$this->input->post("username"));
		}
	}
}