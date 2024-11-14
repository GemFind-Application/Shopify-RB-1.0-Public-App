<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Install extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		header("Content-Security-Policy: frame-ancestors https://".$_GET['shop']." https://admin.shopify.com");
		
		$shop = $_GET['shop'];
		$api_key =  $this->config->item('api_key');
		$scopes =  $this->config->item('scopes');
		$redirect_uri = $this->config->item('redirect_uri');
		// Build install/approval URL to redirect to
		if($shop){
			$install_url = "https://" . $shop . "/admin/oauth/authorize?client_id=" . $api_key . "&scope=" . $scopes . "&redirect_uri=" . urlencode($redirect_uri);
			
			header("Location: " . $install_url);
			die();
		}else{
			echo "Invalid Shop parameter";
		}
	}
}
