<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiRes;
use App\Http\Controllers\Controller;
use App\Http\Requests\Payment\PaymentReq;
use App\Http\Resources\DetailPaymentResource;
use App\Http\Resources\PaymentResource;
use App\Models\DetailPayment;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index() {
        $payment = Payment::all();

        if($payment->count() < 1){
            return ApiRes::error("Payment not yet!", 404);
        }

        return ApiRes::success(PaymentResource::collection($payment), "Data retrieved!");
    }

    public function show(string $id) {
        $detailPayment = DetailPayment::where("payment_id", $id)->first();

        return ApiRes::success(new DetailPaymentResource($detailPayment), "Data retrieved");
    }
    
    public function store(PaymentReq $req) {
        $validated = $req->validated();

        $payment = new Payment();
        $payment->fill($validated);
        $payment->save();

        return ApiRes::success(new PaymentResource($payment), "Payment success!");
    }
}
