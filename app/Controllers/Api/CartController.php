<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\Cart;
use App\Models\Course;
use App\Models\Bundling;
use App\Models\Users;
use App\Models\UserCourse;
use App\Models\Voucher;
use App\Models\Referral;
use App\Models\ReferralUser;
use Firebase\JWT\JWT;

class CartController extends ResourceController
{
    use ResponseTrait;

    public function index()
    {
        $input = $this->request->getRawInput();
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

            $cart_data = $cart->where('user_id', $decoded->uid)->findAll();
            $user_data = $user->select('id, email, date_birth, address, phone_number')->where('id', $decoded->uid)->first();

            if (count($cart_data) > 0) {
                $temp = 0;

                foreach ($cart_data as $value) {
                    $course_data = $course->select('title, old_price, new_price, thumbnail')->where('course_id', $value['course_id'])->first();
                    $bundling_data = $bundling->select('title, old_price, new_price')->where('bundling_id', $value['bundling_id'])->first();

                    if ($course_data) {
                        $price = (empty($course_data['new_price'])) ? $course_data['old_price'] : $course_data['new_price'];
                    }

                    if ($bundling_data) {
                        $price = (empty($bundling_data['new_price'])) ? $bundling_data['old_price'] : $bundling_data['new_price'];
                    }

                    $items[] = [
                        'cart_id' => $value['cart_id'],
                        'course' => $course_data,
                        'bundling' => $bundling_data,
                        'sub_total' => $price
                    ];

                    $subtotal = (int)$price;
                    $temp += $subtotal;
                }

                if (isset($_GET['c'])) {
                    $data = $_GET['c'];
                } else {
                    $data = null;
                }

                $reedem = $this->reedem($data, $decoded->uid);
                if ($reedem > 0) {
                    $discount = ($reedem / 100) * $temp;
                    $total = $temp - $discount;
                } else {
                    $reedem = 0;
                    $total = $temp;
                }

                $response = [
                    'user' => $user_data,
                    'item' => $items,
                    'coupon' => $reedem,
                    'sub_total' => $temp,
                    'total' => $total
                ];

                return $this->respond($response);
            } else {
                // return $this->failNotFound('Tidak ada data');
                $response = [
                    'user' => $user_data,
                    'item' => [],
                    'coupon' => 0,
                    'sub_total' => 0,
                    'total' => 0
                ];

                return $this->respond($response);
            }
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
        return $this->failNotFound('Data user tidak ditemukan');
    }

    public function create($type = null, $id = null)
    {
        $key = getenv('TOKEN_SECRET');
        $header = $this->request->getServer('HTTP_AUTHORIZATION');
        if (!$header) return $this->failUnauthorized('Akses token diperlukan');
        $token = explode(' ', $header)[1];

        try {
            $decoded = JWT::decode($token, $key, ['HS256']);
            $user = new Users;
            $cart = new Cart;
            $userCourse = new UserCourse;

            // cek role user
            $data = $user->select('role')->where('id', $decoded->uid)->first();
            if ($data['role'] != 'member') {
                return $this->fail('Tidak dapat di akses selain member', 400);
            }

            if ($type == 'course') {
                $check = $cart->where('course_id', $id)->where('user_id', $decoded->uid)->first();
                $check2 = $userCourse->where('user_id', $decoded->uid)->where('course_id', $id)->first();
                $messages = 'course';
            }

            if ($type == 'bundling') {
                $check = $cart->where('bundling_id', $id)->where('user_id', $decoded->uid)->first();
                $messages = 'bundling';
            }

            if ($check2) {
                $response = [
                    'status' => 400,
                    'success' => 400,
                    'message' => $messages . ' sudah dibeli',
                    'data' => []
                ];

                return $this->respondCreated($response);
            }

            if (!$check) {
                $data = [
                    'user_id' => $decoded->uid,
                    'course_id' => ($type == 'course') ? $id : null,
                    'bundling_id' => ($type == 'bundling') ? $id : null,
                ];
                $cart->save($data);
                $response = [
                    'status' => 200,
                    'success' => 200,
                    'message' => $messages . ' berhasil ditambahkan ke keranjang',
                    'data' => []
                ];
            } else {
                $response = [
                    'status' => 400,
                    'success' => 400,
                    'message' => 'item duplikat',
                    'data' => []
                ];
            }

            return $this->respondCreated($response);
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
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
            $user = new Users;

            // cek role user
            $data = $user->select('role')->where('id', $decoded->uid)->first();
            if ($data['role'] != 'member') {
                return $this->fail('Tidak dapat di akses selain member', 400);
            }

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
            return $this->fail($th->getMessage());
        }
        return $this->failNotFound('Data user tidak ditemukan');
    }

    public function reedem($code = null, $id = null)
    {
        $voucher = new Voucher();
        $referral = new Referral();
        $ref_user = new ReferralUser;

        $check_voucher = $voucher->select('discount_price')->where('code', $code)->first();
        $check_referral = $referral->select('discount_price')->where('referral_code', $code)->first();
        $check_ref_user = $ref_user->select('referral_user_id, discount_price, is_active')->where('referral_code', $code)->first();

        if ($check_voucher) {
            $voucher_data = $voucher->where('code', $code)->first();

            if ($voucher_data['quota'] == 0) {
                $response = [
                    'status' => 400,
                    'success' => 400,
                    'message' => 'Kuota Voucher Sudah Habis',
                ];
                return 0 && $response;
            } else {
                if ($voucher_data['start_date'] <= date("Y-m-d") && $voucher_data['due_date'] >= date("Y-m-d")) {
                    return $check_voucher['discount_price'];
                } else {
                    $response = [
                        'status' => 400,
                        'success' => 400,
                        'message' => 'Kuota Voucher Sudah Habis',
                    ];
                    return 0 && $response;
                }
            }
        }

        if ($check_referral) {

            $ref_data = $referral->select('referral_id, user_id, referral_user')->where('referral_code', $code)->first();
            $check = $ref_user->where('user_id', $id)->where('referral_id', $ref_data['referral_id'])->first();

            // tidak bisa menggunakan kode referral milik diri sendiri
            // tidak bisa memakai kode referral orang lain lebih dari 1 kali
            if (($ref_data['user_id'] == $id) || $check) {
                return 0;
            }

            // batas kode referral dapat dipakai orang lain 5 kali
            if ($ref_data['referral_user'] < 5) {
                return $check_referral['discount_price'];
            }
        }
        if ($check_ref_user) {
            if ($check_ref_user['is_active'] == 0) {
                return $check_ref_user['discount_price'];
            } else {
                return 0;
            }
        }
    }
}
