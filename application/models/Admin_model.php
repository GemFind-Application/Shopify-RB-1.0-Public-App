<?php
class Admin_model extends CI_Model {    
    public function getShops()
	{
        $this->db->select('*');
		$this->db->order_by("shop", "ASC");
        $resultConfig = $this->db->get('customer')->result();
		return $resultConfig;
	}
	public function get_user($username, $password)
	{
		$this->db->select('*');
		$this->db->where("username",$username);
		$this->db->where("password",$password);
		$resultConfig = $this->db->get("admin")->result();
		return $resultConfig;
	}	
	public function get_coupons(){
		$this->db->order_by("id", "DESC");
		$resultCoupans = $this->db->get("coupon")->result();
		return $resultCoupans;
	}
	public function insert($data) {
        if($this->db->insert("coupon", $data)){
            return true;
        }
    }
    public function delete($id){
        $this->db->where('id', $id);
		if($this->db->delete("coupon")){
            return true;
        }
    }
    public function update($data,$id){
        $this->db->set($data);
        $this->db->where("id", $id);
        $this->db->update("coupon", $data);
    }
	public function getCoupansByID($id)
	{
		$this->db->select('*');
		$this->db->where("id",$id);
		$resultCoupan = $this->db->get("coupon")->result();
		return $resultCoupan;
	}
	public function get_total_coupons()
	{
		$query = $this->db->get('coupon');
		return $query->num_rows();
	}
	public function get_total_stores()
	{
		$this->db->distinct();
		$query = $this->db->get('customer');
		return $query->num_rows();
	}
	public function getDiscountCoupan($shop,$coupan_code)
	{
		$this->db->select('*');
		$this->db->where("shop",$shop);
		$this->db->where("discount_code",$coupan_code);
		$resultCoupan = $this->db->get("coupon")->result();
		//echo $this->db->last_query();
		return $resultCoupan;
	}
	public function getCoupanByShop($shop)
	{
		$this->db->select('*');
		$this->db->where("shop",$shop);
		$resultCoupan = $this->db->get("coupon")->result();
		//echo $this->db->last_query();
		return $resultCoupan;
	}
}
?>