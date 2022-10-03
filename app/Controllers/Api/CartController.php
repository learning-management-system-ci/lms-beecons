<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\Cart;
use App\Models\Course;
use App\Models\Bundling;
use App\Models\Users;
use Firebase\JWT\JWT;

class CartController extends ResourceController
{
    use ResponseTrait;

    public function index()
    {
        $key = getenv('TOKEN_SECRET');
        $header = $this->request->getServer('HTTP_AUTHORIZATION');
        if (!$header) return $this->failUnauthorized('Akses token diperlukan');
        $token = explode(' ', $header)[1];

        try {
            $decoded = JWT::decode($token, $key, ['HS256']);
            $cart = new Cart;
            $course = new Course;
            $bundling = new Bundling;
            $user = new Users;
            $data = $cart->where('user_id', $decoded->uid)->findAll();

            $temp = 0;

            foreach ($data as $value) {
                $course_data = $course->select('title, price, new_price, thumbnail')->where('course_id', $value['course_id'])->first();
                $bundling_data = $bundling->select('title, price, new_price, thumbnail')->where('bundling_id', $value['bundling_id'])->first();
                $user_data = $user->select('id, email, date_birth, address, phone_number')->where('id', $decoded->uid)->first();

                $items[] = [
                    'cart_id' => $value['cart_id'],
                    'course' => $course_data,
                    'bundling' => $bundling_data,
                    'sub_total' => $value['total']
                ];
                $response = [
                    'user' => $user_data,
                    'item' => $items,
                    'total' => $temp += $value['total']
                ];
            }

            return $this->respond($response);
        } catch (\Throwable $th) {
            return $this->fail('Akses token tidak sesuai');
        }
        return $this->failNotFound('Data user tidak ditemukan');
    }

    public function create($id = null, $type = null)
    {
        $key = getenv('TOKEN_SECRET');
        $header = $this->request->getServer('HTTP_AUTHORIZATION');
        if (!$header) return $this->failUnauthorized('Akses token diperlukan');
        $token = explode(' ', $header)[1];

        try {
            $decoded = JWT::decode($token, $key, ['HS256']);
            $cart = new Cart;

            if ($type == 'course') {
                $course = new Course;
                $modal = $course->where('course_id', $id)->first();
            }

            if ($type == 'bundling') {
                $bundling = new Bundling;
                $modal = $bundling->where('bundling_id', $id)->first();
            }

            $data = [
                'user_id' => $decoded->uid,
                'course_id' => ($type == 'course') ? $id : null,
                'bundling_id' => ($type == 'bundling') ? $id : null,
                'total' => (isset($modal['new_price'])) ? $modal['new_price'] : $modal['price']
            ];

            $cart->save($data);

            $response = [
                'status' => 200,
                'success' => 200,
                'message' => ($type == 'course') ? 'Course berhasil ditambahkan ke keranjang' : 'Bundling berhasil ditambahkan ke keranjang',
                'data' => []
            ];

            return $this->respondCreated($response);
        } catch (\Throwable $th) {
            return $this->fail('Akses token tidak sesuai');
        }
        return $this->failNotFound('Data user tidak ditemukan');
    }

    public function delete($id = null)
    {
        $key = getenv('TOKEN_SECRET');
        $header = $this->request->getServer('HTTP_AUTHORIZATION');
        if (!$header) return $this->failUnauthorized('Akses token diperlukan');
        $token = explode(' ', $header)[1];

        try {
            $decoded = JWT::decode($token, $key, ['HS256']);

            $model = new Cart();

            if ($model->find($id)) {
                $model->delete($id);
                $response = [
                    'status'   => 200,
                    'success'    => 200,
                    'messages' => [
                        'success' => 'Item berhasil di hapus dari keranjang'
                    ]
                ];
            }
            return $this->respondDeleted($response);
        } catch (\Throwable $th) {
            return $this->fail('Akses token tidak sesuai');
        }
        return $this->failNotFound('Data user tidak ditemukan');
    }
}
