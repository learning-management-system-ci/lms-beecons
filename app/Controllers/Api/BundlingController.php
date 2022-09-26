<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\Bundling;

class BundlingController extends ResourceController
{
    use ResponseTrait;

    public function __construct()
    {
        $this->bundling = new Bundling();
    }

    public function index(){
        $data['bundling'] = $this->bundling->orderBy('bundling_id', 'DESC')->findAll();
        return $this->respond($data);
    }

    public function create() {
        $rules = [
            "title" => "required",
            "description" => "required|max_length[255]",
            "price" => "required|numeric",
        ];

        $messages = [
            "title" => [
                "required" => "{field} tidak boleh kosong"
            ],
            "description" => [
                "required" => "{field} tidak boleh kosong",
                "max_length" => "{field} maksimal 255 karakter",
            ],
            "price" => [
                "required" => "{field} tidak boleh kosong",
                "numeric" => "{field} harus berisi angka"
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
            $data['title'] = $this->request->getVar("title");
            $data['description'] = $this->request->getVar("description");
            $data['price'] = $this->request->getVar("price");

            $this->bundling->save($data);

            $response = [
                'status' => 200,
                'error' => false,
                'message' => 'Bundling berhasil dibuat',
                'data' => []
            ];
        }
        return $this->respondCreated($response);
    }

    public function show($id = null){
        $data = $this->bundling->where('bundling_id', $id)->first();
        if($data){
            return $this->respond($data);
        }else{
            return $this->failNotFound('Data bundling tidak ditemukan');
        }
    }

	public function update($id = null){
		$input = $this->request->getRawInput();

		$rules = [
            "title" => "required",
            "description" => "required|max_length[255]",
            "price" => "required|numeric",
        ];
		
		$messages = [
            "title" => [
                "required" => "{field} tidak boleh kosong"
            ],
            "description" => [
                "required" => "{field} tidak boleh kosong",
                "max_length" => "{field} maksimal 255 karakter",
            ],
            "price" => [
                "required" => "{field} tidak boleh kosong",
                "numeric" => "{field} harus berisi angka"
            ],
        ];

		$data = [
			"title" => $input["title"],
			"description" => $input["description"],
			"price" => $input["price"],
	  ];

		$response = [
			'status'   => 200,
			'error'    => null,
			'messages' => [
				'success' => 'Bundling berhasil diperbarui'
			]
		];

		$cek = $this->bundling->where('bundling_id', $id)->findAll();

		if(!$cek){
			return $this->failNotFound('Data bundling tidak ditemukan');
		}

		if (!$this->validate($rules, $messages)) {
      return $this->failValidationErrors($this->validator->getErrors());
    }

		if ($this->bundling->update($id, $data)){
			return $this->respond($response);
		}
		return $this->failNotFound('Data bundling tidak ditemukan');
	}

    public function delete($id = null){
        $data = $this->bundling->where('bundling_id', $id)->findAll();
        if($data){
        $this->bundling->delete($id);
            $response = [
            'status'   => 200,
            'error'    => null,
            'messages' => [
                'success' => 'Bundling berhasil dihapus'
            ]
            ];
        return $this->respondDeleted($response);
        }else{
        return $this->failNotFound('Data bundling tidak ditemukan');
        }
    }
}
