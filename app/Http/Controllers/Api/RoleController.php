<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiRes;
use App\Http\Controllers\Controller;
use App\Http\Requests\role\RoleReq;
use App\Http\Resources\RoleRes;
use App\Models\Role;
use Exception;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index() {
        $role = Role::all();

        if($role->count() < 1){
            return ApiRes::errorResponse("Data student belum ada!", null, 404);
        }

        return ApiRes::successResponse("Data role berhasil di ambil!", RoleRes::collection($role));
    }

    public function show($uuid) {
        $role = Role::where('uuid', $uuid)->first();

        if(!$role) {
            return ApiRes::errorResponse("Role dengan uuid {$uuid} tidak ditemukan!", null, 404);
        }

        return ApiRes::successResponse("Data role ditemukan!", new RoleRes($role));
    }

    public function store(RoleReq $req) {
        $validated = $req->validated();

        try{
            $role = new Role();
            $role->fill($validated);
            $role->save();
        }catch(Exception $err){
            return ApiRes::errorResponse($err->getMessage(), null, 500);
        }

        return ApiRes::successResponse("Role berhasil dibuat!");
    }

    public function update(RoleReq $req, $uuid) {
        $validated = $req->validated();

        $role = Role::where('uuid', $uuid)->first();

        try{
            $role->update($validated);
        }catch(Exception $err) {
            return ApiRes::errorResponse($err->getMessage(), null, 500);
        }

        return ApiRes::successResponse("Role berhasil dibuat!");
    }

    public function destroy($uuid) {
        $role = Role::where('uuid', $uuid)->first();

        try{
            $role->delete();
        }catch(Exception $err){
            return ApiRes::errorResponse($err->getMessage(), null, 500);
        }

        return ApiRes::successResponse("Role berhasil dihapus!");
    }
}
