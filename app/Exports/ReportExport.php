<?php

namespace App\Exports;

use App\Models\CatatanProduct;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ReportExport implements FromView
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function view(): View
    {
        return view('exports.report', [
            'transactions' => $this->data
        ]);
    }
}
