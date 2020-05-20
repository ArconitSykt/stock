<template>
  <div>
    <v-layout row wrap>
      <v-flex xs12 mb-2>
        <v-card>
          <v-card-title primary-title>Список предметов на печать</v-card-title>
          <v-toolbar color="white" flat>
            Предметов выбрано: {{selected_items.length}}
            <v-spacer></v-spacer>
            <v-btn color="info" :disabled="selected_items.length === 0" @click="print">
              <v-icon>print</v-icon>Печатать
            </v-btn>

            <v-btn
              @click="selected_items = []"
              :disabled="selected_items.length === 0"
              color="warning"
              icon
            >
              <v-icon>delete</v-icon>
            </v-btn>
          </v-toolbar>
        </v-card>
      </v-flex>
      <v-flex xs12>
        <v-card>
          <v-card-title primary-title>Предметы</v-card-title>
          <v-card-text>
            <v-toolbar color="white" flat>
              <v-text-field v-model="search" label="Поиск" clearable></v-text-field>
              <v-spacer></v-spacer>
              <v-btn color="success" :disabled="selected.length === 0" @click="addToFormItems">
                <v-icon>add</v-icon>Добавить предмет
                <span v-if="selected.length > 1">ы&nbsp;</span> в список на печать
              </v-btn>
            </v-toolbar>
            <v-data-table
              v-model="selected"
              :headers="headers"
              :items="items"
              :search="search"
              item-key="id_item"
              show-select
            ></v-data-table>
          </v-card-text>
        </v-card>
      </v-flex>
    </v-layout>
  </div>
</template>
<script>
import ItemsService from "../services/ItemsService";
import Config from "../includes/Config";

export default {
  data() {
    return {
      items: [],
      search: "",
      selected: [],
      selected_items: [],
      type: null,

      headers: [
        { text: "Наименование", value: "caption_item" },
        { text: "Инвентарный номер", value: "reg_num_item" },
        { text: "Пользователь", value: "name_user" }
      ]
    };
  },
  methods: {
    async getItems() {
      let data = await ItemsService.index();
      this.items = data.data;
    },
    addToFormItems() {
      let arr = [];
      this.selected_items = arr.concat(this.selected_items, this.selected);
      this.selected = [];
      this.type = null;
    },
    print() {
      const vm = this;
      axios
        .post("barcode_pull", { data: this.selected_items })
        .then(response => {
          var url = response.data;
          var newWin = window.open("about:blank", "Print");

          newWin.onload = function() {
            var div = newWin.document.createElement("div"),
              body = newWin.document.body;
            div.innerHTML = url;
            body.insertBefore(div, body.firstChild);
            var script = document.createElement("script");
            script.src = `${Config.getURL()}js/barcode.js`;
            body.insertBefore(script, body.firstChild);
          };
        });
    }
  },
  mounted() {
    this.getItems();
  }
};
</script>