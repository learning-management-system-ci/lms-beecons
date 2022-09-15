<?php
namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\UsersModel;
use Firebase\JWT\JWT;

class UserController extends ResourceController {
    
    use ResponseTrait;
    public function profile() {
        $key = getenv('TOKEN_SECRET');
        $header = $this->request->getServer('HTTP_AUTHORIZATION');
        if(!$header) return $this->failUnauthorized('Access token required');
        $token = explode(' ', $header)[1];
        
        try {
            $decoded = JWT::decode($token, $key, ['HS256']);
            $user = new UsersModel;
            $data = $user->where('id', $decoded->uid)->first();

            $response = [
                'id' => $decoded->uid,
                'fullname' =>  $data['fullname'],
                'email' => $decoded->email,
                'phone_number' => $data['phone_number']
            ];
            return $this->respond($response);
        } catch (\Throwable $th) {
            return $this->fail('Invalid access token');
        }
    }
}
