<?php

namespace App\Exports;

use App\Models\Order;
use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;

class MonthlyReportExport implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return User::all();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Email',
            "Created",
            "Updated"

        ];
    }

    public function map($order): array
    {
        return [
            $order->id,
            $order->name,
            $order->email,
            $order->created_at,
            $order->updated_at
        ];
    }
}
