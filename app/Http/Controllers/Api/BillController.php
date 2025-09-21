<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiRes;
use App\Http\Controllers\Controller;
use App\Http\Requests\BillReq;
use App\Http\Resources\BillRes;
use App\Models\Bill;
use App\Services\StudentService;
use Exception;
use Illuminate\Http\Request;

class BillController extends Controller
{
    private $studentService;

    public function __construct(
        StudentService $studentService
    )
    {
        $this->studentService = $studentService;
    }

    public function getAllByStudentUuid(string $studentUuid) {
        
    }
}
