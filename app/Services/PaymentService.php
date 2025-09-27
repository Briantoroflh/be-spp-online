<?php

namespace App\Services;

use App\Repositories\PaymentRepository;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Midtrans\Snap;

class PaymentService {

    private $paymentRepository;

    public function __construct(
        PaymentRepository $paymentRepository
    )
    {
        $this->paymentRepository = $paymentRepository;

        \Midtrans\Config::$serverKey = config('app.midtrans_key');
        \Midtrans\Config::$isProduction = config('app.midtrans_prod');
        \Midtrans\Config::$isSanitized = config('app.midtrans_sanitized');
        \Midtrans\Config::$is3ds = config('app.midtrans_3ds');
    }

    public function getByUuid(string $uuid) {
        return $this->paymentRepository->getByUuid($uuid);
    }

    public function createTransaksi(array $data) {

        $dateFormat = now()->format('YmdH');

        try{
            DB::beginTransaction();

            $payment = $this->paymentRepository->create([
                'code_payment' => "SPP-" . $dateFormat . rand(1000, 9999),
                'current_bill_uuid' => $data['current_bill_uuid'],
                'user_uuid' => Auth::user()->uuid,
                'nominal_payment' => $data['nominal_payment'],
                'payment_date' => now(),
                'status' => 'pending'
            ]);

            $transaction_details = array(
                'order_id' => $payment->code_payment,
                'gross_amount' => $payment->nominal_payment,
            );

            $customer_details = array(
                'first_name'    => $data['student_name'],
                'last_name'     => "",
                'email'         => Auth::user()->email,
                'phone'         => ""
            );

            $transaction = array(
                'transaction_details' => $transaction_details,
                'customer_details' => $customer_details
            );

            $snapUrl = Snap::getSnapUrl($transaction);
            
            DB::commit();

            return [
                'snap' => $snapUrl
            ];
        }catch(Exception $err) {
            DB::rollBack();

            return [
                'errors' => $err->getMessage()
            ];
        }
        
    }
}