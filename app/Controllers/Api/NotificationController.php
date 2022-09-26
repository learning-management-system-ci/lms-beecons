<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\Notification;
use CodeIgniter\HTTP\RequestInterface;

class NotificationController extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index($id = null)
    {
        $model = new Notification();
        $public_notification = $model->where('user_id', null)->findAll();
        $data = [];

        if($model->where('user_id', $id)->findAll() || $public_notification){
            $private_notification = $model->where('user_id', $id)->findAll();
            $data = $private_notification;

            for($i = 0; $i < count($public_notification); $i++){
                array_push($data, $public_notification[$i]);
            }
            rsort($data);

            return $this->respond($data);
        } else{
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
        //
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
        $model = new Notification();

        $rules = [
            'message' => 'required|min_length[8]',
        ];

        $messages = [
            "message" => [
                "required" => "{field} tidak boleh kosong",
                'min_length' => '{field} minimal 8 karakter'
            ],
        ];

        $response;
        if($this->validate($rules, $messages)) {
            if($this->request->getVar('user_id')){
                $data = [
                  'user_id' => $this->request->getVar('user_id'),
                  'message' => $this->request->getVar('message'),
                ];
            }else{
                $data = [
                  'message' => $this->request->getVar('message'),
                ];
            }

            $model->insert($data);

            $response = [
                'status'   => 201,
                'success'    => 201,
                'messages' => [
                    'success' => 'Notification berhasil dibuat'
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
        $model = new Notification();

        $rules = [
            'message' => 'required|min_length[8]',
        ];

        $messages = [
            "message" => [
                "required" => "{field} tidak boleh kosong",
                'min_length' => '{field} minimal 8 karakter'
            ],
        ];

        $response;
        if($model->find($id)){
            if($this->validate($rules, $messages)) {
                if($this->request->getRawInput('user_id')){
                    $data = [
                      'user_id' => $this->request->getRawInput('user_id'),
                      'message' => $this->request->getRawInput('message'),
                    ];
                }else{
                    $data = [
                      'message' => $this->request->getRawInput('message'),
                    ];
                }
                $model->update($id, $data['user_id']);

                $response = [
                    'status'   => 201,
                    'success'    => 201,
                    'messages' => [
                        'success' => 'Notification berhasil di perbarui'
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
        $model = new Notification();

        if($model->find($id)){
            $model->delete($id);

            $response = [
                'status'   => 200,
                'success'    => 200,
                'messages' => [
                    'success' => 'Notification berhasil di hapus'
                ]
            ];
            return $this->respondDeleted($response);
        }else{
            return $this->failNotFound('Data tidak di temukan');
        }
    }
}
