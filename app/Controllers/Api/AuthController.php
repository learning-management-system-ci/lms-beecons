<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\Users;
use Firebase\JWT\JWT;
use CodeIgniter\Cookie\Cookie;
use App\Models\Referral;
use App\Controllers\NotificationControllers;
use DateTime;
use DateInterval;

class AuthController extends ResourceController
{
    private $loginModel = NULL;
    private $googleClient = NULL;

    function __construct()
    {
        helper("cookie");

        require_once APPPATH . "../vendor/autoload.php";
        $this->loginModel = new Users();
        $this->referral = new Referral();
        $this->sendnotification = new NotificationController();
        $this->googleClient = new \Google_Client();
        $this->googleClient->setClientId("229684572752-p2d3d602o4jegkurrba5k2humu61k8cv.apps.googleusercontent.com");
        $this->googleClient->setClientSecret("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");
        $this->googleClient->setRedirectUri(base_url() . "/login/loginWithGoogle");
        $this->googleClient->addScope("email");
        $this->googleClient->addScope("profile");
    }

    public function loginWithGoogle()
    {
        $token = $this->googleClient->fetchAccessTokenWithAuthCode($this->request->getVar('code'));
        if (!isset($token['error'])) {
            $this->googleClient->setAccessToken($token['access_token']);

            $googleService = new \Google\Service\Oauth2($this->googleClient);
            $data = $googleService->userinfo->get();
            $currentDateTime = date("Y-m-d H:i:s");
            $userdata = array();
            $email = $data['email'];
            if ($this->loginModel->isAlreadyRegister($data['id']) || $this->loginModel->isAlreadyRegisterByEmail($email)) {
                $userdata = [
                    'oauth_id' => $data['id'],
                    'email' => $email,
                    'updated_at' => $currentDateTime,
                    'activation_status' => '1',
                ];
                $this->loginModel->updateUserByEmail($userdata, $email);
            } else {
                $userdata = [
                    'oauth_id' => $data['id'],
                    'email' => $email,
                    'created_at' => $currentDateTime,
                    'activation_status' => '1',
                    'profile_picture' => 'default.png',
                    'role' => 'member',
                ];
                $this->loginModel->save($userdata);

                // referral
                $datauser = $this->loginModel->getUser($email);
                do {
                    $code = strtoupper(bin2hex(random_bytes(4)));
                    $code_check = $this->referral->where('referral_code', $code)->first();
                } while ($code_check);
    
                $data = [
                    'user_id' => $datauser['id'],
                    'referral_code' => $code,
                    'discount_price' => 15
                ];
                $this->referral->save($data);

                // $this->sendnotification->sendnotification($datauser['id'],"Lengkapi Data Profile Anda");
            }
            $datauser = $this->loginModel->getUser($email);
            $key = getenv('TOKEN_SECRET');
            $payload = [
                'iat'   => 1356999524,
                'nbf'   => 1357000000,
                "exp" => time() + (60 * 60),
                'uid'   => $datauser['id'],
                'email' => $email,
                'role' => $datauser['role'],
            ];
            $token = JWT::encode($payload, $key, 'HS256');
        } else {
            $response = [
                'status' => 500,
                'error' => true,
                'message' => 'Terdapat Masalah Saat Login',
                'data' => []
            ];
            $this->respondCreated($response);
            return;
        }
        $response = [
            'status' => 200,
            'error' => false,
            'data' => [$token]
        ];
        $this->respondCreated($response);
        setcookie("access_token", $token, time() + 60 * 60, '/');
        return redirect()->to(base_url() . "/login");
    }

    public function loginOneTapGoogle()
    {
        // set google client ID
        $google_oauth_client_id = "229684572752-p2d3d602o4jegkurrba5k2humu61k8cv.apps.googleusercontent.com";

        // create google client object with client ID
        $client = new \Google_Client([
            'client_id' => $google_oauth_client_id
        ]);

        // verify the token sent from AJAX
        $id_token = $_POST['credential'];

        // print_r($id_token);

        $payload = $client->verifyIdToken($id_token);
        if ($payload && $payload['aud'] == $google_oauth_client_id) {
            // get user information from Google
            $currentDateTime = date("Y-m-d H:i:s");
            $user_google_id = $payload['sub'];
            $email = $payload["email"];
            $userdata = array();

            if ($this->loginModel->isAlreadyRegister($user_google_id) || $this->loginModel->isAlreadyRegisterByEmail($email)) {
                $userdata = [
                    'oauth_id' => $user_google_id,
                    'email' => $email,
                    'updated_at' => $currentDateTime,
                    'activation_status' => '1',
                ];
                $this->loginModel->updateUserByEmail($userdata, $email);
            } else {
                $userdata = [
                    'oauth_id' => $user_google_id,
                    'email' => $email,
                    'updated_at' => $currentDateTime,
                    'activation_status' => '1',
                    'profile_picture' => 'default.png',
                    'role' => 'member',
                ];
                $this->loginModel->save($userdata);

                // referral
                $datauser = $this->loginModel->getUser($email);
                do {
                    $code = strtoupper(bin2hex(random_bytes(4)));
                    $code_check = $this->referral->where('referral_code', $code)->first();
                } while ($code_check);
    
                $data = [
                    'user_id' => $datauser['id'],
                    'referral_code' => $code,
                    'discount_price' => 15
                ];
                $this->referral->save($data);
            }
            $datauser = $this->loginModel->getUser($email);
            $key = getenv('TOKEN_SECRET');
            $payload = [
                'iat'   => 1356999524,
                'nbf'   => 1357000000,
                "exp" => time() + (60 * 60),
                'uid'   => $datauser['id'],
                'email' => $email,
                'role' => $datauser['role'],
            ];
            $token = JWT::encode($payload, $key, 'HS256');
        } else {
            $response = [
                'status' => 500,
                'error' => true,
                'message' => 'Terdapat Masalah Saat Login',
                'data' => []
            ];
            $this->respondCreated($response);
            return;
        }
        $response = [
            'status' => 200,
            'error' => false,
            'data' => [$token]
        ];
        $this->respondCreated($response);
        setcookie("access_token", $token, time() + 60 * 60, '/');
        return redirect()->to(base_url() . "/login");
    }

