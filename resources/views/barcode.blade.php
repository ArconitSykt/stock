<script src="{{ asset('js/barcode.js') }}" defer></script>
<style>
body {
         padding: 0px;
         margin: 0px;
        /*border: 0px solid #000; */
       }
       .pageBarcode{
        margin: 0;
        padding: 0;
        padding-left: 0mm;

       }
       .stringBarcode{
        /* border: 1px solid #4caf50; */
        padding: 0;
        margin: 0;
        height: 159px;
        padding-bottom: 3mm; /*Вытягиваем по вертикали ЭТИМ ПАРАМЕТРОМ*/
       }
       .cellBarcode{
        display:inline-block; 
        width: 65mm; 
        height: 39.2mm;
        padding: 0;
        margin: 0;
        padding-left: 6px; /*СДВИГАЕМ ВПРАВО-ВЛЕВО ЭТИМ ПАРАМЕТРОМ*/
        /* border: 1px solid #4CAF50; */
        align-content:center; 
        
       }
</style>
<div id="barcode">
<?php
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory; 
    $cell = 0;
    $string = 0;      
?>    

<div class="pageBarcode">
    <div class="stringBarcode">
        <?php foreach ($items as $key => $item):?>
                <div class="cellBarcode">
                    <div style="transform: scale(0.65); text-align: center;">
                        <label style='font-size:15;'><b>Собственность ГАУ РК «РИЦОКО»</b></label><br>
                        <label><?=$item->caption_item?></label>
                        <barcode :value=`<?= $item->reg_num_item ?>` :format="formatCode" :width="width" :height="height" :font="font" :fontSize="fontSize"></barcode>
                    </div>
                </div>
                <?php
                if($cell == 2) {
                    $cell= -1;
                    $string++;
                    if($string == 7) {
                        echo "</div>";
                    }
                    else {
                        echo "</div><div class='stringBarcode'>";
                    }
                }
                if($string == 7) {
                    echo "</div>
                    <div class='pageBarcode'>
                    <div class='stringBarcode'>   
                    ";
                    $string = 0;
                }
            ?>
         
    <?php $cell++; endforeach;?>
    </div>
</div>
<?php
