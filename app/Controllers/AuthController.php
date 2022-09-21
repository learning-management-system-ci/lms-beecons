<?php
namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\UsersModel;
use App\Models\ForgotPasswordModel;
use Firebase\JWT\JWT;
use DateTime;
use DateInterval;

class AuthController extends BaseController
{
	private $googleClient=NULL;
	protected $session;

	function __construct(){
    	$this->session = \Config\Services::session();
    	$this->session->start();
        helper("cookie");

		require_once APPPATH. "../vendor/autoload.php";
		$this->googleClient = new \Google_Client();
		$this->googleClient->setClientId("229684572752-p2d3d602o4jegkurrba5k2humu61k8cv.apps.googleusercontent.com");
		$this->googleClient->setClientSecret("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");
		$this->googleClient->setRedirectUri("http://localhost:8080/login/loginWithGoogle");
		$this->googleClient->addScope("email");
		$this->googleClient->addScope("profile");
	}

	public function indexLogin()
	{
		if(get_cookie("access_token")){
			session()->setFlashData("error", "You have Already Logged In");
			return redirect()->to(base_url()."/profile");
		}
		$data = [
            "title" => "Sign In",
            "googleButton" => '<a href="'.$this->googleClient->createAuthUrl().'"><img src="image/google.png" alt=""></a>',
        ];
		return view('pages/authentication/login', $data);
	}

	public function login() {
        echo $this->request->getBody();
        var_dump($this->request);
    if ($this->request->isAJAX()) {
        $requestBody = json_decode($this->request->getBody());
        $token = $requestBody->access_token;
        echo $token;
        $key = getenv('TOKEN_SECRET');
        try {
            $decoded = JWT::decode($token, $key, array('HS256'));
        }catch(Exception $e){
            echo 'Caught exception: ',  $e->getMessage(), "\n";
            return ;
        }
        
        if ($decoded) {
            if (!$decoded->email) {
                    session()->setFlashdata('error', 'User is not activated');
                    return redirect()->back();
                } else {
                    session()->set([
                        'email' => $decoded->email,
                        'LoggedUserData' => TRUE
                    ]);
                }
                session()->setFlashData("success", "Login Successful");
                return redirect()->to(base_url()."/profile");
        } else {
            session()->setFlashdata('error', 'Wrong email & password');
            return redirect()->back();
        }
    }
  }
  
	public function loginWithGoogle()
	{
        echo "Masokkkkk";
		// $token = $this->googleClient->fetchAccessTokenWithAuthCode($this->request->getVar('code'));
		// if(!isset($token['error'])){
		// 	$this->googleClient->setAccessToken($token['access_token']);
		// 	session()->set("AccessToken", $token['access_token']);
		// 	$googleService = new \Google\Service\Oauth2($this->googleClient);
		// 	$data = $googleService->userinfo->get();
		// 	$currentDateTime = date("Y-m-d H:i:s");
		// 	// echo "<pre>"; print_r($data);die;
		// 	$userdata=array();
		// 	if($this->loginModel->isAlreadyRegister($data['id']) || $this->loginModel->isAlreadyRegisterByEmail($data['email'])){
		// 	// if($this->loginModel->isAlreadyRegister($data['id'])){
		// 		$userdata = [
		// 			'oauth_id'=>$data['id'],
		// 			'email'=>$data['email'], 
		// 			'updated_at'=>$currentDateTime,
		// 			'activation_status'=>'1'
		// 		];
		// 		$email = $data['email'];
		// 		$this->loginModel->updateUserData($userdata, $email);
		// 	}else{
		// 		$userdata = [
		// 			'oauth_id'=>$data['id'],
		// 			'email'=>$data['email'], 
		// 			'created_at'=>$currentDateTime,
		// 			'activation_status'=>'1',
		// 			'role'=>'participant'
		// 		];
		// 		$this->loginModel->insertUserData($userdata);
		// 	}
		// 	// session()->set("LoggedUserData", $userdata);
		// 	session()->set([
		// 		'oauth_id'=>$data['id'],
		// 		'email'=>$data['email'],
		// 		'role' => "participant",
		// 		'LoggedUserData' => TRUE
		// 	]);

		// }else{
		// 	session()->setFlashData("error", "Something went Wrong");
		// 	return redirect()->to(base_url());
		// }
		// session()->setFlashData("success", "Login Successful");
		return redirect()->to(base_url()."/profile");
	}

