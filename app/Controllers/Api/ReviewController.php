<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\ReviewModel;

class ReviewController extends ResourceController {

    use ResponseTrait;

    public function __construct()
    {
        $this->reviewModel = new ReviewModel();
    }

    public function index(){
        $data['review'] = $this->reviewModel->orderBy('course_id', 'DESC')->findAll();
        return $this->respond($data);
    }

    public function create() {
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

            $this->reviewModel->save($data);

            $response = [
                'status' => 200,
                'error' => false,
                'message' => 'Review successfully created',
                'data' => []
            ];
        }
        return $this->respondCreated($response);
    }
}