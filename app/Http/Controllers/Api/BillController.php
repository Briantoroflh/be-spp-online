<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiRes;
use App\Http\Controllers\Controller;
use App\Http\Requests\Bill\BillReq;
use App\Http\Resources\BillResource;
use App\Models\Bill;
use Illuminate\Http\Request;

class BillController extends Controller
{
    public function index(string $id) {
        $bill = Bill::with(['student','spp'])->select(
            'id_bill',
            'student_id',
            'spp_id',
            'month',
            'year',
            'amount',
            'status'
        )->where('student_id', $id)->get();

        if(!$bill){
            return ApiRes::error("Bill not yet!", 404);
        }

        return ApiRes::success(BillResource::collection($bill), 'Data retrieved!');
    }

    public function show(string $idBill, string $idStudent) {
        $bill = Bill::where('id_bill', $idBill)
                ->where('student_id', $idStudent)
                ->first();

        if(!$bill) {
            return ApiRes::error('Bill not found!', 404);
        }

        return ApiRes::success($bill, 'Data retrieved!');
    }

    public function store(BillReq $req) {
        $validated = $req->validated();

        $bill = new Bill();
        $bill->fill($validated);
        $bill->save();

        return ApiRes::success($bill, 'Bill success created!');
    }

    public function update(BillReq $req, string $id)
    {
        $validated = $req->validated();

        $bill = new Bill();
        $bill->update($validated);

        return ApiRes::success($bill, 'Bill success created!');
    }

    public function destroy(string $id) {
        $bill = Bill::findOrFail($id);

        $bill->delete();
        return ApiRes::success($bill, 'Bill success deleted!');
    }
}