	public function profile() {
		if(!get_cookie("access_token")){
			session()->setFlashData("error", "You have Logged Out, Please Login Again.");
			return redirect()->to(base_url());
		}
        $data = [
            "title" => session()->get("email"),
            "profile" => "",
            "cardButton" => 'Join The Webinar',
          ];
		return view('pages/navigation/profile', $data);
	}

	function logout() {
		session()->destroy();
		// session()->remove('LoggedUserData');
		// session()->remove('AccessToken');
		// if(!(session()->get('LoggedUserData') && session()->get('AccessToken') )){
		// 	session()->setFlashData("success", "Logout Successful");
		// 	return redirect()->to(base_url());
		// }else{
		// 	session()->setFlashData("error", "Failed to Logout, Please Try Again");
		// 	return redirect()->to(base_url()."/profile");
		// }
		return redirect()->to(base_url());
	}

	public function indexRegister() {
		$data = [
            "title" => "Sign Up",
            "googleButton" => '<a href="'.$this->googleClient->createAuthUrl().'"><img src="image/google.png" alt=""></a>',
        ];
		return view('pages/authentication/register', $data);
	}

	public function register() {
    // if (!$this->validate([
    //   'email' => [
    //     'rules' => 'required|is_unique[users.email]',
    //     'errors' => [
    //       'required' => '{field} required',
    //       'is_unique' => 'Email already used'
    //     ]
    //   ],
    //   'password' => [
    //     'rules' => 'required|min_length[4]|max_length[50]',
    //     'errors' => [
    //       'required' => '{field} required',
    //       'min_length' => '{field} minimum 4 characters',
    //       'max_length' => '{field} maximum 50 characters',
    //     ]
    //   ],
    //   'password_confirm' => [
    //     'rules' => 'matches[password]',
    //     'errors' => [
    //       'matches' => 'Confirm password does not match with the password',
    //     ]
    //   ],
    // ])) {
    //   session()->setFlashdata('error', $this->validator->listErrors());
	//     return redirect()->back()->withInput();
    // }
    if ($this->request->isAJAX()) {
        return redirect()->to(base_url().'/login');
    }
    return redirect()->to(base_url().'/login');
  }

	public function indexforgotPassword() {
		$data = [
      "title" => "Reset Password",
    ];
		return view('pages/authentication/forgot_password', $data);
	}

	public function forgotPassword() {
		$email = $this->request->getVar('email');
		session()->set([
			'email' => $email,
		]);
		if($this->loginModel->isAlreadyRegisterByEmail($email)){
			$otp = rand(100000,999999);
			$this->resetModel->insert([
				'email' => $email,
				'otp_code' => $otp,
			]);

			$this->sendOtpEmail($email, $otp);
			session()->setFlashdata('error', 'The OTP code is valid for 15 minutes, please check your email');
			return redirect()->to('/send-otp');
		} else {
			session()->setFlashdata('error', 'Email Not Registered');
			return redirect()->back();
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

	  if ($email->send()){
      echo 'Email successfully sent';
  	} else{
      $data = $email->printDebugger(['headers']);
      print_r($data);
    }
  }

	public function indexSendOtp() {
		$data = [
      "title" => "OTP Code",
    ];
		return view('pages/authentication/otp_code', $data);
	}

	public function sendOtp() {
		return redirect()->to(base_url()."/new-password");
	}

	public function indexNewPassword() {
		$data = [
      		"title" => "Reset Password",
    	];
		return view('pages/authentication/new_password', $data);
	}

	public function newPassword() {
	// 	if (!$this->validate([
	// 		'password' => [
    //     'rules' => 'required|min_length[4]|max_length[50]',
    //     'errors' => [
    //       'required' => '{field} required',
    //       'min_length' => '{field} minimum 4 characters',
    //       'max_length' => '{field} maximum 50 characters',
    //   	]
    //   ],
    //   'password_confirm' => [
    //     'rules' => 'matches[password]',
    //   	'errors' => [
    //       'matches' => 'Confirm password does not match with the password',
    //     ]
    //   ],
    // ])) {
    //   session()->setFlashdata('error', $this->validator->listErrors());
    //   return redirect()->back()->withInput();
    // }

		// $email = $this->session->get("email");
		// $updatePassword = [
		// 	'password' => password_hash($this->request->getVar('password'), PASSWORD_BCRYPT),
		// ];

		// $this->loginModel->updateUserByEmail($updatePassword, $email);
		// $this->resetModel->deleteDataByEmail($email);

		// session()->setFlashdata('error', 'Please login with new password');
		// $this->session->destroy();
    return redirect()->to('/login');
	}
}