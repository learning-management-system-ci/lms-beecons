<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\PolicyAndPrivacy;
use CodeIgniter\HTTP\RequestInterface;

class PolicyAndPrivacyController extends ResourceController
{
    public function index()
    {
        $model = new PolicyAndPrivacy();
        $data = $model->orderBy('pap_id', 'DESC')->findAll();

        if(count($data) > 0){
            return $this->respond($data);
        }else{
            return $this->failNotFound('Tidak ada data');
        }
    }

    public function show($id = null)
    {
        $model = new PolicyAndPrivacy();

        if($model->find($id)){
            $data = $model->where('pap_id', $id)->first();
            return $this->respond($data);
        }else{
            return $this->failNotFound('Data tidak ditemukan');
        }
    }

    public function create()
    {
        $model = new PolicyAndPrivacy();

        $rules = [
            'value' => 'required|min_length[8]',
        ];

        $messages = [
            "value" => [
                "required" => "{field} tidak boleh kosong",
                'min_length' => '{field} minimal 8 karakter'
            ],
        ];

        $response;
        if($this->validate($rules, $messages)) {
            $data = [
              'value' =>  $this->request->getVar('value')
            ];
            $model->insert($data);
            $response = [
                'status'   => 201,
                'success'    => 201,
                'messages' => [
                    'success' => 'Policy and privacy berhasil dibuat'
                ]
            ];
        }else{
            $response = [
                'status'   => 400,
                'error'    => 400,
                'messages' => $this->validator->getErrors(),
            ];
        }


        return $this->respondCreated($response);
    }

    public function update($id = null)
    {
        $model = new PolicyAndPrivacy();

        $rules = [
            'value' => 'required|min_length[8]',
        ];

        $messages = [
            "value" => [
                "required" => "{field} tidak boleh kosong",
                'min_length' => '{field} minimal 8 karakter'
            ],
        ];

        $response;
        if($model->find($id)){
            if($this->validate($rules, $messages)) {
                $data = [
                  'value' => $this->request->getRawInput('value')
                ];

                $model->update($id, $data);
                $response = [
                    'status'   => 201,
                    'success'    => 201,
                    'messages' => [
                        'success' => 'Policy and privacy berhasil di perbarui'
                    ]
                ];
            }else{
                $response = [
                    'status'   => 400,
                    'error'    => 400,
                    'messages' => $this->validator->getErrors(),
                ];
            }
        }else{
            $response = [
                'status'   => 400,
                'error'    => 400,
                'messages' => 'Data tidak ditemukan',
            ];
        }


        return $this->respond($response);
    }

    public function delete($id = null)
    {
        $model = new PolicyAndPrivacy();

        if($model->find($id)){
            $model->delete($id);
            $response = [
                'status'   => 200,
                'success'    => 200,
                'messages' => [
                    'success' => 'Policy and privacy berhasil di hapus'
                ]
            ];
            return $this->respondDeleted($response);
        }else{
            return $this->failNotFound('Data tidak di temukan');
        }
    }
}
