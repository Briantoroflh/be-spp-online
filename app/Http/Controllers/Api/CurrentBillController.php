<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiRes;
use App\Http\Controllers\Controller;
use App\Http\Requests\CurrentBillReq;
use App\Http\Resources\CurrentBillRes;
use App\Models\CurrentBill;
use Exception;
use Illuminate\Http\Request;

class CurrentBillController extends Controller
{
    public function index()
    {
        $currentBill = CurrentBill::select(
            'uuid',
            'bill_uuid',
            'month',
            'start_date',
            'due_date',
            'status',
            'description'
        )->get();

        if ($currentBill->count() < 1) {
            return ApiRes::errorResponse("Data current bill belum ada!", null, 404);
        }

        return ApiRes::successResponse("Data current bill berhasil diambil!", CurrentBillRes::collection($currentBill));
    }

    public function show($uuid) {
        $currentBill = CurrentBill::where('uuid', $uuid)->first();

        if(!$currentBill) {
            return ApiRes::errorResponse("Current bill dengan uuid {$uuid} tidak ditemukan!", null, 404);
        }

        return ApiRes::successResponse("Current bill ditemukan!", new CurrentBillRes($currentBill));
    }

    public function getCurrentBillByUuidStudent ($uuid) {
        $student = CurrentBill::join('bills', 'current_bills.bill_uuid' , '=', 'bills.uuid')
                    ->join('students', 'bills.student_uuid', '=', 'students.uuid')
                    ->join('detail_bills', 'bills.detail_bill_uuid', '=', 'detail_bills.uuid')
                    ->select(
                        'current_bills.uuid',
                        'current_bills.month',
                        'bills.year',
                        'students.name',
                        'detail_bills.nominal_bill'
                    )
                    ->where('students.uuid', $uuid)
                    ->first();
        
        if(!$student) {
            return ApiRes::errorResponse("Current bill student dengan uuid {$uuid} tidak ditemukan!", null, 404);
        }

        return ApiRes::successResponse("Current bill student ditemukan!", $student);
    }

    public function store(CurrentBillReq $req) {
        $validated = $req->validated();

        try{
            $currentBill = new CurrentBill();
            $currentBill->start_at = now();
            $currentBill->due_date = now()->addMonth(1);
            $currentBill->fill($validated);
            $currentBill->save();
        }catch(Exception $err) {
            return ApiRes::errorResponse($err->getMessage(), null, 500);
        }

        return ApiRes::successResponse("Current bill berhasil dibuat!");
    }

    public function update(CurrentBillReq $req, $uuid) {
        $validated = $req->validated();

        $currentBill = CurrentBill::where('uuid', $uuid)->first();

        try{
            $currentBill->update($validated);
        }catch(Exception $err) {
            return ApiRes::errorResponse($err->getMessage(), null, 500);
        }

        return ApiRes::successResponse("Current bill berhasil diubah!");
    }

    public function destroy($uuid) {
        $currentBill = CurrentBill::where('uuid', $uuid)->first();

        if (!$currentBill) {
            return ApiRes::errorResponse("Current bill dengan uuid {$uuid} tidak ditemukan!", null, 404);
        }

        try {
            $currentBill->delete();
        } catch (Exception $err) {
            return ApiRes::errorResponse($err->getMessage(), null, 500);
        }

        return ApiRes::successResponse("Current bill berhasil dihapus!");
    }
}
