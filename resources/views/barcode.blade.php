<script src="{{ asset('js/barcode.js') }}" defer></script>
<style>
body {
         padding: 0px 0px 0px 0px;
        margin: 0px 0px 0px 0px;
       }
       .pageBarcode{
        padding: 0px 0px 0px 0px;
        margin: 0px 0px 0px 0px;
       }
       .stringBarcode{
        padding: 0px 0px 0px 0px;
        margin: 0px 0px 0px 0px;
        height: 122px;
        margin-bottom: 16px;
       }
       .cellBarcode{
        padding: 0;
        margin: 0;
        display:inline-block; 
        width: 69mm; 
        height: 122px;
        align-content:center; 
        
       }
</style>
<div id="barcode">
<?php
 
    $cell = 0;
    $string = 0;      
?>    

<div class="pageBarcode">
    <div class="stringBarcode">
        <?php 
        foreach ($items as $key => $item):
            $name = rtrim (mb_substr((string)$item->caption_item,0,30,"UTF-8"));?>
            <div class="cellBarcode">
                <div style="transform: scale(0.65); text-align: center;">
                    <span style='font-size:14;'><b>Собственность ГАУ РК «РИЦОКО»</b></span>
                    <span><?=$name?></span>
                    <barcode :value='<?= $item->reg_num_item ?>' :format="formatCode" :width="width" :height="height" :font="font" :fontSize="fontSize"></barcode>
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
            $cell++; 
        endforeach;?>
    </div>
</div>
