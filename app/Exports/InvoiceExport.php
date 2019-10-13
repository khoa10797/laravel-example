<?php

namespace App\Exports;

use App\Invoice;
use Illuminate\Database\Query\Builder;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class InvoiceExport implements FromCollection, WithHeadings, FromQuery
{
    use Exportable;

    /**
     * @var int
     */
    private $month;

    public function month(int $month)
    {
        $this->month = $month;
        return $this;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Invoice::all();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Mã đơn hàng',
            'Tên khách',
            'Điện thoại',
            'Địa chỉ',
            'Trạng thái',
            'Giá tiền (x1000)',
            'Ngày tạo',
            'Ngày sửa đổi'
        ];
    }

    /**
     * @return Builder
     */
    public function query()
    {
        return Invoice::query()->whereMonth('created_at', '=', $this->month);
    }
}
