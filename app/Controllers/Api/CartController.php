<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\Cart;
use App\Models\Course;
use App\Models\Bundling;
use App\Models\Users;
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

            $temp = 0;

            foreach ($cart_data as $value) {
                $course_data = $course->select('title, old_price, new_price, thumbnail')->where('course_id', $value['course_id'])->first();
                $bundling_data = $bundling->select('title, old_price, new_price')->where('bundling_id', $value['bundling_id'])->first();
                $user_data = $user->select('id, email, date_birth, address, phone_number')->where('id', $decoded->uid)->first();

                $items[] = [
                    'cart_id' => $value['cart_id'],
                    'course' => $course_data,
                    'bundling' => $bundling_data,
                    'sub_total' => $value['total']
                ];

                $subtotal = (int)$value['total'];
                $temp += $subtotal;
            }

            $data = [
                'code' => $input['code'],
            ];

            $reedem = $this->reedem($data['code'], $decoded->uid);
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

            if (count($data) > 0) {
                return $this->respond($response);
            } else {
                return $this->failNotFound('Tidak ada data');
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

            // cek role user
            $data = $user->select('role')->where('id', $decoded->uid)->first();
            if ($data['role'] != 'member') {
                return $this->fail('Tidak dapat di akses selain member', 400);
            }

            $cart = new Cart;

            if ($type == 'course') {
                $course = new Course;
                $modal = $course->where('course_id', $id)->first();
                $check = $cart->where('course_id', $id)->where('user_id', $decoded->uid)->first();
                $messages = 'course';
            }

            if ($type == 'bundling') {
                $bundling = new Bundling;
                $modal = $bundling->where('bundling_id', $id)->first();
                $check = $cart->where('bundling_id', $id)->where('user_id', $decoded->uid)->first();
                $messages = 'bundling';
            }

            if (!$check) {
                $data = [
                    'user_id' => $decoded->uid,
                    'course_id' => ($type == 'course') ? $id : null,
                    'bundling_id' => ($type == 'bundling') ? $id : null,
                    'total' => (isset($modal['new_price'])) ? $modal['new_price'] : $modal['old_price']
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
        $ref_user = new ReferralUser();

        $check_voucher = $voucher->select('discount_price')->where('code', $code)->first();
        $check_referral = $referral->select('discount_price')->where('referral_code', $code)->first();
        $check_ref_user = $ref_user->select('referral_user_id, discount_price')->where('referral_code', $code)->first();

        if ($check_voucher) {
            return $check_voucher['discount_price'];
        }

        if ($check_referral) {

            $ref_data = $referral->select('referral_id, user_id, referral_user')->where('referral_code', $code)->first();
            $check = $ref_user->where('user_id', $id)->where('referral_id', $ref_data['referral_id'])->first();

            if (($ref_data['user_id'] == $id) || $check) {
                return 0;
            }

            if ($ref_data['referral_user'] < 5) {
                $ref_data['referral_user'] += 1;

                do {
                    $ref_code = strtoupper(bin2hex(random_bytes(4)));
                    $check_code = $referral->where('referral_code', $code)->first();
                } while ($check_code);

                $data = [
                    'referral_user' => $ref_data['referral_user'],
                ];

                $ref_used = [
                    'referral_id' => $ref_data['referral_id'],
                    'user_id' => $id,
                    'referral_code' => $ref_code,
                    'discount_price' => 15
                ];

                $referral->update($ref_data['referral_id'], $data);
                $ref_user->save($ref_used);

                return $check_referral['discount_price'];
            }

            if ($check_ref_user) {

                $coupon = $check_ref_user['discount_price'];
                if ($ref_user->find($check_ref_user['referral_user_id'])) {
                    $ref_user->delete($check_ref_user['referral_user_id']);
                }
                return $coupon;
            }

            return 0;
        }
    }
}
