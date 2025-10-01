<?php

namespace App\Exports;

use App\Models\front\transactions;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class TransactionExport implements FromCollection, WithMapping, WithHeadings
{
    public $transactions;
    // constract function
    public function __construct($transactions)
    {
        $this->transactions = $transactions;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->transactions;
    }

    /**
     * @var Invoice $invoice
     */
    public function map($transaction): array
    {
        return [
            optional($transaction->stores)->name ?? optional($transaction->stores)->id,
            optional($transaction->providers)->name ?? optional($transaction->providers)->id,
            $transaction->transaction_id,
            $transaction->from,
            $transaction->amount,
            $transaction->sim_number,
            $transaction->username,
            isset(transactions::STATUSES[$transaction->status]) ? transactions::STATUSES[$transaction->status] : $transaction->status,
            $transaction->created_at->format('Y/m/d H:i:m A'),
            $transaction->updated_at->format('Y/m/d H:i:m A'),
        ];
    }

    public function headings(): array
    {
        return [
            'Store',
            'Provider',
            'Transaction Id',
            'From Mobile',
            'Amount',
            'SIM Number',
            'Username',
            'Status',
            'Created At',
            'Updated At',
        ];
    }
}
