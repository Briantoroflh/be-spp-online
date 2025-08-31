<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiRes;
use App\Http\Controllers\Controller;
use App\Http\Requests\BillReq;
use App\Http\Resources\BillRes;
use App\Models\Bill;
use Exception;
use Illuminate\Http\Request;

class BillController extends Controller
{
    public function index() {
        $bill = Bill::all();

        if($bill->count() < 1) {
            return ApiRes::errorResponse("Data bill belum ada!", null, 404);
        }

        return ApiRes::successResponse("Data bill berhasil di ambil!", BillRes::collection($bill));
    }

    public function show($uuid){
        $bill = Bill::where('uuid', $uuid)->first();

        if(!$bill){
            return ApiRes::errorResponse("Bill dengan uuid {$uuid} tidak ditemukan!", null, 404);
        }

        return ApiRes::successResponse("Data bill ditemukan!", new BillRes($bill));
    }

    public function store(BillReq $req) {
        $validated = $req->validated();

        try{
            $bill = new Bill();
            $bill->fill($validated);
            $bill->save();
        }catch(Exception $err){
            return ApiRes::errorResponse($err->getMessage(), null, 500);
        }

        return ApiRes::successResponse("Bill berhasil dibuat!");
    }

    public function update(BillReq $req, $uuid){
        $validated = $req->validated();

        $bill = Bill::where('uuid', $uuid)->first();

        try{
            $bill->update($validated);
        }catch(Exception $err){
            return ApiRes::errorResponse($err->getMessage(), null, 500);
        }

        return ApiRes::successResponse("Bill berhasil diubah!");
    }

    public function destroy($uuid) {
        $bill = Bill::where('uuid', $uuid)->first();

        if (!$bill) {
            return ApiRes::errorResponse("Bill dengan uuid {$uuid} tidak ditemukan!", null, 404);
        }

        try{
            $bill->delete();
        }catch(Exception $err){
            return ApiRes::errorResponse($err->getMessage(), null, 500);
        }

        return ApiRes::successResponse("Bill berhasil dihapus!");
    }
}
