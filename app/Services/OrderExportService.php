<?php

namespace App\Services;

use App\Models\Order;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Illuminate\Support\Collection;
use Barryvdh\DomPDF\Facade\Pdf;
use TCPDF;

class OrderExportService
{


     public function exportToPdf($orders, $fileName = 'orders')
{
    $fileName = $fileName . '_' . now()->format('Y-m-d_H-i-s') . '.pdf';
    $tempPath = storage_path('temp/' . $fileName);

    if (!is_dir(storage_path('temp'))) {
        mkdir(storage_path('temp'), 0755, true);
    }

    $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

    $pdf->setRTL(true);
    $pdf->SetMargins(15, 20, 15);
    $pdf->SetAutoPageBreak(true, 20);
    $pdf->SetFont('dejavusans', '', 11);

    $pdf->AddPage();

    // العنوان
    $pdf->SetFont('', 'B', 20);
    $pdf->SetTextColor(68, 114, 196);
    $pdf->Cell(0, 10, 'تقرير الطلبات', 0, 1, 'C');

    $pdf->SetFont('', '', 10);
    $pdf->SetTextColor(100, 100, 100);
    $pdf->Cell(0, 6, 'تاريخ التقرير: ' . now()->format('Y-m-d H:i'), 0, 1, 'C');

    $pdf->Ln(5);

    $pdf->SetFont('', 'B', 12);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Cell(0, 8, 'عدد الطلبات: ' . $orders->count(), 0, 1, 'R');

    $pdf->Ln(5);

    // جدول ملخص
    if ($orders->isNotEmpty()) {

        $pdf->SetFillColor(68, 114, 196);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->SetFont('', 'B', 11);

        $pdf->Cell(35, 10, 'رقم المرجعية', 1, 0, 'C', 1);
        $pdf->Cell(40, 10, 'المقيم', 1, 0, 'C', 1);
        $pdf->Cell(30, 10, 'الفرع', 1, 0, 'C', 1);
        $pdf->Cell(35, 10, 'التاريخ', 1, 0, 'C', 1);
        $pdf->Cell(25, 10, 'الصور', 1, 1, 'C', 1);

        $pdf->SetFillColor(255, 255, 255);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('', '', 10);

        foreach ($orders as $order) {
            $pdf->Cell(35, 8, $order->order_number, 1, 0, 'C');
            $pdf->Cell(40, 8, $order->resident->name ?? '-', 1, 0, 'C');
            $pdf->Cell(30, 8, $order->branch->name ?? '-', 1, 0, 'C');
            $pdf->Cell(35, 8, optional($order->submitted_at)->format('Y-m-d H:i') ?? '-', 1, 0, 'C');
            $pdf->Cell(25, 8, $order->getMedia('images')->count() . ' صورة', 1, 1, 'C');
        }
    }

    $pdf->AddPage();

    // تفاصيل كاملة
    foreach ($orders as $index => $order) {

        $pdf->SetFont('', 'B', 16);
        $pdf->SetTextColor(68, 114, 196);
        $pdf->MultiCell(0, 10, " الطلب رقم: {$order->order_number}", 0, 'R');

        $pdf->Ln(3);

        $pdf->SetFont('', '', 11);
        $pdf->SetTextColor(0, 0, 0);

        $details = [
            'رقم الطلب' => $order->number ?? '-',
            'المقيم' => $order->resident->name ?? '-',
            'الفرع' => $order->branch->name ?? '-',
            'تاريخ الإرسال' => optional($order->submitted_at)->format('Y-m-d H:i:s') ?? '-',
            'تاريخ الإنشاء' => optional($order->created_at)->format('Y-m-d H:i:s') ?? '-',
        ];

        if ($order->notes) {
            $details['الملاحظات'] = $order->notes;
        }

        foreach ($details as $label => $value) {
            $pdf->SetFillColor(242, 242, 242);
            $pdf->Cell(50, 8, $label, 1, 0, 'R', 1);
            $pdf->Cell(130, 8, $value, 1, 1, 'R');
        }

        $pdf->Ln(5);

       $images = $order->getMedia('images');

if ($images->count() > 0) {

    $pdf->SetFont('', 'B', 14);
    $pdf->SetTextColor(68, 114, 196);
    $pdf->MultiCell(0, 8, 'الصور المرفقة (' . $images->count() . ')', 0, 'R');
    $pdf->Ln(5);

    $imageWidth = 50;
    $imageHeight = 50;
    $margin = 10;
    $imagesPerRow = 3;

    $shiftRight = 60;

    $totalWidth = ($imagesPerRow * $imageWidth) + (($imagesPerRow - 1) * $margin);

    $startX = (($pdf->getPageWidth() - $totalWidth) / 2) + $shiftRight;
    $currentX = $startX;
    $currentY = $pdf->GetY();

    $counter = 0;

    foreach ($images as $media) {

        if (file_exists($media->getPath())) {

            if ($currentY + $imageHeight > ($pdf->getPageHeight() - 20)) {
                $pdf->AddPage();
                $currentY = $pdf->GetY();
                $currentX = $startX;
            }

            $pdf->Image(
                $media->getPath(),
                $currentX,
                $currentY,
                $imageWidth,
                $imageHeight
            );

            $counter++;

            if ($counter % $imagesPerRow == 0) {
                $currentX = $startX;
                $currentY += $imageHeight + 10;
            } else {
                $currentX += $imageWidth + $margin;
            }
        }
    }

    $pdf->SetY($currentY + $imageHeight + 10);

} else {

    $pdf->SetFont('', '', 11);
    $pdf->MultiCell(0, 8, 'لا توجد صور مرفقة', 0, 'R');
}

        if ($index < $orders->count() - 1) {
            $pdf->AddPage();
        }
    }

    $pdf->Output($tempPath, 'F');

    return $tempPath;
}

