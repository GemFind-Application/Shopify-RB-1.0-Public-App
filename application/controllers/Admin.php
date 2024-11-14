<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//ini_set('display_errors', 1);
class Admin extends CI_Controller {
	
	function __construct()
	{  	
		parent::__construct();
		$this->load->library('diamond_lib');
		$this->load->model('admin_model');
		$this->load->library('pagination');
		
	}
	/*
	* Admin Dashboard
	*/
	public function index()
	{	
		if(!$this->session->userdata("login"))
		{
			redirect(base_url().'admin/login');
		}
		$data["coupons"] = $this->admin_model->get_total_coupons();
		$data["stores"] = $this->admin_model->get_total_stores();
		$this->load->view('admin/header');
		$this->load->view('admin/settings/dashboard',$data);
		$this->load->view('admin/footer');
	}
	/*
	* Admin Login
	*/
	public function login()
	{	
		if($this->input->post('login'))
		{
			$user_name = $this->input->post('user_name');
			$password = $this->input->post('pass');
			$password = md5($password);
			
			// check for user credentials
            $uresult = $this->admin_model->get_user($user_name, $password);
            if (count($uresult) > 0)
            {
				$user = $uresult[0]->id;
                // set session
                $sess_data = array('login' => TRUE, 'username' => $uresult[0]->username, 'uid' => $uresult[0]->id);
                $this->session->set_userdata($sess_data);
				$this->session->set_flashdata('success','Login successfully!!');
                redirect("admin");
            }
            else
            {
                $this->session->set_flashdata('fail','Wrong Username or Password!');
                redirect(base_url().'admin/login');
            }
		}
			$this->load->view('admin/login',$data);
	}
	/*
	* Admin Logout
	*/
	function logout()
	{
	    // destroy session
		$data = array('login' => '', 'uname' => '', 'uid' => '');
		$this->session->unset_userdata($data);
		$this->session->sess_destroy();
	    redirect(base_url().'admin/login');
	}
	/*
	* Admin add coupon
	*/
	public function addcoupon()
	{	
		if(isset($_REQUEST["add_coupon"]))
		{
			$shop = $this->input->post("shop");
			$resultShopExists = $this->admin_model->getCoupanByShop($shop);			
			if(count($resultShopExists) > 0){
				$this->session->set_flashdata('fail',"Coupon is already exists for shop <b>".$shop."</b>.You can't create more than one coupon for the same shop.");
			}
			else
			{
				$discount_code = $this->input->post("discount_code");
				$discount_value = $this->input->post("discount_value");
				$discount_type = $this->input->post("discount_type");
				$data = array(
					'shop' => $shop,
					'discount_code' => $discount_code,
					'discount_value' => $discount_value,
					'discount_type' => $discount_type
				);
				$this->admin_model->insert($data);
				$this->session->set_flashdata('success','Coupon has been added successfully!!');
			}
			redirect(base_url()."admin/coupons");
		}
		$data["shop_details"] = $this->admin_model->getShops();
		$data["shop_coupans"] = $this->admin_model->get_coupons();
		$this->load->view('admin/header');
		$this->load->view('admin/settings/add_coupon', $data);
		$this->load->view('admin/footer');
	}
	/*
	* Admin update coupon
	*/
	public function updatecoupon()
	{	
		$coupon_id = $this->uri->segment(3);
		if(isset($_REQUEST["update_coupon"]))
		{
			$coupon_id = $this->input->post("coupon_id");
			$shop = $this->input->post("shop");
			$discount_code = $this->input->post("discount_code");
			$discount_value = $this->input->post("discount_value");
			$discount_type = $this->input->post("discount_type");
			$data = array(
				'shop' => $shop,
				'discount_code' => $discount_code,
				'discount_value' => $discount_value,
				'discount_type' => $discount_type
			);
			/*echo "<pre>".$coupon_id;
			print_r($data);*/
			$this->admin_model->update($data,$coupon_id);
			$this->session->set_flashdata('success','Coupon has been updated successfully!!');
			//redirect(base_url()."admin/coupons");
		}
		$data["coupon"] = $this->admin_model->getCoupansByID($coupon_id);
		$data["shop_details"] = $this->admin_model->getShops();
		$this->load->view('admin/header');
		$this->load->view('admin/settings/edit_coupon', $data);
		$this->load->view('admin/footer');
	}
	public function coupons()
	{
		$data["coupons"] = $this->admin_model->get_coupons();
		$this->load->view('admin/header');
		$this->load->view('admin/settings/coupons', $data);
		$this->load->view('admin/footer');
	}

	public function add_student_view(){
		$this->load->helper('form');
		$this->load->view('Stud_add');
	}

	public function delete_coupon(){
		$coupon_id = $this->uri->segment(3);
		$coupon_id = $this->input->post("couponid");
		$this->admin_model->delete($coupon_id);
		$this->session->set_flashdata('success','Coupon delete successfully!!');
		redirect(base_url()."admin/coupons");
	}
	
	public function calculate_discount()
	{
		 $coupan_code = $_REQUEST["coupan_code"];
		 $shop = $_REQUEST["shop"];

		 $discountcoupan = $this->admin_model->getDiscountCoupan($shop,$coupan_code);
		 
		 if(!empty($discountcoupan))
		 {
			 $app_total_charge = $_REQUEST["app_total_charge"];
			 $discount_code = $discountcoupan[0]->discount_code;
			 $discount_value = $discountcoupan[0]->discount_value;
			 $discount_type = $discountcoupan[0]->discount_type;
			 if($discount_type == "Percentage")
			 {
				 $discounted_total = $app_total_charge - ($app_total_charge * ($discount_value/100)); 
				 $discount_minus = $app_total_charge - $discounted_total;
			 }
			 else
			 {
				$discounted_total = $app_total_charge - $discount_value; 
				$discount_minus = $discount_value;				
			 }
			 echo json_encode(array("app_total_charge" => $app_total_charge,"discount_code" => $discount_code,"discount_value" => $discount_value,"discounted_total" => $discounted_total,"discount_type" => $discount_type,"discount_minus" => $discount_minus,"status" => 1));
		 }
		 else
		 {
			 echo json_encode(array("app_total_charge" => $app_total_charge,"discount_type" => $discount_type,"discount_code" => $discount_code,"discount_value" => $discount_value,"discount_minus" => $discount_minus,"status" => 0));
		 }
	}
}