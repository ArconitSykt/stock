<?php
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Индивидуальная карточка '.$user[0]->name_user.'".xlsx"');
header('Cache-Control: max-age=0');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$inputFileName = 'templates/material_card.xlsx'; //! Файл-шаблон
$inputFileNameDownload = 'material_card.xlsx'; //! Файл на скачивание
$spreadsheet = IOFactory::load($inputFileName);

$sheet = $spreadsheet->getSheet(0);

$sheet->setCellValueByColumnAndRow(4, 9, $user[0]->name_user);

foreach ($items as $key => $value) {
  if($key != 0) {
    $spreadsheet->getActiveSheet()->insertNewRowBefore(13+$key, 1);
  }
  $sheet->setCellValueByColumnAndRow(1, 13+$key, $key+1);
  $sheet->setCellValueByColumnAndRow(2, 13+$key, $value->buy_date_item);
  $sheet->setCellValueByColumnAndRow(3, 13+$key, $value->reg_num_item);
  $sheet->setCellValueByColumnAndRow(4, 13+$key, $value->ser_num_item);
  $sheet->setCellValueByColumnAndRow(5, 13+$key, $value->caption_item);
  
}
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