<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiRes;
use App\Http\Controllers\Controller;
use App\Http\Requests\DetailBillReq;
use App\Http\Resources\DetailBillRes;
use App\Models\DetailBill;
use Exception;
use Illuminate\Http\Request;

class DetailBillController extends Controller
{
    public function index()
    {
        $detailBill = DetailBill::select(
            'uuid',
            'nominal_bill',
            'start_at',
            'end_at'
        )->get();

        if ($detailBill->count() < 1) {
            return ApiRes::errorResponse("Data detail bill belum ada!", null, 404);
        }

        return ApiRes::successResponse("Data detail bill berhasil diambil!", DetailBillRes::collection($detailBill));
    }

    public function show($uuid)
    {
        $detailBill = DetailBill::where('uuid', $uuid)->first();

        if (!$detailBill) {
            return ApiRes::errorResponse("Detail bill dengan uuid {$uuid} tidak ditemukan!", null, 404);
        }

        return ApiRes::successResponse("Detail Bill ditemukan!", new DetailBillRes($detailBill));
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
