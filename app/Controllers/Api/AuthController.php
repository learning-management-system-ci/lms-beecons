<?php

namespace App\Controllers\Api;

//use App\Controllers\BaseController;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\UsersModel;
use App\Models\ResetPasswordModel;
use Firebase\JWT\JWT;
use DateTime;
use DateInterval;

class AuthController extends ResourceController {
    
    private $loginModel=NULL;
	private $resetModel=NULL;
	private $googleClient=NULL;
	protected $session;

	function __construct(){
    	$this->session = \Config\Services::session();
    	$this->session->start();

		require_once APPPATH. "../vendor/autoload.php";
		$this->loginModel = new UsersModel();
		$this->resetModel = new ResetPasswordModel();
		$this->googleClient = new \Google_Client();
		$this->googleClient->setClientId("229684572752-p2d3d602o4jegkurrba5k2humu61k8cv.apps.googleusercontent.com");
		$this->googleClient->setClientSecret("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");
		$this->googleClient->setRedirectUri("http://localhost:8080/login/loginWithGoogle");
		$this->googleClient->addScope("email");
		$this->googleClient->addScope("profile");
	}

	public function register() {
        $rules = [
			"email" => "required|is_unique[users.email]|valid_email",
			"password" => "required|min_length[4]|max_length[50]",
            "password_confirm" => "matches[password]",
		];

        $messages = [
			"email" => [
                'required' => '{field} required',
                'is_unique' => 'Email already used',
                'valid_email' => 'Email format is not valid'
			],
            "password" => [
                'required' => '{field} required',
                'min_length' => '{field} minimum 4 characters',
                'max_length' => '{field} maximum 50 characters'
            ],
            "password_confirm" => [
                'matches' => 'Confirm password does not match with the password'
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
				'error' => true,
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
				'error' => false,
				'message' => 'User created, please check your email for activation',
				'data' => []
			];
        }
        return $this->respondCreated($response);
        
      }

    function sendActivationEmail($emailTo, $token) { 
		//$to = $this->request->getVar('mailTo');
		$subject = 'subject';
		$message = base_url()."/activateuser?token=".$token;
			
		$email = \Config\Services::email();
		$email->setTo($emailTo);
		$email->setFrom('hendrikusozzie@gmail.com', 'Confirm Registration');
			
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
	    session()->setFlashdata('error', 'Your account has been successfully activated, please login');
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
				"required" => "{field} is required",
                'valid_email' => 'Email format is not valid'
			],
            "password" => [
                "required" => "{field} required"
            ],
		];
        if (!$this->validate($rules, $messages)) return $this->fail($this->validator->getErrors());

        $verifyEmail = $this->loginModel->where("email", $this->request->getVar('email'))->first();
        if(!$verifyEmail) return $this->failNotFound('Email not found');

        $verifyPass = password_verify($this->request->getVar('password'), $verifyEmail['password']);
        if(!$verifyPass) {
            return $this->fail('Wrong password');
        } else if ($verifyEmail['activation_status']!=1) {
            return $this->fail('User is not activated');
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
            'error' => false,
            'data' => [$token]
        ];
        return $this->respond($token);
    }
}
 