<template>
  <barcode
    :value="data"
    format="CODE39"
    width="1.5"
    height="90"
    font="Times New Roman"
    fontSize="16"
  ></barcode>
</template>
<script>
import VueBarcode from "vue-barcode";
export default {
  props: {
    data: String
  },
  components: {
    barcode: VueBarcode
  }
};
</script>

