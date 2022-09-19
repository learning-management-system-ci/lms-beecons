<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\PolicyAndPrivacy;
use CodeIgniter\HTTP\RequestInterface;

class PolicyAndPrivacyController extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format
     *`
     * @return mixed
     */
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

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
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

    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function new()
    {
        //
    }

    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function create()
    {
        $model = new PolicyAndPrivacy();

        $rules = [
            'value' => 'required|min_length[8]',
        ];

        $response;
        if($this->validate($rules)) {
            $data = [
              'value' => $this->request->getVar('value')
            ];

            $model->insert($data);
            $response = [
                'status'   => 201,
                'error'    => null,
                'messages' => [
                    'success' => 'Policy and privacy berhasil ditambahkan'
                ]
            ];
        }else{
            $response = [
                'status'   => 400,
                'error'    => true,
                'messages' => $this->validator->getErrors(),
            ];
        }


        return $this->respondCreated($response);
    }

    /**
     * Return the editable properties of a resource object
     *
     * @return mixed
     */
    public function edit($id = null)
    {
        //
    }

    /**
     * Add or update a model resource, from "posted" properties
     *
     * @return mixed
     */
    public function update($id = null)
    {
        $model = new PolicyAndPrivacy();

        $rules = [
            'value' => 'required|min_length[8]',
        ];

        $messages = [
            "value" => [
                "required" => "Kolom {field} harus di isi"
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
                    'error'    => null,
                    'messages' => [
                        'success' => 'Policy and privacy berhasil di update'
                    ]
                ];
            }else{
                $response = [
                    'status'   => 400,
                    'error'    => true,
                    'messages' => $this->validator->getErrors(),
                ];
            }
        }else{
            $response = [
                'status'   => 400,
                'error'    => true,
                'messages' => 'Data tidak ditemukan',
            ];
        }


        return $this->respond($response);
    }

    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function delete($id = null)
    {
        $model = new PolicyAndPrivacy();

        if($model->find($id)){
            $model->delete($id);
            $response = [
                'status'   => 200,
                'error'    => null,
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
