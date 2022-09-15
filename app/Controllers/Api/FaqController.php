<?php
namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\FaqModel;

class FaqController extends ResourceController {
    
    use ResponseTrait;
    private $faqModel=NULL;

	function __construct(){
		$this->faqModel = new FaqModel();
	}

    public function index(){
        $data['faq'] = $this->faqModel->orderBy('faq_id', 'DESC')->findAll();
        return $this->respond($data);
    }

    public function create() {
        $rules = [
			"question" => "required",
			"answer" => "required",
		];

		$messages = [
			"question" => [
				"required" => "{field} is required"
			],
            "answer" => [
                "required" => "{field} required"
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
			$data['question'] = $this->request->getVar("question");
			$data['answer'] = $this->request->getVar("answer");

			$this->faqModel->save($data);

			$response = [
				'status' => 200,
				'error' => false,
				'message' => 'FAQ successfully created',
				'data' => []
			];
		}
        return $this->respondCreated($response);
    }

    public function show($id = null){
        $data = $this->faqModel->where('faq_id', $id)->first();
        //print_r($data);
        if($data){
            return $this->respond($data);
        }else{
            return $this->failNotFound('FAQ data not found');
        }
    }

	public function update($id = null) {
		$input = $this->request->getRawInput();
		$rules = [
			"question" => "required",
			"answer" => "required",
		];
	
		$messages = [
			"question" => ["required" => "{field} is required"],
			"answer" => ["required" => "{field} required"]
		];

		$data = [
			"question" => $input["question"],
			"answer" => $input["answer"],
	  ];

		$response = [
			'status'   => 200,
			'error'    => null,
			'messages' => [
					'success' => 'FAQ successfully updated'
			]
		];

		$cek = $this->faqModel->where('faq_id', $id)->findAll();

		if(!$cek){
			return $this->failNotFound('FAQ data not found');
		}

		if (!$this->validate($rules, $messages)) {
			return $this->failValidationErrors($this->validator->getErrors());
  		}

		if ($this->faqModel->update($id, $data)){
			return $this->respond($response);
		}
		return $this->failNotFound('FAQ data not found');
	}

    public function delete($id = null){
        $data = $this->faqModel->where('faq_id', $id)->findall();
        if($data){
            $this->faqModel->delete($id);
            $response = [
                'status'   => 200,
                'error'    => null,
                'messages' => [
                    'success' => 'FAQ successfully deleted'
                ]
            ];
            return $this->respondDeleted($response);
        }else {
            return $this->failNotFound('FAQ data not found');
        }
    }
}
