<?php
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Акт приема передачи.xlsx"');
header('Cache-Control: max-age=0');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$inputFileName = 'templates/trans_report.xlsx'; //! Файл-шаблон
$inputFileNameDownload = 'trans_report.xlsx'; //! Файл на скачивание
$spreadsheet = IOFactory::load($inputFileName);

$sheet = $spreadsheet->getSheet(0);
$sheet->setCellValueByColumnAndRow(1, 3, $data->c_org);
$address = "Адрес: ".$data->c_index.", ".$data->c_region.", ".$data->c_street.", тел.: ".$data->c_phone;
$sheet->setCellValueByColumnAndRow(1, 5, $address);
$sheet->setCellValueByColumnAndRow(12, 11, $data->date);
$sheet->setCellValueByColumnAndRow(1, 15, "АКТ от ".$data->date_string);
var_dump($data);

$i = 0;
foreach ($data->items as $key => $value) {
  if($i != 0) {
    $spreadsheet->getActiveSheet()->insertNewRowBefore(23+$i, 1);
  }
  $sheet->setCellValueByColumnAndRow(1, 23+$i, $i+1);
  $sheet->setCellValueByColumnAndRow(2, 23+$i, $key);
  $sheet->setCellValueByColumnAndRow(10, 23+$i, count($value));
  $i++;
}
$sheet->setCellValueByColumnAndRow(6, 37+$i-1, $data->c_org);
$sheet->setCellValueByColumnAndRow(5, 41+$i-1, $data->r_short_name);
$sheet->setCellValueByColumnAndRow(10, 41+$i-1, $data->c_short_name);



$writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
$writer->save($inputFileNameDownload);    
file_force_download($inputFileNameDownload);

function file_force_download($file) {
    if (file_exists($file)) {
      if (ob_get_level()) {
        ob_end_clean();
      }
      readfile($file);
      unlink($file);
      exit;
    }
  }