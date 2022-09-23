<?php

namespace App\Models;

use CodeIgniter\Model;

class ForgotPassword extends Model
{
  protected $DBGroup          = 'default';
  protected $table            = 'reset_password';
  protected $primaryKey       = 'id';
  protected $useAutoIncrement = true;
  protected $insertID         = 0;
  protected $returnType       = 'array';
  protected $useSoftDeletes   = false;
  protected $protectFields    = true;
  protected $allowedFields    = ['email', 'otp_code', 'updated_at', 'created_at'];

  function getDataByOtp($otp)
  {
    return $this->db->table('reset_password')->getWhere(['otp_code' => $otp])->getRowArray();
  }

  function deleteDataByEmail($email)
  {
    $this->db->table("reset_password")->delete(['email' => $email]);
  }


    function isAlreadyRegisterByOtp($otp){
      return $this->db->table('reset_password')->getWhere(['otp_code'=>$otp])->getRowArray()>0?true:false;
    }

    function updateOtpByEmail($userdata, $email){
      $this->db->table("reset_password")->where(['email'=>$email])->update($userdata);
    }

}
