<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\Voucher;
use App\Models\Users;
use Firebase\JWT\JWT;

class VoucherController extends ResourceController
{
	use ResponseTrait;

	public function __construct()
	{
		helper('date');
		$this->voucherModel = new Voucher();
	}

	public function index()
	{
		$key = getenv('TOKEN_SECRET');
        $header = $this->request->getServer('HTTP_AUTHORIZATION');
        if (!$header) return $this->failUnauthorized('Akses token diperlukan');
        $token = explode(' ', $header)[1];

        try {
			$decoded = JWT::decode($token, $key, ['HS256']);
			$data = $this->voucherModel->orderBy('voucher_id', 'DESC')->where('is_active', 1)->findAll();
			if (count($data) > 0) {
				return $this->respond($data);
			} else {
				return $this->failNotFound('Tidak ada data');
			}
		} catch (\Throwable $th) {
			return $this->fail($th->getMessage());
        }
		
	}

	public function create()
	{
		$key = getenv('TOKEN_SECRET');
		$header = $this->request->getServer('HTTP_AUTHORIZATION');
		if (!$header) return $this->failUnauthorized('Akses token diperlukan');
		$token = explode(' ', $header)[1];

		try {
			$decoded = JWT::decode($token, $key, ['HS256']);
			$user = new Users;

  		// cek role user
		  $data = $user->select('role')->where('id', $decoded->uid)->first();
		  if ($data['role'] == 'member') {
				return $this->fail('Tidak dapat di akses oleh member', 400);
			}

			$rules = [
				"title" => "required",
				"start_date" => "required|valid_date",
				"due_date" => "required|valid_date",
				"quota" => "required|numeric|max_length[5]",
				"code" => "required|is_unique[voucher.code]|max_length[10]|alpha_numeric",
				"discount_price" => "required|numeric|max_length[2]",
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
				"quota" => [
					"required" => "{field} tidak boleh kosong",
					"numeric" => "{field} harus berisi numerik",
					"max_length" => "{field} maksimal 5 karakter",
				],
				"code" => [
					"required" => "{field} tidak boleh kosong",
					"is_unique" => "{field} telah digunakan",
					"max_length" => "{field} maksimal 10 karakter",
					"alpha_numeric" => "{field} harus berisi alfabet dan numerik",
				],
				"discount_price" => [
					"required" => "{field} tidak boleh kosong",
					"numeric" => "{field} harus berisi numerik",
					"max_length" => "{field} maksimal 2 karakter (discount bernilai persen)",
				],
				"is_active" => [
					"less_than_equal_to" => "{field} harus berisi 0 (tidak aktif) atau 1 (aktif)"
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
					'success' => 200,
					'message' => 'Voucher berhasil dibuat',
					'data' => []
				];
			}
			return $this->respondCreated($response);
		} catch (\Throwable $th) {
			return $this->fail($th->getMessage());
		}
	}

	public function show($id = null)
	{
		$key = getenv('TOKEN_SECRET');
  	$header = $this->request->getServer('HTTP_AUTHORIZATION');
	  if (!$header) return $this->failUnauthorized('Akses token diperlukan');
	  $token = explode(' ', $header)[1];

	  try {
			$decoded = JWT::decode($token, $key, ['HS256']);

			$data = $this->voucherModel->where('voucher_id', $id)->first();
			if ($data) {
				return $this->respond($data);
			} else {
				return $this->failNotFound('Data voucher tidak ditemukan');
			}
		} catch (\Throwable $th) {
      return $this->fail($th->getMessage());
    }
	}

	public function show_code()
	{
		$input = $this->request->getRawInput();
		$key = getenv('TOKEN_SECRET');
  	$header = $this->request->getServer('HTTP_AUTHORIZATION');
	  if (!$header) return $this->failUnauthorized('Akses token diperlukan');
	  $token = explode(' ', $header)[1];

	  try {
			$decoded = JWT::decode($token, $key, ['HS256']);

			$code = $_GET['code'];

			$data = $this->voucherModel->where('code', $code)->first();
			if ($data) {
				return $this->respond($data);
			} else {
				return $this->failNotFound('Data voucher tidak ditemukan');
			}
		} catch (\Throwable $th) {
      return $this->fail($th->getMessage());
    }
	}

	public function update($id = null)
	{
		$key = getenv('TOKEN_SECRET');
  	$header = $this->request->getServer('HTTP_AUTHORIZATION');
	  if (!$header) return $this->failUnauthorized('Akses token diperlukan');
	  $token = explode(' ', $header)[1];

	  try {
			$decoded = JWT::decode($token, $key, ['HS256']);
			$user = new Users;

  		// cek role user
		  $data = $user->select('role')->where('id', $decoded->uid)->first();
		  if ($data['role'] == 'member') {
				return $this->fail('Tidak dapat di akses oleh member', 400);
			}

			$input = $this->request->getRawInput();
			$rules = [
				"title" => "required",
				"start_date" => "required|valid_date",
				"due_date" => "required|valid_date",
				"quota" => "required|numeric|max_length[5]",
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
				"quota" => [
					"required" => "{field} tidak boleh kosong",
					"numeric" => "{field} harus berisi numerik",
					"max_length" => "{field} maksimal 5 karakter",
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
				'success'    => 200,
				'messages' => [
					'success' => 'Voucher berhasil diperbarui'
				]
			];
	
			$cek = $this->voucherModel->where('voucher_id', $id)->findAll();
	
			if (!$cek) {
				return $this->failNotFound('Data voucher tidak ditemukan');
			}
	
			if (!$this->validate($rules, $messages)) {
				return $this->failValidationErrors($this->validator->getErrors());
			}
	
			if ($this->voucherModel->update($id, $data)) {
				return $this->respond($response);
			}
			return $this->failNotFound('Data voucher tidak ditemukan');
		} catch (\Throwable $th) {
      return $this->fail($th->getMessage());
		}
	}

	public function delete($id = null)
	{
		$key = getenv('TOKEN_SECRET');
  	$header = $this->request->getServer('HTTP_AUTHORIZATION');
	  if (!$header) return $this->failUnauthorized('Akses token diperlukan');
	  $token = explode(' ', $header)[1];

	  try {
			$decoded = JWT::decode($token, $key, ['HS256']);
			$user = new Users;

  		// cek role user
		  $data = $user->select('role')->where('id', $decoded->uid)->first();
		  if ($data['role'] == 'member') {
				return $this->fail('Tidak dapat di akses oleh member', 400);
			}

			$data = $this->voucherModel->where('voucher_id', $id)->findAll();
			if ($data) {
				$this->voucherModel->delete($id);
				$response = [
					'status'   => 200,
					'success'    => 200,
					'messages' => [
						'success' => 'Voucher berhasil dihapus'
					]
				];
				return $this->respondDeleted($response);
			} else {
			return $this->failNotFound('Data voucher tidak ditemukan');
			}
		} catch (\Throwable $th) {
      return $this->fail($th->getMessage());
    }
	}
}
