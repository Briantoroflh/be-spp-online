<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiRes;
use App\Http\Controllers\Controller;
use App\Http\Requests\OfficerReq;
use App\Http\Resources\OfficerRes;
use App\Models\Officer;
use Exception;
use Illuminate\Http\Request;

class OfficerController extends Controller
{
    public function index()
    {
        $officer = Officer::select('username', 'email')->get();

        if ($officer->count() < 1) {
            return ApiRes::errorResponse("Data officer belum ada!", null, 404);
        }

        return ApiRes::successResponse("Data officer berhasil diambil!", OfficerRes::collection($officer));
    }

    public function show($uuid)
    {
        $officer = Officer::where('uuid', $uuid)->first();

        if (!$officer) {
            return ApiRes::errorResponse("Officer dengan uuid {$uuid} tidak ditemukan!", null, 404);
        }

        return ApiRes::successResponse("Data officer ditemukan!", new OfficerRes($officer));
    }

    public function store(OfficerReq $req)
    {
        $validated = $req->validated();

        try {
            $officer = new Officer();
            $officer->fill($validated);
            $officer->save();
        } catch (Exception $err) {
            return ApiRes::errorResponse($err->getMessage(), null, 500);
        }

        return ApiRes::successResponse("Officer berhasil dibuat!");
    }

    public function update(OfficerReq $req, $uuid)
    {
        $validated = $req->validated();

        $officer = Officer::where('uuid', $uuid)->first();

        try {
            $officer->update($validated);
        } catch (Exception $err) {
            return ApiRes::errorResponse($err->getMessage(), null, 500);
        }

        return ApiRes::successResponse("Officer berhasil diubah!");
    }

    public function destroy($uuid)
    {
        $officer = Officer::where('uuid', $uuid)->first();

        if (!$officer) {
            return ApiRes::errorResponse("Officer dengan uuid {$uuid} tidak ditemukan!", null, 404);
        }

        try {
            $officer->delete();
        } catch (Exception $err) {
            return ApiRes::errorResponse($err->getMessage(), null, 500);
        }

        return ApiRes::successResponse("Officer berhasil dihapus!");
    }
}
