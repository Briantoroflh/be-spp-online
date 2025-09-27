<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiRes;
use App\Http\Controllers\Controller;
use App\Services\CurrentBillService;
use App\Services\PaymentService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    private $paymentService;
    private $currService;

    public function __construct(
        PaymentService $paymentService,
        CurrentBillService $currentBillService
    )
    {
        $this->paymentService = $paymentService;
        $this->currService = $currentBillService;
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'current_bill_uuid' => 'required|string',
            'nominal_payment' => 'required|numeric',
            'student_name' => 'required|string',
        ]);

        $currUuid = $this->currService->getByUuid($validated['current_bill_uuid']);

        if(!$currUuid){
            return ApiRes::errorResponse("Tagihan tidak ditemukan!", null, 404);
        }

        $result = $this->paymentService->createTransaksi($validated); 

        return ApiRes::successResponse("Transaksi berhasil dibuat!", $result, 201);
    }
}
