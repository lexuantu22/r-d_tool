<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class ExcelController extends Controller
{

    public function showForm()
    {
        return view('import');
    }

    public function generateTestReport(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls|max:2048',
        ]);

        $file = $request->file('file');
        $spreadsheet = IOFactory::load($file->getPathname());
        $sheet = $spreadsheet->getSheet(1);
        $data = $sheet->toArray();

        $reportData = [];

        foreach ($data as $key => $value) {
            if ($key < 4) {
                continue;
            }

            $createDate = $value[10];
            $createBy = $value[9];

            $executeDate = $value[12];
            $executeBy = $value[11];

            $retestDate = $value[14];
            $retestBy = $value[13];

            if ($createDate && $createBy) {
                $this->updateReportData($reportData, $createBy, $createDate, 'created');
            }

            if ($executeDate && $executeBy) {
                $this->updateReportData($reportData, $executeBy, $executeDate, 'executed');
            }

            if ($retestDate && $retestBy) {
                $this->updateReportData($reportData, $retestBy, $retestDate, 'retested');
            }
        }
        return $this->exportToExcel($reportData);
    }

    private function updateReportData(&$reportData, $user, $date, $status)
    {
        if ($user && $date) {
            if (!isset($reportData[$user])) {
                $reportData[$user] = [];
            }

            if (!isset($reportData[$user][$date])) {
                $reportData[$user][$date] = [
                    'date' => $date,
                    'created' => 0,
                    'executed' => 0,
                    'retested' => 0,
                ];
            }
            $reportData[$user][$date][$status]++;
        }
    }

    private function exportToExcel($reportData)
    {
        $spreadsheet = new Spreadsheet();

        // Tạo sheet đầu tiên - Summary
        $summarySheet = $spreadsheet->getActiveSheet();
        $summarySheet->setTitle('Summary');

        // Tiêu đề cột cho Summary
        $headers = ['Name tester', 'Total Created Test Cases', 'Total Executed Test Cases', 'Total Retested', 'Working Days', 'Average Test Cases', 'Average Executed', 'Average Retest'];
        $summarySheet->fromArray($headers, NULL, 'A1');

        // Tô màu nền header
        $headerStyle = [
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'D3D3D3'] // Màu xám nhạt
            ],
            'font' => ['bold' => true],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000']
                ]
            ]
        ];
        $summarySheet->getStyle('A1:H1')->applyFromArray($headerStyle);

        // Điền dữ liệu vào bảng
        $row = 2;
        foreach ($reportData as $user => $dates) {
            $totalCreated = $totalExecuted = $totalRetested = 0;
            $daysWorked = count($dates);

            foreach ($dates as $counts) {
                $totalCreated += $counts['created'];
                $totalExecuted += $counts['executed'];
                $totalRetested += $counts['retested'];
            }

            $summarySheet->setCellValue("A$row", $user);
            $summarySheet->setCellValue("B$row", $totalCreated);
            $summarySheet->setCellValue("C$row", $totalExecuted);
            $summarySheet->setCellValue("D$row", $totalRetested);
            $summarySheet->setCellValue("E$row", $daysWorked);
            $summarySheet->setCellValue("F$row", $daysWorked > 0 ? round($totalCreated / $daysWorked, 2) : 0);
            $summarySheet->setCellValue("G$row", $daysWorked > 0 ? round($totalExecuted / $daysWorked, 2) : 0);
            $summarySheet->setCellValue("H$row", $daysWorked > 0 ? round($totalRetested / $daysWorked, 2) : 0);

            $row++;
        }

        $range = "A1:H" . ($row - 1);
        $borderStyle = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000']
                ]
            ]
        ];
        $summarySheet->getStyle($range)->applyFromArray($borderStyle);

        // Tự động căn chỉnh cột
        foreach (range('A', 'H') as $column) {
            $summarySheet->getColumnDimension($column)->setAutoSize(true);
        }

        // Tạo các sheet riêng cho từng user
        $sheetIndex = 1;
        foreach ($reportData as $user => $dates) {
            $spreadsheet->createSheet();
            $spreadsheet->setActiveSheetIndex($sheetIndex);
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setTitle($user);

            // Header của sheet user
            $sheet->setCellValue('A1', 'Date');
            $sheet->setCellValue('B1', 'Created Test Cases');
            $sheet->setCellValue('C1', 'Executed Test Cases');
            $sheet->setCellValue('D1', 'Retested');

            // Tô màu nền header
            $sheet->getStyle('A1:D1')->applyFromArray($headerStyle);

            $row = 2;
            foreach ($dates as $date => $counts) {
                $sheet->setCellValue("A$row", $counts['date']);
                $sheet->setCellValue("B$row", $counts['created']);
                $sheet->setCellValue("C$row", $counts['executed']);
                $sheet->setCellValue("D$row", $counts['retested']);
                $row++;
            }

            // Kẻ bảng (thêm viền)
            $range = "A1:D" . ($row - 1);
            $sheet->getStyle($range)->applyFromArray($borderStyle);

            // Tự động căn chỉnh cột
            foreach (range('A', 'D') as $column) {
                $sheet->getColumnDimension($column)->setAutoSize(true);
            }

            $sheetIndex++;
        }

        // Xuất file
        $writer = new Xlsx($spreadsheet);
        return response()->stream(function () use ($writer) {
            $writer->save('php://output');
        }, 200, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="FIS_R&D_Report_' . Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d_H-i-s') . '.xlsx"',
        ]);
    }
}
