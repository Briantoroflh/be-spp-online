<?php

namespace App\Observers;

use App\Models\Bill;
use App\Models\CurrentBill;
use Carbon\Carbon;

class BillObserver
{
    /**
     * Handle the Bill "created" event.
     */
    public function created(Bill $bill): void
    {
        for ($month = 1; $month <= 12; $month++) {
            $startDate = Carbon::create($bill->year, $month, 1);
            $dueDate   = $startDate->copy()->addDays(30); 

            CurrentBill::create([
                'bill_uuid'   => $bill->uuid,
                'month'       => $startDate->format('F'),
                'start_date'  => $startDate,
                'due_date'    => $dueDate,
                'status'      => 'unpaid',
            ]);
        }
    }

    /**
     * Handle the Bill "updated" event.
     */
    public function updated(Bill $bill): void
    {
        //
    }

    /**
     * Handle the Bill "deleted" event.
     */
    public function deleted(Bill $bill): void
    {
        //
    }

    /**
     * Handle the Bill "restored" event.
     */
    public function restored(Bill $bill): void
    {
        //
    }

    /**
     * Handle the Bill "force deleted" event.
     */
    public function forceDeleted(Bill $bill): void
    {
        //
    }
}
