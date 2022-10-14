<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\ForgotPassword;
use App\Models\Users;
use CodeIgniter\API\ResponseTrait;

class ForgotPasswordController extends ResourceController {
    
    use ResponseTrait;

    private $resetModel=NULL;
	private $loginModel=NULL;


	function __construct(){
		$this->resetModel = new ForgotPassword();
		$this->loginModel = new Users();
	}

	public function forgotPassword() {
		$rules = ["email" => "required|valid_email",];

		$messages = [
			"email" => [
				"required" => "{field} tidak boleh kosong",
				'valid_email' => 'Format email tidak sesuai'
			],
		];
		if (!$this->validate($rules, $messages)) return $this->fail($this->validator->getErrors());

		$email = $this->request->getVar('email');
		if($this->loginModel->where("email",$email)->first()){

			$otp = rand(100000,999999);
			if ($this->resetModel->where("email", $email)->first()){
				$userdata = ['otp_code' => $otp];
				$this->resetModel->updateOtpByEmail($userdata, $email);
			} else {
				$this->resetModel->insert([
					'email' => $email,
					'otp_code' => $otp,
				]);
			}
			$this->sendOtpEmail($email, $otp);
			$response = [
				'status' => 200,
				'success' => 200,
				'message' => 'Kode OTP berlaku selama 15 menit, silakan cek email Anda'
			];
			return $this->respond($response);
		} else {
			return $this->fail('Email Tidak Terdaftar');
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
			"email" => "required|valid_email",
			"otp" => "required|numeric|min_length[6]|max_length[6]"
		];

		$messages = [
			"email" => [ 
				"required" => "{field} tidak boleh kosong",
                'valid_email' => 'Format email tidak sesuai'
			],
			"otp" => [
				"required" => "{field} tidak boleh kosong",
				"numeric" => "{field} harus berisi nomor",
				'min_length' => '{field} minimal 6 karakter',
                'max_length' => '{field} maksimal 6 karakter'
			]
		];
		if (!$this->validate($rules, $messages)) return $this->fail($this->validator->getErrors());
		
		$verifyEmail = $this->resetModel->where("email", $this->request->getVar('email'))->first();
        if(!$verifyEmail) return $this->failNotFound('Email tidak ditemukan');
		
		$now = date("Y-m-d H:i:s");
		$exp = date('Y-m-d H:i:s', strtotime('+15 minutes', strtotime($verifyEmail['created_at'])));

        if($this->request->getVar('otp') != $verifyEmail['otp_code']) {
            return $this->fail('Kode OTP salah');
		} else if ($now > $exp) {
			return $this->fail('OTP sudah kadaluwarsa');
		} else {
			$response = [
				'status' => 200,
				'success' => 200,
				'message' => 'OTP diverifikasi, silakan setel ulang kata sandi Anda'
			];
			return $this->respond($response);
		}
	}

	public function newPassword() {
		$rules = [
			"password" => "required|min_length[8]|max_length[50]",
			"password_confirm" => "required|matches[password]",
			"email" => "required|valid_email",
		];
	
		$messages = [
			"password" => [
				'required' => '{field} tidak boleh kosong',
				'min_length' => '{field} minimal 8 karakter',
				'max_length' => '{field} maksimal 50 karakter',
			],
			"password_confirm" => [
				'required' => '{field} tidak boleh kosong',
				'matches' => 'Konfirmasi kata sandi tidak cocok dengan kata sandi'
			],
			"email" => [
				'required' => '{field} tidak boleh kosong',
				'valid_email' => 'Format email tidak sesuai'
			],
		];
		if (!$this->validate($rules, $messages)) return $this->fail($this->validator->getErrors());

		$email = $this->request->getVar('email');

		$verifyEmail = $this->loginModel->where("email",$email)->first();
        if(!$verifyEmail) return $this->failNotFound('Email tidak ditemukan');

		$userdata = [
			'password' => password_hash($this->request->getVar('password'), PASSWORD_BCRYPT),
		];

		$this->loginModel->updateUserByEmail($userdata, $email);
		$this->resetModel->deleteDataByEmail($email);

		$response = [
			'status' => 200,
			'success' => 200,
			'message' => 'Kata sandi telah diatur ulang, silakan masuk dengan kata sandi baru'
		];
		return $this->respond($response);
	}
}