    /**
     * تصدير إلى Word مع الصور
     */


    public function exportToWord($orders, $fileName = 'orders')
    {
        $phpWord = new PhpWord();

        // تعيين الخطوط العربية
        $phpWord->setDefaultFontName('Arial');
        $phpWord->setDefaultFontSize(11);

        // إضافة قسم
        $section = $phpWord->addSection([
            'marginLeft' => 600,
            'marginRight' => 600,
            'marginTop' => 600,
            'marginBottom' => 600,
        ]);

        // الرأس
        $header = $section->addHeader();
        $header->addText('تقرير الطلبات', [
            'size' => 20,
            'bold' => true,
            'color' => '4472C4',
        ], [
            'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER,
        ]);

        $section->addText(
            'تاريخ التقرير: ' . now()->format('Y-m-d H:i'),
            ['size' => 10, 'color' => '666666'],
            ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]
        );

        $section->addTextBreak(1);

        // ملخص
        $section->addText(
            'عدد الطلبات: ' . $orders->count(),
            ['size' => 12, 'bold' => true],
            ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::RIGHT]
        );

        $section->addTextBreak(1);

        // جدول ملخص الطلبات
        if ($orders->isNotEmpty()) {
            $tableStyle = [
                'borderSize' => 6,
                'borderColor' => 'CCCCCC',
                'cellMargin' => 80,
                'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER,
                'width' => 100 * 50,
            ];

            $headerStyle = [
                'bold' => true,
                'color' => 'FFFFFF',
                'size' => 11,
            ];

            $cellStyle = [
                'valign' => 'center',
            ];

            $headerCellStyle = [
                'bgColor' => '4472C4',
                'valign' => 'center',
            ];

            $table = $section->addTable($tableStyle);

            // رأس الجدول
            $table->addRow(500);
            $table->addCell(2000, $headerCellStyle)->addText('رقم المرجعية', $headerStyle, ['alignment' => 'center']);
            $table->addCell(2500, $headerCellStyle)->addText('المقيم', $headerStyle, ['alignment' => 'center']);
            $table->addCell(2000, $headerCellStyle)->addText('الفرع', $headerStyle, ['alignment' => 'center']);
            $table->addCell(2000, $headerCellStyle)->addText('التاريخ', $headerStyle, ['alignment' => 'center']);
            $table->addCell(1500, $headerCellStyle)->addText('الصور', $headerStyle, ['alignment' => 'center']);

            // البيانات
            foreach ($orders as $order) {
                $table->addRow(400);

                $table->addCell(2000, $cellStyle)->addText(
                    $order->order_number,
                    ['bold' => true, 'size' => 10],
                    ['alignment' => 'center']
                );

                $residentName = $order->resident ? $order->resident->name : '-';
                $table->addCell(2500, $cellStyle)->addText(
                    $residentName,
                    ['size' => 10],
                    ['alignment' => 'center']
                );

                $branchName = $order->branch ? $order->branch->name : '-';
                $table->addCell(2000, $cellStyle)->addText(
                    $branchName,
                    ['size' => 10],
                    ['alignment' => 'center']
                );

                $submittedDate = $order->submitted_at ? $order->submitted_at->format('Y-m-d H:i') : '-';
                $table->addCell(2000, $cellStyle)->addText(
                    $submittedDate,
                    ['size' => 9],
                    ['alignment' => 'center']
                );

                $images = $order->getMedia('images');
                $table->addCell(1500, $cellStyle)->addText(
                    $images->count() . ' صورة',
                    ['size' => 9, 'color' => '666666'],
                    ['alignment' => 'center']
                );
            }
        }

        // صفحة جديدة للتفاصيل
        $section->addPageBreak();
        $section->addTitle('التفاصيل الكاملة للطلبات', 1);
        $section->addTextBreak(1);

        foreach ($orders as $index => $order) {
            // عنوان الطلب
            $section->addText(
                "📋 الطلب رقم: {$order->order_number}",
                ['size' => 16, 'bold' => true, 'color' => '4472C4']
            );

            $section->addTextBreak(1);

            // جدول معلومات الطلب
            $infoTableStyle = [
                'borderSize' => 6,
                'borderColor' => 'DDDDDD',
                'cellMargin' => 80,
            ];

            $infoTable = $section->addTable($infoTableStyle);

            $labelStyle = ['bold' => true, 'size' => 11, 'color' => '333333'];
            $valueStyle = ['size' => 11];
            $labelCellStyle = ['bgColor' => 'F2F2F2', 'valign' => 'center'];
            $valueCellStyle = ['valign' => 'center'];

            // رقم المرجعية
            $infoTable->addRow();
            $infoTable->addCell(3000, $labelCellStyle)->addText('رقم المرجعية', $labelStyle);
            $infoTable->addCell(7000, $valueCellStyle)->addText($order->order_number, $valueStyle);

            // رقم الطلب
            $infoTable->addRow();
            $infoTable->addCell(3000, $labelCellStyle)->addText('رقم الطلب', $labelStyle);
            $orderNumber = $order->number ? $order->number : '-';
            $infoTable->addCell(7000, $valueCellStyle)->addText($orderNumber, $valueStyle);

            // المقيم
            $infoTable->addRow();
            $infoTable->addCell(3000, $labelCellStyle)->addText('المقيم', $labelStyle);
            $residentName = $order->resident ? $order->resident->name : '-';
            $infoTable->addCell(7000, $valueCellStyle)->addText($residentName, $valueStyle);

            // الفرع
            $infoTable->addRow();
            $infoTable->addCell(3000, $labelCellStyle)->addText('الفرع', $labelStyle);
            $branchName = $order->branch ? $order->branch->name : '-';
            $infoTable->addCell(7000, $valueCellStyle)->addText($branchName, $valueStyle);

            // تاريخ الإرسال
            $infoTable->addRow();
            $infoTable->addCell(3000, $labelCellStyle)->addText('تاريخ الإرسال', $labelStyle);
            $submittedAt = $order->submitted_at ? $order->submitted_at->format('Y-m-d H:i:s') : '-';
            $infoTable->addCell(7000, $valueCellStyle)->addText($submittedAt, $valueStyle);

            // تاريخ الإنشاء
            $infoTable->addRow();
            $infoTable->addCell(3000, $labelCellStyle)->addText('تاريخ الإنشاء', $labelStyle);
            $createdAt = $order->created_at ? $order->created_at->format('Y-m-d H:i:s') : '-';
            $infoTable->addCell(7000, $valueCellStyle)->addText($createdAt, $valueStyle);

            // الملاحظات
            if ($order->notes) {
                $infoTable->addRow();
                $infoTable->addCell(3000, $labelCellStyle)->addText('الملاحظات', $labelStyle);
                $infoTable->addCell(7000, $valueCellStyle)->addText($order->notes, $valueStyle);
            }

            $section->addTextBreak(2);

            // الصور
            $images = $order->getMedia('images');
            if ($images->count() > 0) {
                $section->addText(
                    '📸 الصور المرفقة (' . $images->count() . ' صور)',
                    ['size' => 14, 'bold' => true, 'color' => '4472C4']
                );

                $section->addTextBreak(1);

                // عرض الصور في جدول (3 صور في كل صف)
                $imageTableStyle = [
                    'borderSize' => 6,
                    'borderColor' => 'DDDDDD',
                    'cellMargin' => 150,
                    'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER,
                ];

                $imageTable = $section->addTable($imageTableStyle);

                // تقسيم الصور إلى صفوف (3 صور في كل صف)
                $chunks = $images->chunk(3);

                foreach ($chunks as $chunk) {
                    $imageTable->addRow();

                    foreach ($chunk as $media) {
                        $cell = $imageTable->addCell(3300, ['valign' => 'center']);

                        if (file_exists($media->getPath())) {
                            try {
                                // إضافة الصورة
                                $cell->addImage($media->getPath(), [
                                    'width' => 200,
                                    'height' => 200,
                                    'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER,
                                ]);

                                $cell->addTextBreak(1);

                                // اسم الملف
                                $cell->addText(
                                    $media->file_name,
                                    ['size' => 8, 'italic' => true, 'color' => '666666'],
                                    ['alignment' => 'center']
                                );

                                // حجم الملف
                                $fileSize = $media->human_readable_size;
                                $cell->addText(
                                    $fileSize,
                                    ['size' => 7, 'color' => '999999'],
                                    ['alignment' => 'center']
                                );

                            } catch (\Exception $e) {
                                $cell->addText(
                                    '⚠️ خطأ في تحميل الصورة',
                                    ['color' => 'FF0000', 'size' => 9],
                                    ['alignment' => 'center']
                                );
                            }
                        } else {
                            $cell->addText(
                                '❌ الصورة غير موجودة',
                                ['color' => 'FF0000', 'size' => 9],
                                ['alignment' => 'center']
                            );
                        }
                    }

                    // إضافة خلايا فارغة إذا لزم الأمر
                    $remainingCells = 3 - $chunk->count();
                    for ($i = 0; $i < $remainingCells; $i++) {
                        $imageTable->addCell(3300);
                    }
                }

            } else {
                $section->addText(
                    '📸 لا توجد صور مرفقة',
                    ['size' => 11, 'italic' => true, 'color' => '999999']
                );
            }

            // فاصل بين الطلبات
            if ($index < $orders->count() - 1) {
                $section->addPageBreak();
            }
        }

        // Footer
        $footer = $section->addFooter();
        $footer->addPreserveText(
            'صفحة {PAGE} من {NUMPAGES}',
            ['size' => 9, 'color' => '666666'],
            ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]
        );

        // حفظ الملف
        $fileName = $fileName . '_' . now()->format('Y-m-d_H-i-s') . '.docx';
        $tempPath = storage_path('temp/' . $fileName);

        if (!is_dir(storage_path('temp'))) {
            mkdir(storage_path('temp'), 0755, true);
        }

        $writer = IOFactory::createWriter($phpWord, 'Word2007');
        $writer->save($tempPath);

        return $tempPath;
    }

    /**
     * تصدير إلى Excel مع الصور الفعلية
     */
    public function exportToExcel($orders, $fileName = 'orders')
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // تعيين اتجاه RTL
        $sheet->setRightToLeft(true);

        // تعيين العرض
        $sheet->getColumnDimension('A')->setWidth(20);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(25);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(35);
        $sheet->getColumnDimension('F')->setWidth(25);
        $sheet->getColumnDimension('G')->setWidth(15);

        // عنوان التقرير
        $sheet->mergeCells('A1:G1');
        $sheet->setCellValue('A1', 'تقرير الطلبات');
        $sheet->getStyle('A1')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 16,
                'color' => ['rgb' => '4472C4'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);
        $sheet->getRowDimension(1)->setRowHeight(30);

        // التاريخ
        $sheet->mergeCells('A2:G2');
        $sheet->setCellValue('A2', 'تاريخ التقرير: ' . now()->format('Y-m-d H:i'));
        $sheet->getStyle('A2')->applyFromArray([
            'font' => ['size' => 10, 'color' => ['rgb' => '666666']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);

        // الرأس
        $headers = ['رقم المرجعية', 'رقم الطلب', 'المقيم', 'الفرع', 'الملاحظات', 'تاريخ الإرسال', 'عدد الصور'];
        $sheet->fromArray($headers, NULL, 'A4');

        // تنسيق الرأس
        $headerStyle = [
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
                'size' => 12,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '4472C4'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => 'FFFFFF'],
                ],
            ],
        ];

        $sheet->getStyle('A4:G4')->applyFromArray($headerStyle);
        $sheet->getRowDimension(4)->setRowHeight(25);

        // البيانات
        $row = 5;
        foreach ($orders as $order) {
            $sheet->setCellValue('A' . $row, $order->order_number);
            $orderNumber = $order->number ? $order->number : '-';
            $sheet->setCellValue('B' . $row, $orderNumber);
            $residentName = $order->resident ? $order->resident->name : '-';
            $sheet->setCellValue('C' . $row, $residentName);
            $branchName = $order->branch ? $order->branch->name : '-';
            $sheet->setCellValue('D' . $row, $branchName);
            $notes = $order->notes ? substr($order->notes, 0, 100) : '-';
            $sheet->setCellValue('E' . $row, $notes);
            $submittedAt = $order->submitted_at ? $order->submitted_at->format('Y-m-d H:i') : '-';
            $sheet->setCellValue('F' . $row, $submittedAt);
            $sheet->setCellValue('G' . $row, $order->getMedia('images')->count());

            // تنسيق الصفوف
            $cellRange = 'A' . $row . ':G' . $row;
            $sheet->getStyle($cellRange)->applyFromArray([
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['rgb' => 'DDDDDD'],
                    ],
                ],
                'alignment' => [
                    'vertical' => Alignment::VERTICAL_CENTER,
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                ],
            ]);

            $sheet->getRowDimension($row)->setRowHeight(20);

            $row++;
        }

        // إضافة صفحة جديدة للصور
        $imageSheet = $spreadsheet->createSheet();
        $imageSheet->setTitle('صور الطلبات');
        $imageSheet->setRightToLeft(true);

        // عنوان
        $imageSheet->mergeCells('A1:F1');
        $imageSheet->setCellValue('A1', 'صور الطلبات');
        $imageSheet->getStyle('A1')->applyFromArray([
            'font' => ['bold' => true, 'size' => 16, 'color' => ['rgb' => '4472C4']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);
        $imageSheet->getRowDimension(1)->setRowHeight(30);

        $currentRow = 3;

        foreach ($orders as $order) {
            $images = $order->getMedia('images');

            if ($images->count() > 0) {
                // عنوان الطلب
                $imageSheet->mergeCells("A{$currentRow}:F{$currentRow}");
                $residentName = $order->resident ? $order->resident->name : '-';
                $imageSheet->setCellValue("A{$currentRow}", "طلب رقم: {$order->order_number} - {$residentName}");
                $imageSheet->getStyle("A{$currentRow}")->applyFromArray([
                    'font' => ['bold' => true, 'size' => 12, 'color' => ['rgb' => '333333']],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'F2F2F2']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_RIGHT],
                ]);
                $imageSheet->getRowDimension($currentRow)->setRowHeight(25);

                $currentRow++;

                // عرض الصور (3 صور في كل صف)
                $imageChunks = $images->chunk(3);

                foreach ($imageChunks as $chunk) {
                    $col = 0;

                    foreach ($chunk as $media) {
                        if (file_exists($media->getPath())) {
                            try {
                                $drawing = new Drawing();
                                $drawing->setName($media->file_name);
                                $drawing->setDescription($media->file_name);
                                $drawing->setPath($media->getPath());

                                // تحديد الموقع
                                $columnLetter = chr(65 + ($col * 2)); // A, C, E
                                $drawing->setCoordinates($columnLetter . $currentRow);

                                // تحديد الأبعاد
                                $drawing->setHeight(150);
                                $drawing->setWidth(150);

                                $drawing->setWorksheet($imageSheet);

                                // إضافة اسم الملف تحت الصورة
                                $imageSheet->setCellValue($columnLetter . ($currentRow + 8), $media->file_name);
                                $imageSheet->getStyle($columnLetter . ($currentRow + 8))->applyFromArray([
                                    'font' => ['size' => 8, 'italic' => true, 'color' => ['rgb' => '666666']],
                                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                                ]);

                            } catch (\Exception $e) {
                                // في حالة فشل تحميل الصورة
                                $columnLetter = chr(65 + ($col * 2));
                                $imageSheet->setCellValue($columnLetter . $currentRow, '⚠️ خطأ');
                            }
                        }

                        $col++;
                    }

                    // تعيين ارتفاع الصف
                    $imageSheet->getRowDimension($currentRow)->setRowHeight(120);
                    $currentRow += 10; // مسافة بين الصفوف
                }

                $currentRow += 2; // مسافة بين الطلبات
            }
        }

        // تعيين عرض الأعمدة في صفحة الصور
        for ($i = 0; $i < 6; $i++) {
            $imageSheet->getColumnDimension(chr(65 + $i))->setWidth(25);
        }

        // العودة للصفحة الأولى
        $spreadsheet->setActiveSheetIndex(0);

        // إضافة ملخص
        $row += 2;
        $sheet->setCellValue('A' . $row, 'إجمالي الطلبات:');
        $sheet->setCellValue('B' . $row, $orders->count());
        $sheet->getStyle('A' . $row . ':B' . $row)->applyFromArray([
            'font' => ['bold' => true, 'size' => 12],
        ]);

        // حفظ الملف
        $fileName = $fileName . '_' . now()->format('Y-m-d_H-i-s') . '.xlsx';
        $tempPath = storage_path('temp/' . $fileName);

        if (!is_dir(storage_path('temp'))) {
            mkdir(storage_path('temp'), 0755, true);
        }

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save($tempPath);

        return $tempPath;
    }

    /**
     * تحميل الملف كاستجابة
     */
    public function download($filePath, $displayName = null)
    {
        if (!file_exists($filePath)) {
            throw new \Exception('File not found');
        }

        $displayName = $displayName ? $displayName : basename($filePath);

        return response()->download($filePath, $displayName)->deleteFileAfterSend(true);
    }
}
