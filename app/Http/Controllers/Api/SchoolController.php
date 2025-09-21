<?php

namespace App\Http\Controllers;

use App\Helpers\ApiRes;
use App\Services\SchoolService;
use Illuminate\Http\Request;

class SchoolController extends Controller
{
    private $schoolService;

    public function __construct(SchoolService $schoolService)
    {
        $this->schoolService = $schoolService;
    }

    // ================================
    // Super Admin
    // ================================

    public function index(Request $request)
    {
        $fields = ['uuid', 'name', 'region', 'city', 'type_school', 'isVerified'];
        $schools = $this->schoolService->getAll($fields);

        return ApiRes::successResponse("Data berhasil diambil!", $schools);
    }

    public function show(string $uuid)
    {
        $fields = ['uuid', 'name', 'region', 'city', 'type_school', 'isVerified'];
        $school = $this->schoolService->getByUuid($uuid, $fields);

        return ApiRes::successResponse("Data sekolah berhasil diambil!", $school);
    }

    public function filterByRegion(Request $request)
    {
        $region = $request->get('region');
        $fields = ['uuid', 'name', 'region', 'city', 'type_school', 'isVerified'];

        $schools = $this->schoolService->filterByRegionForSuperAdmin($region, $fields);
        return ApiRes::successResponse("Data berdasarkan wilayah berhasil diambil!", $schools);
    }

    public function filterByCity(Request $request)
    {
        $city = $request->get('city');
        $fields = ['uuid', 'name', 'region', 'city', 'type_school', 'isVerified'];

        $schools = $this->schoolService->filterByCityForSuperAdmin($city, $fields);
        return ApiRes::successResponse("Data berdasarkan kota berhasil diambil!", $schools);
    }

    public function filterByTypeSchool(Request $request)
    {
        $typeSchool = $request->get('type_school');
        $fields = ['uuid', 'name', 'region', 'city', 'type_school', 'isVerified'];

        $schools = $this->schoolService->filterByTypeSchoolForSuperAdmin($typeSchool, $fields);
        return ApiRes::successResponse("Data berdasarkan tipe sekolah berhasil diambil!", $schools);
    }

    public function verify(string $uuid)
    {
        $school = $this->schoolService->updateSchoolIsVerified($uuid);
        return ApiRes::successResponse("Sekolah berhasil diverifikasi!🎉🎉", $school);
    }

    // ================================
    // School Admin / User
    // ================================

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'region' => 'required|string',
            'city' => 'required|string',
            'type_school' => 'required|string',
        ]);

        $school = $this->schoolService->create($data);
        return ApiRes::successResponse("Sekolah berhasil didaftarkan!", $school, 201);
    }

    public function update(Request $request, string $uuid)
    {
        $data = $request->validate([
            'name' => 'sometimes|string',
            'region' => 'sometimes|string',
            'city' => 'sometimes|string',
            'type_school' => 'sometimes|string',
            'isVerified' => 'sometimes|boolean',
        ]);

        $school = $this->schoolService->update($uuid, $data);
        return ApiRes::successResponse("Sekolah berhasil diubah!", $school);
    }

    public function destroy(string $uuid)
    {
        $this->schoolService->delete($uuid);
        return ApiRes::successResponse("Sekolah berhasil dihapus!");
    }
}
