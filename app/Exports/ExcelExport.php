<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExcelExport implements FromCollection, WithHeadings
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return collect($this->data); // Dữ liệu cần xuất
    }

    public function headings(): array
    {
        return ['Column 1', 'Column 2', 'Column 3', 'Processed Column']; // Định nghĩa tiêu đề cột
    }
}
