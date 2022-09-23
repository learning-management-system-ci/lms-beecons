<?php
namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\Faq;

class FaqController extends ResourceController {
    
    use ResponseTrait;
    private $faqModel=NULL;

	function __construct(){
		$this->faqModel = new Faq();
	}

    public function index(){
        $data = $this->faqModel->orderBy('faq_id', 'DESC')->findAll();
		if(count($data) > 0){
            return $this->respond($data);
        }else{
            return $this->failNotFound('Tidak ada data');
        }
    }

    public function create() {
        $rules = [
			"question" => "required",
			"answer" => "required",
		];

		$messages = [
			"question" => [
				"required" => "{field} tidak boleh kosong"
			],
            "answer" => [
                "required" => "{field} tidak boleh kosong"
            ],
		];

		if (!$this->validate($rules, $messages)) {

			$response = [
				'status' => 500,
				'error' => 500,
				'message' => $this->validator->getErrors(),
				'data' => []
			];
		} else {
			$data['question'] = $this->request->getVar("question");
			$data['answer'] = $this->request->getVar("answer");

			$this->faqModel->save($data);

			$response = [
				'status' => 200,
				'success' => 200,
				'message' => 'FAQ berhasil dibuat',
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
            return $this->failNotFound('Data FAQ tidak ditemukan');
        }
    }

	public function update($id = null) {
		$input = $this->request->getRawInput();
		$rules = [
			"question" => "required",
			"answer" => "required",
		];
	
		$messages = [
			"question" => ["required" => "{field} tidak boleh kosong"],
			"answer" => ["required" => "{field} tidak boleh kosong"]
		];

		$data = [
			"question" => $input["question"],
			"answer" => $input["answer"],
	  ];

		$response = [
			'status'   => 200,
			'success'    => 200,
			'messages' => [
					'success' => 'FAQ berhasil diperbarui'
			]
		];

		$cek = $this->faqModel->where('faq_id', $id)->findAll();

		if(!$cek){
			return $this->failNotFound('Data FAQ tidak ditemukan');
		}

		if (!$this->validate($rules, $messages)) {
			return $this->failValidationErrors($this->validator->getErrors());
  		}

		if ($this->faqModel->update($id, $data)){
			return $this->respond($response);
		}
		return $this->failNotFound('Data FAQ tidak ditemukan');
	}

    public function delete($id = null){
        $data = $this->faqModel->where('faq_id', $id)->findall();
        if($data){
            $this->faqModel->delete($id);
            $response = [
                'status'   => 200,
                'success'    => 200,
                'messages' => [
                    'success' => 'FAQ berhasil dihapus'
                ]
            ];
            return $this->respondDeleted($response);
        }else {
            return $this->failNotFound('Data FAQ tidak ditemukan');
        }
    }
}
