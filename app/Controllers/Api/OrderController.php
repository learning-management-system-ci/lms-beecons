<?php

namespace App\Controllers\Api;

use CodeIgniter\API\ResponseTrait;
use App\Controllers\BaseController;
use Firebase\JWT\JWT;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderCourse;
use App\Models\OrderBundling;
use App\Models\Users;

class OrderController extends BaseController
{
    use ResponseTrait;

    public function generateSnap() {
        $key = getenv('TOKEN_SECRET');
        $header = $this->request->getServer('HTTP_AUTHORIZATION');
        if (!$header) return $this->failUnauthorized('Akses token diperlukan');
        $token = explode(' ', $header)[1];

        try {
            $decoded = JWT::decode($token, $key, ['HS256']);
            // Set your Merchant Server Key
            \Midtrans\Config::$serverKey = 'SB-Mid-server-F7J9pzrwMAM5Af2mTxYpD-kx';
            // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
            \Midtrans\Config::$isProduction = false;
            // Set sanitization on (default)
            \Midtrans\Config::$isSanitized = true;
            // Set 3DS transaction for credit card to true
            \Midtrans\Config::$is3ds = true;

            $cart = new Cart;
            $order = new Order;
            $orderCourse = new OrderCourse;
            $orderBundling = new OrderBundling;
            $user = new Users;
            $temp = 0;
            $userId = $decoded->uid;
            $getTotalCart = $cart->select('total')->where('user_id', $userId)->findAll();
            $getUser = $user->where('id', $userId)->first();

            $totalPrice = 0;
            foreach ($getTotalCart as $value) {
                $totalPrice = $temp += $value['total'];
            }

            $orderId = rand();
            $dataOrder = [
                'order_id'  => $orderId,
                'user_id' => $userId,
                'gross_amount' => $totalPrice,
            ];
            $order->insert($dataOrder);
            
            $dataOrderCourse=[];
            $getCourseCart = $cart->select('course_id')->where('user_id', $userId)->where('course_id !=',NULL )->findAll();
            if ($getCourseCart == null) {
                return $this->fail('Keranjang belanja kosong');
            } else {
                foreach ($getCourseCart as $value) {
                    $dataOrderCourse[] = [
                        'order_id' => $orderId,
                        'course_id' => $value['course_id'],
                    ];
                }
                $orderCourse->insertBatch($dataOrderCourse);
            }

            $dataOrderBundling=[];
            $getBundlingCart = $cart->select('bundling_id')->where('user_id', $userId)->where('bundling_id !=',NULL )->findAll();
            //var_dump($getBundlingCart);
            foreach ($getBundlingCart as $value) {
                $dataOrderBundling[] = [
                    'order_id' => $orderId,
                    'bundling_id' => $value['bundling_id'],
                ];
            }
            $orderBundling->insertBatch($dataOrderBundling);

            $getCourse = $orderCourse->getData($orderId)->getResultArray();
            foreach ($getCourse as $value) {
                $dataCourse[] = [
                    'id' => "c".$value['order_course_id'],
                    'name' => $value['title'],
                    'price' => $value['new_price'],
                    'quantity' => 1
                ];
            }

            $getBundling = $orderBundling->getData($orderId)->getResultArray();
            foreach ($getBundling as $value) {
                $dataBundling[] = [
                    'id' => "b".$value['order_bundling_id'],
                    'name' => $value['title'],
                    'price' => (isset($value['new_price'])) ? $value['new_price'] : $value['price'],
                    'quantity' => 1
                ];
            }

            $cart->where('user_id', $userId)->delete();

            $transaction = [
                'order_id' => $orderId,
                'gross_amount' => $totalPrice
            ];

            $cust_detail = [
                'email' => $getUser['email'],
                'phone' => $getUser['phone_number']
            ];

            $item = array_merge($dataBundling,$dataCourse);

            $params = [
                'transaction_details' => $transaction,
                'customer_details' => $cust_detail,
                'item_details' => $item
            ];
            return $this->respond($params);

            //$token = \Midtrans\Snap::getSnapToken($params);
            //return view ('pages/transaction/snap-pay', ['token' => $token]);

        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
    }

    public function notifHandler() {
        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = 'SB-Mid-server-F7J9pzrwMAM5Af2mTxYpD-kx';
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = false;
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;

        $notif = new \Midtrans\Notification();
        //var_dump($notif);
        $notif = $notif->getResponse();
        $transaction = $notif->transaction_status;
        $fraud = $notif->fraud_status;

        error_log("Order ID $notif->order_id: "."transaction status = $transaction, fraud status = $fraud");

        if ($transaction == 'capture') {
            // For credit card transaction, we need to check whether transaction is challenge by FDS or not
            if ($type == 'credit_card') {
                if ($fraud == 'challenge') {
                    // TODO set payment status in merchant's database to 'Challenge by FDS'
                    // TODO merchant should decide whether this transaction is authorized or not in MAP
                    echo "Transaction order_id: " . $notif->order_id ." is challenged by FDS";
                } else {
                    // TODO set payment status in merchant's database to 'Success'
                    echo "Transaction order_id: " . $notif->order_id ." successfully captured using " . $notif->payment_type;
                }
            }
        } else if ($transaction == 'settlement') {
            $status = 'paid';
            // TODO set payment status in merchant's database to 'Settlement'
            echo "Transaction order_id: " . $notif->order_id ." successfully transfered using " . $notif->payment_type;
        } else if ($transaction == 'pending') {
            $status = 'pending';
            // TODO set payment status in merchant's database to 'Pending'
            echo "Waiting customer to finish transaction order_id: " . $notif->order_id . " using " . $notif->payment_type;
        } else if ($transaction == 'deny') {
            $status = 'cancel';
            // TODO set payment status in merchant's database to 'Denied'
            echo "Payment using " . $type . " for transaction order_id: " . $notif->order_id . " is denied.";
        } else if ($transaction == 'expire') {
            $status = 'cancel';
            // TODO set payment status in merchant's database to 'expire'
            echo "Payment using " . $type . " for transaction order_id: " . $notif->order_id . " is expired.";
        } else if ($transaction == 'cancel') {
            $status = 'cancel';
            // TODO set payment status in merchant's database to 'Denied'
            echo "Payment using " . $type . " for transaction order_id: " . $notif->order_id . " is canceled.";
        }
        

        $order = new Order;
        $id = $this->request->getVar("order_id");
		$data = [
			"order_id" => $this->request->getVar("order_id"),
			"transaction_status" => $status,
            "transaction_id" => $this->request->getVar("transaction_id"),
	    ];
        $order->update($id, $data);
    }
		
}
