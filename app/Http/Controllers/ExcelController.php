<?php

namespace App\Http\Controllers;

use App\Exports\InvoiceExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExcelController extends Controller
{
    public function exportAllInvoice()
    {
        return Excel::download(new InvoiceExport, 'invoices.xlsx');
    }

    public function exportInvoiceInMonth(int $month)
    {
        return (new InvoiceExport)->month($month)->download("invoices-$month.xlsx");
    }
}
