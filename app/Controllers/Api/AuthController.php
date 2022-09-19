<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\Users;
use Firebase\JWT\JWT;
use DateTime;
use DateInterval;

class AuthController extends ResourceController {
    
    private $loginModel=NULL;
	private $googleClient=NULL;
	protected $session;

	function __construct(){
    	$this->session = \Config\Services::session();
    	$this->session->start();

		require_once APPPATH. "../vendor/autoload.php";
		$this->loginModel = new Users();
		$this->googleClient = new \Google_Client();
		$this->googleClient->setClientId("229684572752-p2d3d602o4jegkurrba5k2humu61k8cv.apps.googleusercontent.com");
		$this->googleClient->setClientSecret("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");
		$this->googleClient->setRedirectUri("http://localhost:8080/login/loginWithGoogle");
		$this->googleClient->addScope("email");
		$this->googleClient->addScope("profile");
	}

    public function loginWithGoogle() {
		$token = $this->googleClient->fetchAccessTokenWithAuthCode($this->request->getVar('code'));
		if(!isset($token['error'])){
			$this->googleClient->setAccessToken($token['access_token']);
			session()->set("AccessToken", $token['access_token']);

			$googleService = new \Google\Service\Oauth2($this->googleClient);
			$data = $googleService->userinfo->get();
			$currentDateTime = date("Y-m-d H:i:s");
			// echo "<pre>"; print_r($data);die;
			$userdata=array();
			if($this->loginModel->isAlreadyRegister($data['id']) || $this->loginModel->isAlreadyRegisterByEmail($data['email'])){
			// if($this->loginModel->isAlreadyRegister($data['id'])){
				$userdata = [
					'oauth_id'=>$data['id'],
					'email'=>$data['email'], 
					'updated_at'=>$currentDateTime,
					'activation_status'=>'1'
				];
				$email = $data['email'];
				$this->loginModel->updateUserData($userdata, $email);
			}else{
				$userdata = [
					'oauth_id'=>$data['id'],
					'email'=>$data['email'], 
					'created_at'=>$currentDateTime,
					'activation_status'=>'1',
					'role'=>'participant'
				];
				$this->loginModel->save($userdata);
			}
      $key = getenv('TOKEN_SECRET');
      $payload = [
				'iat'   => 1356999524,
				'nbf'   => 1357000000,
				"exp" => time() + (60 * 60),
				'uid'   => $data['id'],
				'email' => $data['email'],
      ];
      $token = JWT::encode($payload, $key, 'HS256');

		}else{
      $response = [
				'status' => 500,
				'error' => true,
				'message' => 'Something went Wrong',
				'data' => []
			];
			// session()->setFlashData("error", "Something went Wrong");
			$this->respondCreated($response);
			return redirect()->to(base_url("/login/loginWithGoogle/submit"));
		}
		$response = [
			'status' => 200,
			'error' => false,
			'data' => [$token]
		];
		// session()->setFlashData("success", "Login Successful");
		$this->respondCreated($response);
		return redirect()->to(base_url()."/login/loginWithGoogle/submit");
	}

	public function register() {
        $rules = [
			"email" => "required|is_unique[users.email]|valid_email",
			"password" => "required|min_length[4]|max_length[50]",
            "password_confirm" => "matches[password]",
		];

        $messages = [
			"email" => [
                'required' => '{field} tidak boleh kosong',
                'is_unique' => 'Email telah digunakan',
                'valid_email' => 'Format email tidak sesuai'
			],
            "password" => [
                'required' => '{field} tidak boleh kosong',
                'min_length' => '{field} minimal 4 karakter',
                'max_length' => '{field} maksimal 50 karakter'
            ],
            "password_confirm" => [
                'matches' => 'Konfirmasi kata sandi tidak cocok dengan kata sandi'
            ],
		];
    
        $key = getenv('TOKEN_SECRET');
        $payload = array(
            "iat" => 1356999524,
            "nbf" => 1357000000,
            "exp" => time() + (60 * 60),
            "email" => $this->request->getVar('email')
        );
        $token = JWT::encode($payload, $key);
    
        if (!$this->validate($rules, $messages)) {

			$response = [
				'status' => 500,
				'error' => 500,
				'message' => $this->validator->getErrors(),
				'data' => []
			];
		} else {
            $data['email'] = $this->request->getVar("email");
			$data['role'] = 'participant';
            $data['password'] = password_hash($this->request->getVar('password'), PASSWORD_BCRYPT);
            $data['activation_code'] = $token;
            
            $this->loginModel->save($data);
            $this->sendActivationEmail($this->request->getVar('email'), $token);

			$response = [
				'status' => 200,
				'success' => 200,
				'message' => 'Akun berhasil dibuat, silakan periksa email Anda untuk aktivasi',
				'data' => []
			];
        }
        return $this->respondCreated($response);
        
      }

    function sendActivationEmail($emailTo, $token) { 
		//$to = $this->request->getVar('mailTo');
		$subject = 'subject';
		$message = base_url()."/api/activateuser?token=".$token;
			
		$email = \Config\Services::email();
		$email->setTo($emailTo);
		$email->setFrom('hendrikusozzie@gmail.com', 'Konfirmasi Pendaftaran');
			
		$email->setSubject($subject);
		$email->setMessage($message);
		$email->send();
  	}

    public function activateUser() {
	    $token = $this->request->getVar('token');
	    //echo $token;
	    $key = getenv('TOKEN_SECRET');
        try {
            $decoded = JWT::decode($token, $key, array('HS256'));
        }catch(Exception $e){
            echo 'Caught exception: ',  $e->getMessage(), "\n";
            return ;
        }
        $this->loginModel->updateUserByEmail([
            'activation_status' => 1,
			'activation_code' => ''
        ], $decoded->email);
	    session()->setFlashdata('error', 'Akun Anda telah berhasil diaktifkan, silahkan login');
	    return redirect()->to(base_url()."/login");
	}

    public function indexLogin() {
        $data = [
            "title" => "Sign In",
            "googleButton" => '<a href="'.$this->googleClient->createAuthUrl().'"><img src="image/google.png" alt=""></a>',
        ];
        return view('pages/authentication/login', $data);
    }

    public function login() {
        $rules = [
			"email" => "required|valid_email",
			"password" => "required",
		];

        $messages = [
			"email" => [
				"required" => "{field} tidak boleh kosong",
                'valid_email' => 'Format email tidak sesuai'
			],
            "password" => [
                "required" => "{field} tidak boleh kosong"
            ],
		];
        if (!$this->validate($rules, $messages)) return $this->fail($this->validator->getErrors());

        $verifyEmail = $this->loginModel->where("email", $this->request->getVar('email'))->first();
        if(!$verifyEmail) return $this->failNotFound('Email tidak ditemukan');

        $verifyPass = password_verify($this->request->getVar('password'), $verifyEmail['password']);
        if(!$verifyPass) {
            return $this->fail('Kata sandi salah');
        } else if ($verifyEmail['activation_status']!=1) {
            return $this->fail('Pengguna belum aktif');
        } else {

        }
        $key = getenv('TOKEN_SECRET');
        $payload = [
            'iat'   => 1356999524,
            'nbf'   => 1357000000,
            "exp" => time() + (60 * 60),
            'uid'   => $verifyEmail['id'],
            'email' => $verifyEmail['email'],
        ];
        $token = JWT::encode($payload, $key, 'HS256');

        $response = [
            'status' => 200,
            'success' => 200,
            'data' => [$token]
        ];
        return $this->respond($response);
    }
}
 