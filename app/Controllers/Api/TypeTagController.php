<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\Type;
use App\Models\TypeTag;
use CodeIgniter\HTTP\RequestInterface;

class TypeTagController extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        $modelType = new Type();
        $model = new TypeTag();

        $data = $modelType->findAll();
        
        for($i = 0; $i < count($data); $i++){
            $tag = $model
                ->select('tag.*')
                ->join('type', 'type.type_id = type_tag.type_id')
                ->join('tag', 'tag.tag_id = type_tag.tag_id')
                ->where('type.type_id', $data[$i]['type_id'])
                ->findAll();

            for($k = 0; $k < count($tag); $k++){
                $data[$i]['tag'][$k] = $tag[$k];
            }
        }

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
        //
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
        //
    }

    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function delete($id = null)
    {
        //
    }

    public function filter($key = null, $id = null)
    {
        $key_ = ['type', 'tag'];
        
        if(!in_array($key, $key_)){
            return $this->failValidationError('Key harus type atau tag');
        }
        $data = [];

        $modelType = new Type();
        $model = new TypeTag();

        if($key == 'type'){
            $key = $key.'.'.$key.'_id';
            $data = $modelType->where($key, $id)->find();
        }else{
            $data = $modelType->findAll();
        }
        
        for($i = 0; $i < count($data); $i++){
            // $key = $key.'.'.$key.'_id';
            $tag = $model
                ->select('tag.*')
                ->join('type', 'type.type_id = type_tag.type_id')
                ->join('tag', 'tag.tag_id = type_tag.tag_id')
                ->where('type.type_id', $data[$i]['type_id'])
                // ->where($key, $id)
                ->findAll();

            for($k = 0; $k < count($tag); $k++){
                $data[$i]['tag'][$k] = $tag[$k];
            }
        }

        if(count($data) > 0){
            return $this->respond($data);
        }else{
            return $this->failNotFound('Tidak ada data');
        }
    }
}
