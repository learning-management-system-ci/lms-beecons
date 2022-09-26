<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\Review;
use Firebase\JWT\JWT;

class ReviewController extends ResourceController {

    use ResponseTrait;

    public function __construct()
    {
        $this->review = new Review();
    }

    public function index(){
        $data['review'] = $this->review->orderBy('course_id', 'DESC')->findAll();
        return $this->respond($data);
    }

    public function create() {
        $key = getenv('TOKEN_SECRET');
        $header = $this->request->getServer('HTTP_AUTHORIZATION');
        if (!$header) return $this->failUnauthorized('Akses token diperlukan');
        $token = explode(' ', $header)[1];

        try {
		    $decoded = JWT::decode($token, $key, ['HS256']);
            $rules = [
                "feedback" => "required|max_length[250]",
                "score" => "numeric",
            ];
    
            $messages = [
                "feedback" => [
                    "required" => "{field} is required",
                    "max_length" => "Maximum {field} is 250 characters"
                ],
                "score" => [
                    "numeric" => "{field} only contain numbers",
                ],
            ];
    
            if (!$this->validate($rules, $messages)) {
                $response = [
                    'status' => 500,
                    'error' => true,
                    'message' => $this->validator->getErrors(),
                    'data' => []
                ];
            } else {
                $data['user_id'] = $this->request->getVar("user_id");
                $data['course_id'] = $this->request->getVar("course_id");
                $data['feedback'] = $this->request->getVar("feedback");
                $data['score'] = $this->request->getVar("score");
    
                $this->review->save($data);
    
                $response = [
                    'status' => 200,
                    'error' => false,
                    'message' => 'Review successfully created',
                    'data' => []
                ];
            }
            return $this->respondCreated($response);
	    } catch (\Throwable $th) {
            return $this->fail('Akses token tidak sesuai');
        }

    }
}