<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App extends CI_Controller {

	public function install()
	{
		if($this->input->post('SubmitInstallApp') == "Submit")
	    {
	    	$app_url  = $this->input->post('app_url');
	    	$redirect_install_url = base_url()."/install?shop=".$app_url;
	    	redirect($redirect_install_url);
	    }
		$this->load->view('install_app');
	}
}
