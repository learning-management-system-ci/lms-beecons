<?php
namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\UsersModel;
use Firebase\JWT\JWT;

class AuthController extends BaseController
{
  private $loginModel=NULL;
	private $googleClient=NULL;

	function __construct(){
    $this->session = \Config\Services::session();
    $this->session->start();

		require_once APPPATH. "../vendor/autoload.php";
		$this->loginModel = new UsersModel();
		$this->googleClient = new \Google_Client();
		$this->googleClient->setClientId("229684572752-p2d3d602o4jegkurrba5k2humu61k8cv.apps.googleusercontent.com");
		$this->googleClient->setClientSecret("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");
		$this->googleClient->setRedirectUri("http://localhost:8080/login/loginWithGoogle");
		$this->googleClient->addScope("email");
		$this->googleClient->addScope("profile");

	}

	public function indexLogin()
	{
		if(session()->get("LoggedUserData")){
			session()->setFlashData("Error", "You have Already Logged In");
			return redirect()->to(base_url()."/profile");
		}
		$data['googleButton'] = '<a href="'.$this->googleClient->createAuthUrl().'"><img src="image/google.png" alt=""></a>';
		return view('pages/authentication/login', $data);
	}
  
	public function loginWithGoogle()
	{
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
				$userdata = [
					'oauth_id'=>$data['id'],
					'email'=>$data['email'] , 
					'updated_at'=>$currentDateTime
				];
				$this->loginModel->updateUserData($userdata, $data['id']);
			}else{
				$userdata = [
					'oauth_id'=>$data['id'],
					'email'=>$data['email'] , 
					'created_at'=>$currentDateTime
				];
				$this->loginModel->insertUserData($userdata);
			}
			session()->set("LoggedUserData", $userdata);

		}else{
			session()->setFlashData("Error", "Something went Wrong");
			return redirect()->to(base_url());
		}
		return redirect()->to(base_url()."/profile");
	}

	public function profile() {
		if(!session()->get("LoggedUserData")){
			session()->setFlashData("Error", "You have Logged Out, Please Login Again.");
			return redirect()->to(base_url());
		}
		return view('pages/authentication/profile');
	}

	function logout() {
		session()->remove('LoggedUserData');
		session()->remove('AccessToken');
		if(!(session()->get('LoggedUserData') && session()->get('AccessToken') )){
			session()->setFlashData("Success", "Logout Successful");
			return redirect()->to(base_url());
		}else{
			session()->setFlashData("Error", "Failed to Logout, Please Try Again");
			return redirect()->to(base_url()."/profile");
		}
	}

	public function indexRegister() {
		$data['googleButton'] = '<a href="'.$this->googleClient->createAuthUrl().'"><img src="image/google.png" alt=""></a>';
		return view('pages/authentication/register', $data);
	}

	public function register() {
        if (!$this->validate([
            'email' => [
                'rules' => 'required|is_unique[users.email]',
                'errors' => [
                    'required' => '{field} Harus diisi',
                    'is_unique' => 'Username sudah digunakan sebelumnya'
                ]
            ],
            'password' => [
                'rules' => 'required|min_length[4]|max_length[50]',
                'errors' => [
                    'required' => '{field} Harus diisi',
                    'min_length' => '{field} Minimal 4 Karakter',
                    'max_length' => '{field} Maksimal 50 Karakter',
                ]
            ],
            'password_confirm' => [
                'rules' => 'matches[password]',
                'errors' => [
                    'matches' => 'Konfirmasi Password tidak sesuai dengan password',
                ]
            ],
        ])) {
            session()->setFlashdata('error', $this->validator->listErrors());
            return redirect()->back()->withInput();
        }

		$key = getenv('TOKEN_SECRET');
        $payload = array(
			"iat" => 1356999524,
    		"nbf" => 1357000000,
    		"exp" => time() + (60 * 60),
            "email" => $this->request->getVar('email')
        );
		
        $token = JWT::encode($payload, $key);

        $users = new UsersModel();
        $users->insert([
            'email' => $this->request->getVar('email'),
            'password' => password_hash($this->request->getVar('password'), PASSWORD_BCRYPT),
			'activation_code' => $token
        ]);

		$this->sendActivationEmail($this->request->getVar('email'), $token);
		session()->setFlashdata('success', 'silahkan cek email utk aktivasi');
        return redirect()->to('/login');
    }

	public function login() {
        $users = new UsersModel();
        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');
        $dataUser = $users->where([
            'email' => $email,
        ])->first();
		
		if ($dataUser['activation_status'] != 1) {
			session()->setFlashdata('error', 'User Belum Diaktifkan');
            return redirect()->back();
		}
        if ($dataUser) {
            if (password_verify($password, $dataUser['password'])) {
				var_dump('login');
                session()->set([
                    'email' => $dataUser['email'],
                    'fullname' => $dataUser['fullname'],
                    'LoggedUserData' => TRUE
                ]);

                //return redirect()->to(base_url('home'));
				return redirect()->to(base_url()."/profile");
            } else {
                session()->setFlashdata('error', 'Email & Password Salah');
                return redirect()->back();
            }
        } else {
            session()->setFlashdata('error', 'Email & Password Salah');
            return redirect()->back();
        }
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
        if ($email->send()) 
		{
            echo 'Email successfully sent';
        } 
		else 
		{
            $data = $email->printDebugger(['headers']);
            print_r($data);
        }
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
		$users = new UsersModel();
        $users->updateUserByEmail([
            'activation_status' => 1,
			'activation_code' => ''
        ], $decoded->email);
		return redirect()->to(base_url()."/login");
	}
}