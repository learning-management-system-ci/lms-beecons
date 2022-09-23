<?php

namespace App\Models;

use CodeIgniter\Model;

class CourseBundling extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'course_bundling';
    protected $primaryKey       = 'course_bundling_id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['bundling_id', 'course_id', 'created_at', 'updated_at'];

    function getCourseBundling(){
        $builder = $this->db->table('course_bundling');
        $builder->select('*');
        $query = $builder->get();
        return $query->getResultArray();
	}
    
    // function getBundlingId(){
    //     $builder = $this->db->table('course_bundling');
    //     // $builder->select('bundling_id');
    //     $builder->countAllResults();
    //     $query = $builder->get();
    //     return $query->getResult();
	// }

    function getBundlingId(){
        $builder = $this->db->table('course_bundling');
        // // $builder->select('bundling_id');
        // $builder->countAllResults();
        $query = $builder->get();
        $hasil = $query->getResultArray();

        // foreach ($hasil as $row) {
        //     echo $row->bundling_id; // access attributes
        //     // echo $user->reverseName(); // or methods defined on the 'User' class
        // }
        return $hasil;
	}

    function getDataBundling($data_bundling_id){
        $builder = $this->db->table('bundling');
        $builder->select('*');
        $builder->where('bundling_id', $data_bundling_id);
        $query = $builder->get();
        return $query->getResultArray();
	}

    function getCourseId(){
        $builder = $this->db->table('course');
        $builder->select('course_id');
        $query = $builder->get();
        return $query->getRow();
	}

    function getDataCourse($data_course_id){
        $builder = $this->db->table('course');
        $builder->select('*');
        $builder->where('course_id', $data_course_id);
        $query = $builder->get();
        return $query->getResultArray();
	}

    function getCourse(){
        // $this->db->table('users')->getWhere(['email'=>$email])->getRowArray();
		return $this->db->query('SELECT course_id FROM course_bundling')->getResult();
        // $row = $query->getRowArray();
        // return $this->db->table('course_bundling')
        // ->join('course','course.course_id=course_bundling.course_id', 'inner')
        // ->join('bundling', 'bundling.bundling_id=course_bundling.bundling_id', 'inner')
        // ->get()->getResultArray();
        // $builder = $this->db->table('course_bundling');
        // $builder->join('course','course.course_id=course_bundling.course_id', 'inner');
        // $builder->join('bundling', 'bundling.bundling_id=course_bundling.bundling_id', 'inner');
        // $query = $builder->get();
        // return $query->getResultArray();
        // $query = $builder->getResult();
        // if($query->num_rows() != 0) {
        //     return $query->result_array();
        // }else{
        //     return false;
        // }
	}

    // function getCourse(){
    //     // $this->db->table('users')->getWhere(['email'=>$email])->getRowArray();
	// 	// return $this->db->query('SELECT course_id FROM course_bundling')->getResult();
    //     // $row = $query->getRowArray();
    //     // return $this->db->table('course_bundling')
    //     // ->join('course','course.course_id=course_bundling.course_id', 'inner')
    //     // ->join('bundling', 'bundling.bundling_id=course_bundling.bundling_id', 'inner')
    //     // ->get()->getResultArray();
    //     $builder = $this->db->table('course_bundling');
    //     $builder->join('course','course.course_id=course_bundling.course_id', 'inner');
    //     $builder->join('bundling', 'bundling.bundling_id=course_bundling.bundling_id', 'inner');
    //     $query = $builder->get();
    //     return $query->getResultArray();
    //     // $query = $builder->getResult();
    //     // if($query->num_rows() != 0) {
    //     //     return $query->result_array();
    //     // }else{
    //     //     return false;
    //     // }
	// }

    // function getBundling(){
    //     // $this->db->table('users')->getWhere(['email'=>$email])->getRowArray();
	// 	// return $this->db->query('SELECT bundling_id FROM course_bundling')->getResult();
    //     $builder = $this->db->table('course_bundling');
    //     $builder->select('course.title as title_course, course.description as description_course, course.price as price_course, course.thumbnail, bundling.title as title_bundling, bundling.description as description_bundling, bundling.price as price_bundling');
    //     $builder->join('course','course.course_id=course_bundling.course_id');
    //     $builder->join('bundling', 'bundling.bundling_id=course_bundling.bundling_id');
    //     $query = $builder->get();
    //     return $query->getResultArray();
    //     // $row = $query->getRowArray();
    //     // return $this->db->table('course_bundling')
    //     // ->join('course','course.course_id=course_bundling.course_id', 'inner')
    //     // ->join('bundling', 'bundling.bundling_id=course_bundling.bundling_id', 'inner')
    //     // ->get()->getResultArray();
	// }

    // function getData(){
    //     $builder = $this->db->table('course_bundling');
    //     $builder->select('course.title as title_course, course.description as description_course, course.price as price_course, course.thumbnail, bundling.title as title_bundling, bundling.description as description_bundling, bundling.price as price_bundling');
    //     $builder->join('course','course.course_id=course_bundling.course_id');
    //     $builder->join('bundling', 'bundling.bundling_id=course_bundling.bundling_id');
    //     $query = $builder->get();
    //     return $query->getResultArray();
	// }

    // function getData(){
    //     $builder = $this->db->table('course_bundling');
    //     $builder->select('course.title as title_course, course.description as description_course, course.price as price_course, course.thumbnail');
    //     $builder->join('course','course.course_id=course_bundling.course_id');
    //     // $builder->join('bundling', 'bundling.bundling_id=course_bundling.bundling_id');
    //     $query = $builder->get();
    //     return $query->getResultArray();
	// }

    function getShow($id){
        $builder = $this->db->table('course_bundling');
        $builder->select('course.title as title_course, course.description as description_course, course.price as price_course, course.thumbnail, bundling.title as title_bundling, bundling.description as description_bundling, bundling.price as price_bundling');
        $builder->join('course','course.course_id=course_bundling.course_id');
        $builder->join('bundling', 'bundling.bundling_id=course_bundling.bundling_id');
        $builder->where('course_bundling_id', $id);
        $query = $builder->get();
        return $query->getResultArray();
	}
}
