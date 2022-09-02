<?php
namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\LoginModel;

class Login extends BaseController
{
  private $loginModel=NULL;
	private $googleClient=NULL;

	function __construct(){
    $this->session = \Config\Services::session();
    $this->session->start();

		require_once APPPATH. "../vendor/autoload.php";
		$this->loginModel = new loginModel();
		$this->googleClient = new \Google_Client();
		$this->googleClient->setClientId("229684572752-p2d3d602o4jegkurrba5k2humu61k8cv.apps.googleusercontent.com");
		$this->googleClient->setClientSecret("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");
		$this->googleClient->setRedirectUri("http://localhost:8080/login/loginWithGoogle");
		$this->googleClient->addScope("email");
		$this->googleClient->addScope("profile");

	}

	public function login()
	{
		if(session()->get("LoggedUserData")){
			session()->setFlashData("Error", "You have Already Logged In");
			return redirect()->to(base_url()."/profile");
		}
		$data['googleButton'] = '<a href="'.$this->googleClient->createAuthUrl().'"><img src="image/google.png" alt=""></a>';
		return view('pages/authentication/login', $data);
	}

	public function profile()
	{
		if(!session()->get("LoggedUserData")){
			session()->setFlashData("Error", "You have Logged Out, Please Login Again.");
			return redirect()->to(base_url());
		}
		return view('pages/authentication/profile');
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
			if($this->loginModel->isAlreadyRegister($data['id'])){
				$userdata = [
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

	function logout(){
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
}