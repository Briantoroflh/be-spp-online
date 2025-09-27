<?php

namespace Database\Seeders;

use App\Models\Bill;
use App\Models\CurrentBill;
use App\Models\DetailBill;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $student = Student::inRandomOrder()->first();

        $detailBill = DetailBill::create([
            'nominal_bill' => 250000,
            'tax_bill' => 10000,
            'start_at' => now()
        ]);

        Bill::create([
            'student_uuid' => $student->uuid,
            'detail_bill_uuid' => $detailBill->uuid,
            'year' => 2025,
        ]);

        // for ($month = 1; $month <= 12; $month++) {
        //     $startDate = Carbon::create($bill->year, $month, 1);
        //     $dueDate   = $startDate->copy()->addDays(30); // contoh jatuh tempo 10 hari

        //     CurrentBill::create([
        //         'bill_uuid'   => $bill->uuid,
        //         'month'       => $startDate->format('F'), // "January", "February", dst
        //         'start_date'  => $startDate,
        //         'due_date'    => $dueDate,
        //         'status'      => 'unpaid',
        //     ]);
        // }
    }
}
