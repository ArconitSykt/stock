import Vue from 'vue'
import VueBarcode from "vue-barcode";

new Vue({
    el: '#barcode',
    data: {
        formatCode: "CODE39",
        width: 1.2,
        height: 70,
        font: 'Times New Roman',
        fontSize: 14,
    },
    components: {
        barcode: VueBarcode
    }
}
)

