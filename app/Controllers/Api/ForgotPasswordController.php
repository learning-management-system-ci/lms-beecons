<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\ForgotPasswordModel;
use App\Models\UsersModel;
use CodeIgniter\API\ResponseTrait;

class ForgotPasswordController extends ResourceController {
    
    use ResponseTrait;
    private $resetModel=NULL;
	private $loginModel=NULL;


	function __construct(){
		$this->resetModel = new ForgotPasswordModel();
		$this->loginModel = new UsersModel();
	}

	public function forgotPassword() {
		$rules = ["email" => "required|valid_email",];

		$messages = [
			"email" => [
				"required" => "{field} is required",
				'valid_email' => 'Email format is not valid'
			],
		];
		if (!$this->validate($rules, $messages)) return $this->fail($this->validator->getErrors());

		$email = $this->request->getVar('email');
		if($this->loginModel->where("email",$email)->first()){
			$otp = rand(100000,999999);
			$this->resetModel->insert([
				'email' => $email,
				'otp_code' => $otp,
			]);
			$this->sendOtpEmail($email, $otp);
			$response = [
				'status' => 200,
				'error' => false,
				'message' => 'The OTP code is valid for 15 minutes, please check your email'
			];
			return $this->respond($response);
		} else {
			return $this->fail('Email Not Registered');
		}
	}

	function sendOtpEmail($emailTo, $otp) { 
		$subject = 'subject';
		$message = $otp;
		  
		$email = \Config\Services::email();
		$email->setTo($emailTo);
		$email->setFrom('hendrikusozzie@gmail.com', 'OTP Reset Password');
		  
		$email->setSubject($subject);
		$email->setMessage($message);
  
		$email->send();
	}

	public function sendOtp() {
		$rules = [
			"otp" => "required|numeric|min_length[6]|max_length[6]"
		];

		$messages = [
			"otp" => [
				"required" => "{field} is required",
				"numeric" => "{field} must be number",
				'min_length' => '{field} minimum 6 characters',
                'max_length' => '{field} maximum 6 characters'
			],
		];
		if (!$this->validate($rules, $messages)) return $this->fail($this->validator->getErrors());

		$otp = $this->request->getVar('otp');
		$data = $this->resetModel->getDataByOtp($otp);
		//$minutes_to_add = 15;

		$now = date("Y-m-d H:i:s");

		if ($this->resetModel->isAlreadyRegisterByOtp($otp)) {
			$exp = date('Y-m-d H:i:s', strtotime('+15 minutes', strtotime($data['created_at'])));
			if($now > $exp) {
				return $this->fail('OTP expired');
			} else {
				$response = [
					'status' => 200,
					'error' => false,
					'message' => 'OTP verified, please reset your password'
				];
				return $this->respond($response);
			}
		} else {
			return $this->failNotFound('OTP not available');
		}
	}

	public function newPassword() {
		$rules = [
			"password" => "required|min_length[4]|max_length[50]",
			"password_confirm" => "required|matches[password]",
			"email" => "required|valid_email",
		];
	
		$messages = [
			"password" => [
				'required' => '{field} required',
				'min_length' => '{field} minimum 4 characters',
				'max_length' => '{field} maximum 50 characters',
			],
			"password_confirm" => [
				'required' => '{field} required',
				'matches' => 'Confirm password does not match with the password'
			],
			"email" => [
				'required' => '{field} required',
				'valid_email' => 'Email format is not valid'
			],
		];
		if (!$this->validate($rules, $messages)) return $this->fail($this->validator->getErrors());

		$email = $this->request->getVar('email');

		$verifyEmail = $this->loginModel->where("email",$email)->first();
        if(!$verifyEmail) return $this->failNotFound('Email not found');

		$userdata = [
			'password' => password_hash($this->request->getVar('password'), PASSWORD_BCRYPT),
		];

		$this->loginModel->updateUserByEmail($userdata, $email);
		$this->resetModel->deleteDataByEmail($email);

		$response = [
			'status' => 200,
			'error' => false,
			'message' => 'Password has been reset, please login with new password'
		];
		return $this->respond($response);
	}
}
