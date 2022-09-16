<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\VoucherModel;

class VoucherController extends ResourceController {
  use ResponseTrait;

  public function __construct() {
		helper('date');
    	$this->voucherModel = new VoucherModel();
  }

  public function index(){
    $data['voucher'] = $this->voucherModel->orderBy('voucher_id', 'DESC')->findAll();
    return $this->respond($data);
  }

  public function create() {
    $rules = [
			"title" => "required",
			"start_date" => "required|valid_date",
			"due_date" => "required|valid_date",
			"code" => "required|is_unique[voucher.code]|max_length[10]|alpha_numeric",
			"discount_price" => "required|numeric",
			"is_active" => "less_than_equal_to[1]",
		];

		$messages = [
			"title" => [
				"required" => "{field} tidak boleh kosong"
			],
			"start_date" => [
				"required" => "{field} tidak boleh kosong",
				"valid_date" => "{field} format tanggal tidak sesuai"
			],
			"due_date" => [
				"required" => "{field} tidak boleh kosong",
				"valid_date" => "{field} format tanggal tidak sesuai"
			],
			"code" => [
				"required" => "{field} tidak boleh kosong",
				"is_unique" => "{field} telah digunakan",
				"max_length" => "{field} maksimal 10 karakter",
				"alpha_numeric" => "{field} harus berisi alfabet dan numerik",
			],
			"discount_price" => [
				"required" => "{field} tidak boleh kosong"
			],
			"is_active" => [
				"less_than_equal_to" => "{field} harus berisi 0 (tidak aktif) atau 1 (aktif)"
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
			$data['start_date'] = date("Y-m-d", strtotime($this->request->getVar("start_date")));
			$data['due_date'] = date("Y-m-d", strtotime($this->request->getVar("due_date")));
			$data['is_active'] = $this->request->getVar("is_active");
			$data['code'] = strtoupper($this->request->getVar("code"));
			$data['discount_price'] = $this->request->getVar("discount_price");

			$this->voucherModel->save($data);

			$response = [
				'status' => 200,
				'error' => false,
				'message' => 'Voucher berhasil dibuat',
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
      return $this->failNotFound('Data voucher tidak ditemukan');
    }
  }

	public function update($id = null){
		$input = $this->request->getRawInput();

		$rules = [
			"title" => "required",
			"start_date" => "required|valid_date",
			"due_date" => "required|valid_date",
			"code" => "required|is_unique[voucher.code,voucher_id,$id]|max_length[10]|alpha_numeric",
			"discount_price" => "required|numeric",
			"is_active" => "less_than_equal_to[1]",
		];
		
		$messages = [
			"title" => [
				"required" => "{field} tidak boleh kosong"
			],
			"start_date" => [
				"required" => "{field} tidak boleh kosong",
				"valid_date" => "{field} format tanggal tidak sesuai"
			],
			"due_date" => [
				"required" => "{field} tidak boleh kosong",
				"valid_date" => "{field} format tanggal tidak sesuai"
			],
			"code" => [
				"required" => "{field} tidak boleh kosong",
				"is_unique" => "{field} telah digunakan",
				"max_length" => "{field} maksimal 10 karakter",
				"alpha_numeric" => "{field} harus berisi alfabet dan numerik",
			],
			"discount_price" => [
				"required" => "{field} tidak boleh kosong"
			],
			"is_active" => [
				"less_than_equal_to" => "{field} harus berisi 0 (tidak aktif) atau 1 (aktif)"
			],
		];

		$data = [
			"title" => $input["title"],
			"description" => $input["description"],
			"start_date" => date("Y-m-d", strtotime($input["start_date"])),
			"due_date" => date("Y-m-d", strtotime($input["due_date"])),
			"is_active" => $input["is_active"],
			"code" => strtoupper($input["code"]),
			"discount_price" => $input["discount_price"],
	  ];

		$response = [
			'status'   => 200,
			'error'    => null,
			'messages' => [
				'success' => 'Voucher berhasil diperbarui'
			]
		];

		$cek = $this->voucherModel->where('voucher_id', $id)->findAll();

		if(!$cek){
			return $this->failNotFound('Data voucher tidak ditemukan');
		}

		if (!$this->validate($rules, $messages)) {
      return $this->failValidationErrors($this->validator->getErrors());
    }

		if ($this->voucherModel->update($id, $data)){
			return $this->respond($response);
		}
		return $this->failNotFound('Data voucher tidak ditemukan');
	}

  public function delete($id = null){
    $data = $this->voucherModel->where('voucher_id', $id)->findAll();
    if($data){
      $this->voucherModel->delete($id);
        $response = [
          'status'   => 200,
          'error'    => null,
          'messages' => [
            'success' => 'Voucher berhasil dihapus'
          ]
        ];
      return $this->respondDeleted($response);
    }else{
      return $this->failNotFound('Data voucher tidak ditemukan');
    }
  }
}
