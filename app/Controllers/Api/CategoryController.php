<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\Category;
use CodeIgniter\HTTP\RequestInterface;

class CategoryController extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        $model = new Category();
        $data = $model->orderBy('category_id', 'DESC')->findAll();

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
        $model = new Category();

        if($model->find($id)){
            $data = $model->where('category_id', $id)->first();
            return $this->respond($data);
        }else{
            return $this->failNotFound('Tidak ada data');
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
        $model = new Category();

        $rules = [
            'name' => 'required',
        ];

        $messages = [
            "name" => [
                "required" => "{field} tidak boleh kosong",
            ],
        ];

        $response;
        if($this->validate($rules, $messages)) {
            $data = [
              'name' => $this->request->getVar('name'),
            ];

            $model->insert($data);
            $response = [
                'status'   => 201,
                'success'    => 201,
                'messages' => [
                    'success' => 'Kategori berhasil dibuat'
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
        $model = new Category();

        $rules = [
            'name' => 'required',
        ];

        $messages = [
            "name" => [
                "required" => "{field} tidak boleh kosong",
            ],
        ];

        $response;
        if($model->find($id)){
            if($this->validate($rules, $messages)) {
                $data = [
                  'name' => $this->request->getRawInput('name'),
                ];

                $model->update($id, $data['name']);
                $response = [
                    'status'   => 201,
                    'success'    => 201,
                    'messages' => [
                        'success' => 'Kategori berhasil di perbarui'
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


        return $this->respondCreated($response);
    }

    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function delete($id = null)
    {
        $model = new Category();

        if($model->find($id)){
            $model->delete($id);
            $response = [
                'status'   => 200,
                'success'    => 200,
                'messages' => [
                    'success' => 'Kategori berhasil di hapus'
                ]
            ];
            return $this->respondDeleted($response);
        }else{
            return $this->failNotFound('Data tidak di temukan');
        }
    }
}
