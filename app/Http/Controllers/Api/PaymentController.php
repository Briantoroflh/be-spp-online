<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiRes;
use App\Http\Controllers\Controller;
use App\Http\Requests\Payment\PaymentReq;
use App\Http\Resources\DetailPaymentResource;
use App\Http\Resources\HistoryPaymentResource;
use App\Http\Resources\PaymentResource;
use App\Models\DetailPayment;
use App\Models\HistoryPayment;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payment = HistoryPayment::all();

        if ($payment->count() < 1) {
            return ApiRes::error("Payment not yet!", 404);
        }

        return ApiRes::success(HistoryPaymentResource::collection($payment), "Data retrieved!");
    }

    public function HistoryPaymentByStudent(string $idStudent)
    {
        $history = HistoryPayment::join('detail_payments', 'history_payments.detail_payment_id', '=', 'detail_payments.id_detail_payment')
            ->join('payments', 'detail_payments.payment_id', '=', 'payments.id_payment')
            ->where('payments.student_id', $idStudent)
            ->select(
                'history_payments.*',
                'detail_payments.amount',
                'payments.date_payment',
                'payments.method_payment'
            )
            ->get();


        if ($history->count() < 1) {
            return ApiRes::error("No transaction yet!", 404);
        }

        return ApiRes::success($history, "Data retrieved!");
    }

    public function show(string $idStudent)
    {
        $detailPayment = Payment::join('detail_payments', 'payments.id_payment', '=', 'detail_payments.payment_id')
            ->join('bills', 'detail_payments.bill_id', '=', 'bills.id_bill')
            ->where('payments.student_id', $idStudent)
            ->select(
                'payments.id_payment',
                'payments.date_payment',
                'payments.method_payment',
                'payments.total_amount',
                'detail_payments.amount as detail_amount',
                'bills.month',
                'bills.year',
                'bills.status'
            )
            ->orderBy('payments.date_payment', 'desc')
            ->get();

        if (!$detailPayment) {
            return ApiRes::error("History transaction not found!", 404);
        }

        return ApiRes::success($detailPayment, "Data retrieved");
    }

    public function store(PaymentReq $req)
    {
        $validated = $req->validated();

        $payment = new Payment();
        $payment->fill($validated);
        $payment->save();

        return ApiRes::success(new PaymentResource($payment), "Payment success!");
    }
}
