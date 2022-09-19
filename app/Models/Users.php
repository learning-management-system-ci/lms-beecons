<?php
namespace App\Models;
use CodeIgniter\Model;

class Users extends Model
{
	protected $table='users';
	protected $primaryKey = 'id';
	protected $DBGroup='default';
	protected $allowedFields = ['oauth_id', 'fullname', 'email', 'password', 'phone_number','activation_status', 'activation_code', 'updated_at', 'created_at'];

	function isAlreadyRegister($authid){
		return $this->db->table('users')->getWhere(['oauth_id'=>$authid])->getRowArray()>0?true:false;
	}
	function updateUserData($userdata, $authid){
		$this->db->table("users")->where(['oauth_id'=>$authid])->update($userdata);
	}
	function updateUserByEmail($userdata, $email){
		$this->db->table("users")->where(['email'=>$email])->update($userdata);
	}

}