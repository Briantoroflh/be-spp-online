<?php

namespace App\Http\Controllers;

use App\Helpers\ApiRes;
use App\Services\BillService;
use Illuminate\Http\Request;

class BillController extends Controller
{
    private $billService;

    public function __construct(BillService $billService)
    {
        $this->billService = $billService;
    }

    public function index(Request $request)
    {
        $fields = $request->query('fields', ['*']);

        $bill =  $this->billService->getAll((array) $fields);

        return ApiRes::successResponse("Data bill berhasil diambil!", $bill);
    }

    public function show(string $uuid)
    {
        $bill = $this->billService->getByUuid($uuid);

        return ApiRes::successResponse("Bill ditemukan!", $bill);
    }

    public function getByStudent(string $studentUuid)
    {
        $billStudent = $this->billService->getAllByStudentUuid($studentUuid);

        return ApiRes::successResponse("Bill student ditemukan!", $billStudent);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_uuid' => 'required|string',
            'detail_bill_uuid' => 'required|string',
            'year' => 'required|numeric',
        ]);

        $data = $this->billService->create($validated);
        return ApiRes::successResponse("Bill telah ditambahkan!", $data);
    }

    public function update(Request $request, string $uuid)
    {
        $validated = $request->validate([
            'student_uuid' => 'required|string',
            'detail_bill_uuid' => 'required|string',
            'year' => 'required|numeric',
        ]);

        $billUuid = $this->billService->getByUuid($uuid);

        $data = $this->billService->update($billUuid->uuid, $validated);
        return ApiRes::successResponse("Bill telah diubah!", $data);
    }

    public function destroy($uuid)
    {
        $bill = $this->billService->delete($uuid);
        return ApiRes::successResponse("Bill telah dihapus!");
    }
}
