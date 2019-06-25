import Vue from 'vue'
import VueBarcode from "vue-barcode";

new Vue({
    el: '#barcode',
    data: {
        message: "hello",
        formatCode: "CODE39",
        width: 1.5,
        height: 80,
        font: 'Times New Roman',
        fontSize: 16,
    },
    components: {
        barcode: VueBarcode
    }
}
)