    public function register()
    {
        $rules = [
            "email" => "required|valid_email",
            "password" => "required|min_length[8]|max_length[50]",
            "password_confirm" => "matches[password]",
        ];

        $messages = [
            "email" => [
                'required' => '{field} tidak boleh kosong',
                'valid_email' => 'Format email tidak sesuai'
            ],
            "password" => [
                'required' => '{field} tidak boleh kosong',
                'min_length' => '{field} minimal 8 karakter',
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
                'message' => $this->validator->getErrors(),
                'data' => []
            ];
            return $this->fail($response);
        } else {
            $email =  $this->request->getVar('email');
            $verifyEmail = $this->loginModel
                            ->where("email", $email)
                            ->where("activation_status", 0)
                            ->first();
            $verifyActivation = $this->loginModel
                                ->where("email", $email)
                                ->where("activation_status", 1)
                                ->first();
            $userdata['email'] = $email;
            $userdata['role'] = 'member';
            $userdata['profile_picture'] = 'default.png';
            $userdata['password'] = password_hash($this->request->getVar('password'), PASSWORD_BCRYPT);
            $userdata['activation_code'] = $token;

            if ($verifyActivation) return $this->failNotFound('Email telah digunakan');
            
            if ($verifyEmail == NULL) {
                $this->loginModel->save($userdata);
            } else {
                $this->loginModel->updateUserByEmail($userdata, $email);
            }
            $this->sendActivationEmail($this->request->getVar('email'), $token);

            $response = [
                'status' => 201,
                'success' => 201,
                'message' => 'Akun berhasil dibuat, silakan periksa email Anda untuk aktivasi',
                'data' => []
            ];
            return $this->respondCreated($response);
        }
    }

    function sendActivationEmail($emailTo, $token)
    {
        //$to = $this->request->getVar('mailTo'); 
        $subject = 'Link Aktivasi Akun';
        $link = base_url() . "/api/activateuser?token=" . $token;
        $path = base_url();
        $data = [
            "link" => $link,
            "email" => $emailTo,
            "path" => $path,
        ];
        $message = view('html_email/email_verify.html', $data);

        $email = \Config\Services::email();
        $email->setTo($emailTo);
        $email->setFrom('hendrikusozzie@gmail.com', 'Konfirmasi Pendaftaran');

        $email->setSubject($subject);
        $email->setMessage($message);
        $email->send();
    }

    public function activateUser()
    {
        $token = $this->request->getVar('token');
        //echo $token;
        $key = getenv('TOKEN_SECRET');

        $referral = new Referral();
        try {
            $decoded = JWT::decode($token, $key, array('HS256'));

            $uid = $this->loginModel->select('id')->where('email', $decoded->email)->first();
            $check = $referral->where('user_id',  $uid)->first();

            do {
                $code = strtoupper(bin2hex(random_bytes(4)));
                $code_check = $referral->where('referral_code', $code)->first();
            } while ($code_check);

            if (!$check) {
                $data = [
                    'user_id' => $uid,
                    'referral_code' => $code,
                    'discount_price' => 15
                ];
                $referral->save($data);
            }
        } catch (\Firebase\JWT\ExpiredException $e) {
            //echo 'Caught exception: ',  $e->getMessage(), "\n";
            $message = [
                "message" => $e->getMessage()
            ];
            return view('errors/html/error_404', $message);
            //return;
        }

        $this->loginModel->updateUserByEmail([
            'activation_status' => 1,
            'activation_code' => '',
            'profile_picture' => 'default.png',
        ], $decoded->email);
        return redirect()->to(base_url() . "/login");
    }

    public function indexLogin()
    {
        $data = [
            "title" => "Sign In",
            "googleButton" => $this->googleClient->createAuthUrl(),
        ];
        return $this->respond($data);
    }

    public function indexRegister()
    {
        $data = [
            "title" => "Sign Up",
            "googleButton" => $this->googleClient->createAuthUrl(),
        ];
        return $this->respond($data);
    }

    public function indexforgotPassword()
    {
        $data = [
            "title" => "Reset Password",
        ];
        return $this->respond($data);
    }

    public function indexSendOtp()
    {
        $data = [
            "title" => "OTP Code",
        ];
        return $this->respond($data);
    }

    public function indexNewPassword()
    {
        $data = [
            "title" => "Reset Password",
        ];
        return $this->respond($data);
    }

    public function login()
    {
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
        if (!$verifyEmail) return $this->failNotFound('Email atau kata sandi salah');

        $verifyPass = password_verify($this->request->getVar('password'), $verifyEmail['password']);
        if (!$verifyPass) {
            return $this->fail('Email atau kata sandi salah');
        } else if ($verifyEmail['activation_status'] != 1) {
            return $this->fail('Pengguna belum aktif');
        } else {
        }
        $datauser = $verifyEmail;
        $key = getenv('TOKEN_SECRET');
        $payload = [
            'iat'   => 1356999524,
            'nbf'   => 1357000000,
            "exp" => time() + (60 * 60),
            'uid'   => $verifyEmail['id'],
            'email' => $verifyEmail['email'],
            'role' => $datauser['role'],
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
