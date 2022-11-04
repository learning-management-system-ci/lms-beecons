<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\Referral;
use App\Models\ReferralUser;
use Firebase\JWT\JWT;

class ReferralController extends ResourceController
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
            $referralModel = new Referral();
            $used = new ReferralUser();

            $data = $referralModel->select('referral_id, referral_code, referral_user')->where('user_id', $decoded->uid)->first();
            $refVouchers = $used->where('referral_id', $data['referral_id'])->findAll();

            if ($refVouchers) {
                foreach ($refVouchers as $value) {
                    $refs[] = [
                        'referral_code' => $value['referral_code'],
                    ];
                }
            } else {
                $refs = [];
            }

            $response = [
                'referral_code' => $data['referral_code'],
                'referral_user' => $data['referral_user'],
                'referral_voucher' => $refs,
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


    // create referral code when user registered an account
    // public function create()
    // {
    //     $key = getenv('TOKEN_SECRET');
    //     $header = $this->request->getServer('HTTP_AUTHORIZATION');
    //     if (!$header) return $this->failUnauthorized('Akses token diperlukan');
    //     $token = explode(' ', $header)[1];

    //     try {
    //         $decoded = JWT::decode($token, $key, ['HS256']);
    //         $referral = new Referral();

    //         $check = $referral->where('user_id',  $decoded->uid)->first();

    //         do {
    //             $code = strtoupper(bin2hex(random_bytes(4)));
    //             $code_check = $referral->where('referral_code', $code)->first();
    //         } while ($code_check);

    //         if (!$check) {
    //             $data = [
    //                 'user_id' => $decoded->uid,
    //                 'referral_code' => $code,
    //                 'discount_price' => 15
    //             ];
    //             $referral->save($data);
    //             $response = [
    //                 'status' => 200,
    //                 'success' => 200,
    //                 'message' => 'kode referral berhasil dibuat',
    //                 'data' => []
    //             ];
    //         } else {
    //             $response = [
    //                 'status' => 400,
    //                 'success' => 400,
    //                 'message' => 'kode referral sudah ada',
    //                 'data' => []
    //             ];
    //         }

    //         return $this->respondCreated($response);
    //     } catch (\Throwable $th) {
    //         return $this->fail($th->getMessage());
    //     }
    //     return $this->failNotFound('Data user tidak ditemukan');
    // }
}
