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
            'student_id as student',
            'spp_id as spp',
            'month',
            'year',
            'amount',
            'status'
        )->where('id_bill', $id)->get();

        if(!$bill){
            return ApiRes::error("Bill not yet!", 404);
        }

        return ApiRes::success(BillResource::collection($bill), 'Data retrieved!');
    }

    public function show(string $id) {
        $bill = Bill::findOrFail($id);

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
