<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiRes;
use App\Http\Controllers\Controller;
use App\Http\Requests\DetailBillReq;
use App\Http\Resources\DetailBillRes;
use App\Models\DetailBill;
use App\Services\DetailBillService;
use Exception;
use Illuminate\Http\Request;

class DetailBillController extends Controller
{
    private $detailBillService;

    public function __construct(
        DetailBillService $detailBillService
    )
    {
        $this->detailBillService = $detailBillService;
    }

    public function index()
    {
        $detailBill = $this->detailBillService->getAll();
        return ApiRes::successResponse("Data detail bill berhasil diambil!", $detailBill);
    }

    public function show($uuid)
    {
       $detailBill = $this->detailBillService->
    }

    public function store(DetailBillReq $req)
    {
        $validated = $req->validated();

        try {
            $detailBill = new DetailBill();
            $detailBill->start_at = now();
            $detailBill->created_at = now();
            $detailBill->fill($validated);
            $detailBill->save();
        } catch (Exception $err) {
            return ApiRes::errorResponse($err->getMessage(), null, 500);
        }

        return ApiRes::successResponse("Detail bill berhasil dibuat!");
    }

    public function update(DetailBillReq $req, $uuid)
    {
        $validated = $req->validated();

        $detailBill = DetailBill::where('uuid', $uuid)->first();

        try {
            $detailBill->updated_at = now();
            $detailBill->update($validated);
        } catch (Exception $err) {
            return ApiRes::errorResponse($err->getMessage(), null, 500);
        }

        return ApiRes::successResponse("Detail bill berhasil diubah!");
    }

    public function destroy($uuid)
    {
        $detailBill = DetailBill::where('uuid', $uuid)->first();

        if (!$detailBill) {
            return ApiRes::errorResponse("Detail bill dengan uuid {$uuid} tidak ditemukan!", null, 404);
        }

        try {
            $detailBill->delete();
        } catch (Exception $err) {
            return ApiRes::errorResponse($err->getMessage(), null, 500);
        }

        return ApiRes::successResponse("Detail bill berhasil dihapus!");
    }
}
