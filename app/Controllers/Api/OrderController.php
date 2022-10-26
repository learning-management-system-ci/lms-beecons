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

    public function index() {
        $key = getenv('TOKEN_SECRET');
        $header = $this->request->getServer('HTTP_AUTHORIZATION');
        if (!$header) return $this->failUnauthorized('Akses token diperlukan');
        $token = explode(' ', $header)[1];
        try {
            $decoded = JWT::decode($token, $key, ['HS256']);
            $user = new Users;
            $order = new Order;
            $orderCourse = new OrderCourse;
            $orderBundling = new OrderBundling;

            // cek role user
            $data = $user->select('role')->where('id', $decoded->uid)->first();
            if($data['role'] != 'admin'){
                return $this->fail('Tidak dapat di akses selain admin', 400);
            }

            $dataOrder = $order->select('users.email, users.fullname, order.order_id, order.transaction_status, order.gross_amount as total_price')->join('users', 'users.id = order.user_id')->findAll();
            $response['order'] = $dataOrder;

            for($i=0; $i<count($dataOrder); $i++) {
                $itemCourse = $orderCourse ->select('course.title, course.new_price')
                                            ->join('course', 'order_course.course_id = course.course_id')
                                            ->where('order_id', $dataOrder[$i]['order_id'])
                                            ->findAll();
                $response['order'][$i]['course-item'] = $itemCourse;

                $itemBundling = $orderBundling  ->select('bundling.title, bundling.new_price')
                                                ->join('bundling', 'order_bundling.bundling_id = bundling.bundling_id')
                                                ->where('order_id', $dataOrder[$i]['order_id'])
                                                ->findAll();
                $response['order'][$i]['bundling-item'] = $itemBundling;
            }
            
            return $this->respond($response);

            if(count($data) > 0){
                return $this->respond($data);
            } else {
                return $this->failNotFound('Tidak ada data');
            }
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
    }

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
            //$userId = 16;

            $getTotalCart = $cart->select('total')->where('user_id', $userId)->findAll();
            if ($getTotalCart == NULL) {
                return $this->fail('Keranjang belanja kosong');
            }
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
            if ($getCourseCart != null) {
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
            if ($getBundlingCart != null) {
                foreach ($getBundlingCart as $value) {
                    $dataOrderBundling[] = [
                        'order_id' => $orderId,
                        'bundling_id' => $value['bundling_id'],
                    ];
                }
                $orderBundling->insertBatch($dataOrderBundling);
            }

            $getCourse = $orderCourse->getData($orderId)->getResultArray();
            $dataCourse = [];
            if ($getCourse != null) {
                foreach ($getCourse as $value) {
                    $dataCourse[] = [
                        'id' => "c".$value['order_course_id'],
                        'name' => $value['title'],
                        'price' => $value['new_price'],
                        'quantity' => 1
                    ];
                }
            }

            $getBundling = $orderBundling->getData($orderId)->getResultArray();
            $dataBundling = [];
            if ($getBundling != null) {
                foreach ($getBundling as $value) {
                    $dataBundling[] = [
                        'id' => "b".$value['order_bundling_id'],
                        'name' => $value['title'],
                        'price' => (isset($value['new_price'])) ? $value['new_price'] : $value['price'],
                        'quantity' => 1
                    ];
                }
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
           //return $this->respond($params);

            $token = \Midtrans\Snap::getSnapToken($params);
            return view ('pages/transaction/snap-pay', ['token' => $token]);

        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
    }

    public function notifHandler() {
        // // Set your Merchant Server Key
        // \Midtrans\Config::$serverKey = 'SB-Mid-server-F7J9pzrwMAM5Af2mTxYpD-kx';
        // // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        // \Midtrans\Config::$isProduction = false;
        // // Set sanitization on (default)
        // \Midtrans\Config::$isSanitized = true;
        // // Set 3DS transaction for credit card to true
        // \Midtrans\Config::$is3ds = true;

        // $notif = new \Midtrans\Notification();
        // //var_dump($notif);
        // $notif = $notif->getResponse();
        // $transaction = $notif->transaction_status;
        // $fraud = $notif->fraud_status;

        // error_log("Order ID $notif->order_id: "."transaction status = $transaction, fraud status = $fraud");

        // if ($transaction == 'capture') {
        //     // For credit card transaction, we need to check whether transaction is challenge by FDS or not
        //     if ($type == 'credit_card') {
        //         if ($fraud == 'challenge') {
        //             // TODO set payment status in merchant's database to 'Challenge by FDS'
        //             // TODO merchant should decide whether this transaction is authorized or not in MAP
        //             echo "Transaction order_id: " . $notif->order_id ." is challenged by FDS";
        //         } else {
        //             // TODO set payment status in merchant's database to 'Success'
        //             echo "Transaction order_id: " . $notif->order_id ." successfully captured using " . $notif->payment_type;
        //         }
        //     }
        // } else if ($transaction == 'settlement') {
        //     $status = 'paid';
        //     // TODO set payment status in merchant's database to 'Settlement'
        //     echo "Transaction order_id: " . $notif->order_id ." successfully transfered using " . $notif->payment_type;
        // } else if ($transaction == 'pending') {
        //     $status = 'pending';
        //     // TODO set payment status in merchant's database to 'Pending'
        //     echo "Waiting customer to finish transaction order_id: " . $notif->order_id . " using " . $notif->payment_type;
        // } else if ($transaction == 'deny') {
        //     $status = 'cancel';
        //     // TODO set payment status in merchant's database to 'Denied'
        //     echo "Payment using " . $type . " for transaction order_id: " . $notif->order_id . " is denied.";
        // } else if ($transaction == 'expire') {
        //     $status = 'cancel';
        //     // TODO set payment status in merchant's database to 'expire'
        //     echo "Payment using " . $type . " for transaction order_id: " . $notif->order_id . " is expired.";
        // } else if ($transaction == 'cancel') {
        //     $status = 'cancel';
        //     // TODO set payment status in merchant's database to 'Denied'
        //     echo "Payment using " . $type . " for transaction order_id: " . $notif->order_id . " is canceled.";
        // }
        

        $order = new Order;
        $id = $this->request->getVar("order_id");
		// $data = [
		// 	"order_id" => $this->request->getVar("order_id"),
		// 	"transaction_status" => $status,
        //     "transaction_id" => $this->request->getVar("transaction_id"),
	    // ];
        // $order->update($id, $data);

        // send receipt payment
        // $getEmail = $order
        //     ->select('users.email')
        //     ->where('order.order_id', $id)
        //     ->join('users', 'order.user_id=users.id')
        //     ->findAll();
        
        $getOrderData = $order
            ->select('*')
            ->where('order.order_id', 1484076229)
            ->join('order_course', 'order.order_id=order_course.order_id')
            ->findAll();
        
        $data = [
            "order_id" => $getOrderData[0]["order_id"],
            "total_price" => $getOrderData[0]["gross_amount"]
        ];
        
        //var_dump($getOrderData);
        //return 0;
       // $subject = 'Pembelian Selesai';
        //$getEmail = $getEmail[0]["email"];
        return view('/html_email/payment_success.html', $data);
        
        //$message = view('/html_email/otp_request.html', $data);
        $email = \Config\Services::email();
        $email->setTo($getEmail);
        $email->setFrom('hendrikusozzie@gmail.com', 'OTP Reset Password');
        $message = 'sddsddd';
        $email->setSubject($subject);
        $email->setMessage($message);
          
        $email->send();
    }
    
    public function send() {
                // send receipt payment
                $order = new Order;
                $user = new Users;
               
    }
}
