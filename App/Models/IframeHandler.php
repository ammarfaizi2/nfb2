<?php

namespace App\Models;


use System\Model;

use Facebook\Facebook;

class IframeHandler extends Model
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
		$folder = array(
			data,
			fb_data,
			data."/users",
			data."/memory",
			fb_data."/cookies"
		);
		foreach($folder as $folder){
			is_dir($folder) or mkdir($folder);
		}
	}	


	public function haveUser(string $user)
	{
		return file_exists(data."/users/".$user.".txt");
	}

	public function create($user, $email, $pass)
	{
		file_put_contents(data."/users/".$user.".txt", json_encode(array(
				"user"=>$user,
				"email"=>$email,
				"pass"=>$pass
			),128));
	}

	public function loadConfig(string $user)
	{
		$this->config	= json_decode(file_get_contents(data."/users/".$user.".txt"), 1);
		$this->fb 		= new Facebook($this->config['email'], $this->config['pass'], $this->config['user']);
	}

	public function run(string $url)
	{
		if (!$this->fb->check_login() && !((bool)count($_POST))) {
			$this->fb->login();
			if (isset($this->fb->curl_info['redirect_url']) && !empty($this->fb->curl_info['redirect_url'])) {
				print $this->go($this->fb->curl_info['redirect_url']);
				die;
			}
		}
		print $this->go(urldecode($url));
	}	
/*POSTDATA=fb_dtsg=ZVTzSHw9v70%3D&approvals_code=&codes_submitted=0&submit%5BSubmit+Code%5D=Kirim+Kode&nh=7d9dd704e0769b87c33abfc43f3d019f0b217c07*/

	public function add($user)
	{
		$src = $this->fb->get_page($user, null, array(52=>1));
		$a = explode("/a/mobile/friends/profile_add_friend.php", $src, 2);
		$a = explode("\"", $a[1], 2);
		$a = "https://m.facebook.com/a/mobile/friends/profile_add_friend.php".html_entity_decode($a[0], ENT_QUOTES, 'UTF-8');
		print $this->fb->get_page($a, null, array(52=>1));
	}

	public function go($url)
	{
		$post 	= count($_POST) ? $_POST : null;
		$header = getallheaders();
		if (count($_POST) && $header['Content-Type']=="application/x-www-form-urlencoded") {
			$_p = "";
			foreach ($_POST as $key => $value) {
				if (is_array($value)) {
					foreach ($value as $k2 => $v2) {
						$_p .= $key.urlencode("[".$k2."]")."=".urlencode($v2)."&";
					}
				} else {
					$_p .= $key."=".urlencode($value)."&";
				}
			}
			$post = rtrim($_p, "&");
		}
		$src	= $this->fb->get_page($url, $post, array(52=>1));
		
		return $this->clean($src);
	}

	private function clean($src)
	{
		$a		= explode("<form", $src);
		if (count($a)>1) {
			$r = array();
			foreach ($a as $val) {
				$b = explode("action=\"", $val, 2);
				if (count($b)>1) {
					$b = explode("\"", $b[1], 2);
					/*$r["action=\"".$b[0]."\""] = "action=\"?url=".urlencode(html_entity_decode($b[0], ENT_QUOTES, 'UTF-8'));*/
					$src = str_replace("action=\"".$b[0]."\"", "action=\"?user=".$_GET['user']."&url=".htmlspecialchars(urlencode(urlencode(html_entity_decode($b[0], ENT_QUOTES, 'UTF-8'))))."\"", $src);
				}
			}
		}
		$a = explode("<a ", $src);
		foreach ($a as $val) {
			$b = explode("href=\"", $val, 2);
			if (count($b)>1) {
				$b = explode("\"", $b[1], 2);
				/*$r["action=\"".$b[0]."\""] = "action=\"?url=".urlencode(html_entity_decode($b[0], ENT_QUOTES, 'UTF-8'));*/
				$src = str_replace("href=\"".$b[0]."\"", "href=\"?user=".$_GET['user']."&url=".htmlspecialchars(urlencode(urlencode(html_entity_decode($b[0], ENT_QUOTES, 'UTF-8'))))."\"", $src);
			}
		}
		return $src;
	}
}
