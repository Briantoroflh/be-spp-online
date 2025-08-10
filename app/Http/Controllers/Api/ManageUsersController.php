<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiRes;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterReq;
use App\Http\Resources\UsersResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ManageUsersController extends Controller
{
    public function index() {
        $users = User::all();

        if($users->count() < 1){
            return ApiRes::error('Users not yet!', 404);
        }

        return ApiRes::success(UsersResource::collection($users), 'Data retrieved success!');
    }
    
    public function show(string $id) {
        $users = User::findOrFail($id);

        return ApiRes::success($users, 'Data retrieved success!');
    }

    public function store(RegisterReq $req) {
        $validated = $req->validated();

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        }

        $users = new User();
        $users->fill($validated);
        $users->save();

        return ApiRes::success($users, 'Users success created!');
    }

    public function update(RegisterReq $req, string $id)
    {
        $validated = $req->validated();

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        }

        $users = User::findOrFail($id);
        $users->update($validated);

        return ApiRes::success($users, 'Users success udpate!');
    }

    public function destroy(string $id) {
        $users = User::findOrFail($id);

        $users->delete();
        return ApiRes::success($users, 'Users success deleted!');
    }
}
