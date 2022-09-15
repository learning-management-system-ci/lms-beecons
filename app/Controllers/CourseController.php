<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\Course;
use CodeIgniter\HTTP\RequestInterface;

class CourseController extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        $model = new Course();
        $data = $model->orderBy('course_id', 'DESC')->findAll();

        return $this->respondCreated($data);
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($id = null)
    {
        $model = new Course();

        if($model->find($id)){
            $data = $model->where('course_id', $id)->first();
            return $this->respond($data);
        }else{
            return $this->failNotFound('Data not found');
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
        $model = new Course();

        $rules = [
            'title' => 'required|min_length[8]',
            'description' => 'required|min_length[8]',
            'price' => 'required|numeric',
        ];

        $response;
        if($this->validate($rules)) {
            $data = [
              'title' => $this->request->getVar('title'),
              'description' => $this->request->getVar('description'),
              'price' => $this->request->getVar('price')
            ];

            $model->insert($data);
            $response = [
                'status'   => 201,
                'error'    => null,
                'messages' => [
                    'success' => 'Course created successfully'
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
        $model = new Course();

        $rules = [
            'title' => 'required|min_length[8]',
            'description' => 'required|min_length[8]',
            'price' => 'required|numeric',
        ];

        $response;
        if($model->find($id)){
            if($this->validate($rules)) {
                $data = [
                  'title' => $this->request->getRawInput('title'),
                  'description' => $this->request->getRawInput('description'),
                  'price' => $this->request->getRawInput('price')
                ];

                $model->update($id, $data['title']);
                $response = [
                    'status'   => 201,
                    'error'    => null,
                    'messages' => [
                        'success' => 'Course updated successfully'
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
                'messages' => 'Data not found',
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
        $model = new Course();

        if($model->find($id)){
            $model->delete($id);
            $response = [
                'status'   => 200,
                'error'    => null,
                'messages' => [
                    'success' => 'Course successfully deleted'
                ]
            ];
            return $this->respondDeleted($response);
        }else{
            return $this->failNotFound('Data not found');
        }
    }
}
