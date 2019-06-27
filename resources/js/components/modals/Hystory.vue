<template>
  <v-dialog v-model="dialog" fullscreen hide-overlay transition="dialog-bottom-transition">
    <v-card>
      <v-toolbar>
        <v-btn icon @click="close">
          <v-icon>close</v-icon>
        </v-btn>
        <v-toolbar-title>История предмета: {{caption_item}}</v-toolbar-title>
      </v-toolbar>
      <table class="table table-bordered">
        <tr>
          <th>Текущий пользователь</th>
          <th>Статус</th>
          <th>Дата переход</th>
          <th>Основание перемещения</th>
        </tr>
        <tr v-for="(item, index) in hystory" :key="index">
          <td>{{item.name_user}}</td>
          <td>{{item.name_status}}</td>
          <td>{{item.date_hystory}}</td>
          <td>{{item.reason_hystory}}</td>
        </tr>
      </table>
    </v-card>
  </v-dialog>
</template>
<script>
import ItemsService from "../../services/ItemsService";

export default {
  props: {
    dialog: Boolean,
    id: Number,
    caption_item: String
  },
  data() {
    return {
      hystory: {}
    };
  },
  methods: {
    async getHystory() {
      let response = await ItemsService.hystory(this.id)
      this.hystory = response.data
    },
    close() {
      Event.$emit("closeDialog", 0);
    }
  },
  mounted() {
    this.getHystory();
  }
};
</script>
<style scoped>
</style>
