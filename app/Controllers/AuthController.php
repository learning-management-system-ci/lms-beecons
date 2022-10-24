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

	function __construct(){
        helper("cookie");

		require_once APPPATH. "../vendor/autoload.php";
		$this->googleClient = new \Google_Client();
		$this->googleClient->setClientId("229684572752-p2d3d602o4jegkurrba5k2humu61k8cv.apps.googleusercontent.com");
		$this->googleClient->setClientSecret("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");
		$this->googleClient->setRedirectUri(base_url()."/login/loginWithGoogle");
		$this->googleClient->addScope("email");
		$this->googleClient->addScope("profile");
	}

	public function indexLogin()
	{
		if(get_cookie("access_token")){
			return redirect()->to(base_url()."/profile");
		}
		$data = [
            "title" => "Sign In",
            "googleButton" => $this->googleClient->createAuthUrl(),
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
                    return redirect()->back();
                } 
                return redirect()->to(base_url()."/profile");
        } else {
            return redirect()->back();
        }
    }
  }
  
	public function loginWithGoogle()
	{
		return redirect()->to(base_url()."/profile");
	}

	public function profile() {
		if(!get_cookie("access_token")){
			return redirect()->to(base_url());
		}
        $token = get_cookie("access_token");
        $key = getenv('TOKEN_SECRET');
        try {
            $decoded = JWT::decode($token, $key, array('HS256'));
        }catch(Exception $e){
            echo 'Caught exception: ',  $e->getMessage(), "\n";
            return ;
        }
        
        if ($decoded) {
            if (!$decoded->email) {
                    return redirect()->back();
                }
            $email = $decoded->email;
        }
        $data = [
            "title" => $email,
            "profile" => "",
            "cardButton" => 'Join The Webinar',
        ];
		return view('pages/navigation/profile', $data);
	}

	function logout() {
		return redirect()->to(base_url());
	}

	public function indexRegister() {
		$data = [
            "title" => "Sign Up",
            "googleButton" => $this->googleClient->createAuthUrl(),
        ];
		return view('pages/authentication/register', $data);
	}

	public function register() {
	    if ($this->request->isAJAX()) {
		return redirect()->to(base_url().'/login');
	    }
	    return redirect()->to(base_url().'/login');
	}

	public function indexforgotPassword() {
		if (get_cookie("email")) {
			return redirect()->to('/send-otp');
		}
	    $data = [
      		"title" => "Reset Password",
    	    ];
	    return view('pages/authentication/forgot_password', $data);
	}

	public function forgotPassword() {
		return redirect()->to('/send-otp');
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

	public function newPassword() 
    {
        return redirect()->to('/login');
	}

    public function referralCode()
    {
        if(!get_cookie("access_token")){
			return redirect()->to(base_url());
		}
        $data = [
            "title" => "Referral Code",
            "profile" => "",
            "cardButton" => 'Join The Webinar',
        ];
        return view('pages/navigation/referral_code', $data);
    }
}