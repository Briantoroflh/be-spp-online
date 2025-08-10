<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiRes;
use App\Http\Controllers\Controller;
use App\Http\Requests\Spp\SppReq;
use App\Http\Resources\SppResource;
use App\Models\Spp;
use Illuminate\Http\Request;

class ManageSppController extends Controller
{
    public function index() {
        $spp = Spp::all();

        if($spp->count() < 1){
            return ApiRes::error("Spp not yet!", 404);
        }

        return ApiRes::success(SppResource::collection($spp), 'Data retrieved success!');
    }

    public function show(string $id) {
        $spp = Spp::findOrFail($id);

        return ApiRes::success($spp, 'Data retrieved success!');
    }

    public function store(SppReq $req) {
        $validated = $req->validated();

        $spp = new Spp();
        $spp->fill($validated);
        $spp->save();

        return ApiRes::success($spp, 'Spp success created!');
    }

    public function update(SppReq $req, string $id)
    {
        $validated = $req->validated();

        $spp = Spp::findOrFail($id);
        $spp->update($validated);

        return ApiRes::success($spp, 'Spp success updated!');
    }

    public function destroy(string $id) {
        $spp = Spp::findOrFail($id);

        $spp->delete();
        return ApiRes::success($spp, 'Spp success deleted!');
    }
}
