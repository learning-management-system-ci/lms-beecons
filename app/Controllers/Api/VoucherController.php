<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\VoucherModel;

class VoucherController extends ResourceController
{
  use ResponseTrait;

  public function __construct()
  {
    $this->voucherModel = new VoucherModel();
  }

  public function index(){
    $data['voucher'] = $this->voucherModel->orderBy('voucher_id', 'DESC')->findAll();
    return $this->respond($data);
  }

  public function create() {
    $rules = [
			"title" => "required",
			"code" => "required|is_unique[voucher.code]|max_length[10]|alpha_numeric",
			"discount_price" => "required|numeric",
		];

		$messages = [
			"title" => [
				"required" => "{field} is required"
			],
      "code" => [
        "required" => "{field} required",
        "is_unique" => "{field} address already exists",
        "max_length" => "{field} maximum length of 10 characters",
        "alpha_numeric" => "{field} only consists of alpha and numeric",
      ],
			"discount_price" => [
				"required" => "Discount Price is required"
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
			$data['code'] = strtoupper($this->request->getVar("code"));
			$data['discount_price'] = $this->request->getVar("discount_price");

			$this->voucherModel->save($data);

			$response = [
				'status' => 200,
				'error' => false,
				'message' => 'Voucher successfully created',
				'data' => []
			];
		}
    return $this->respondCreated($response);
  }

  public function show($id = null){
    $data = $this->voucherModel->where('voucher_id', $id)->first();
    if($data){
      return $this->respond($data);
    }else{
      return $this->failNotFound('Voucher data not found');
    }
  }

	public function update($id = null){
		$input = $this->request->getRawInput();

		$rules = [
			"title" => "required",
			"code" => "required|is_unique[voucher.code,voucher_id,$id]|max_length[10]|alpha_numeric",
			"discount_price" => "required|numeric",
		];
		
		$messages = [
			"title" => [
				"required" => "{field} is required"
			],
			"code" => [
			  "required" => "{field} required",
			  "is_unique" => "{field} address already exists",
        "max_length" => "{field} maximum length of 10 characters",
			  "alpha_numeric" => "{field} only consists of alpha and numeric",
	    ],
			"discount_price" => [
				"required" => "Discount Price is required"
			],
		];

		$data = [
			"title" => $input["title"],
			"description" => $input["description"],
			"code" => strtoupper($input["code"]),
			"discount_price" => $input["discount_price"],
	  ];

		$response = [
			'status'   => 200,
			'error'    => null,
			'messages' => [
				'success' => 'Voucher successfully updated'
			]
		];

		$cek = $this->voucherModel->where('voucher_id', $id)->findAll();

		if(!$cek){
			return $this->failNotFound('Voucher data not found');
		}

		if (!$this->validate($rules, $messages)) {
      return $this->failValidationErrors($this->validator->getErrors());
    }

		if ($this->voucherModel->update($id, $data)){
			return $this->respond($response);
		}
		return $this->failNotFound('Voucher data not found');
	}

  public function delete($id = null){
    $data = $this->voucherModel->where('voucher_id', $id)->findAll();
    if($data){
      $this->voucherModel->delete($id);
        $response = [
          'status'   => 200,
          'error'    => null,
          'messages' => [
            'success' => 'Voucher successfully deleted'
          ]
        ];
      return $this->respondDeleted($response);
    }else{
      return $this->failNotFound('Voucher data not found');
    }
  }
}
