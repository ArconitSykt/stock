<template>
  <v-dialog v-model="dialog" fullscreen hide-overlay transition="dialog-bottom-transition">
    <v-card>
      <v-toolbar>
        <v-btn icon @click="close">
          <v-icon>close</v-icon>
        </v-btn>
        <v-toolbar-title>{{ formTitle }}</v-toolbar-title>
        <v-spacer></v-spacer>
        <v-toolbar-items>
          <v-btn class="success" icon @click="save">
            <v-icon>save</v-icon>
          </v-btn>
        </v-toolbar-items>
      </v-toolbar>
      <v-card-title></v-card-title>
      <v-card-text>
        <v-container grid-list-xs>
          <v-layout row wrap>
            <v-flex xs12 sm12 md12 lg12 xl12>
              <v-text-field v-model="item.caption_item" label="Название предмета"></v-text-field>
            </v-flex>
          </v-layout>
          <v-layout row wrap>
            <v-flex xs12 sm12 md12 lg12 xl12>
              <v-text-field v-model="item.comment_item" label="Пояснение"></v-text-field>
            </v-flex>
          </v-layout>
          <v-layout row wrap>
            <v-flex xs12 sm12 md6 lg6 xl6>
              <v-text-field v-model="item.reg_num_item" label="Инвентаризационный номер"></v-text-field>
            </v-flex>
            <v-flex xs12 sm12 md6 lg6 xl6>
              <v-text-field v-model="item.ser_num_item" label="Серийный номер"></v-text-field>
            </v-flex>
          </v-layout>
          <v-layout row wrap v-if="editedIndex === -1">
            <v-flex xs12 sm12 md6 lg6 xl6>
              <v-menu>
                <template v-slot:activator="{ on }">
                  <v-text-field
                    v-model="item.buy_date_item"
                    label="Дата приобретения"
                    readonly
                    clearable
                    v-on="on"
                  ></v-text-field>
                </template>
                <v-date-picker v-model="item.buy_date_item" locale="ru" :first-day-of-week="1"></v-date-picker>
              </v-menu>
            </v-flex>
            <v-flex xs12 sm12 md6 lg6 xl6>
              <v-menu>
                <template v-slot:activator="{ on }">
                  <v-text-field
                    v-model="item.guarantee_date_item"
                    label="Дата гарантии"
                    readonly
                    clearable
                    v-on="on"
                  ></v-text-field>
                </template>
                <v-date-picker
                  v-model="item.guarantee_date_item"
                  locale="ru"
                  :first-day-of-week="1"
                ></v-date-picker>
              </v-menu>
            </v-flex>
          </v-layout>
          <v-layout row wrap>
            <v-flex xs12 sm12 md6 lg6 xl6>
              <v-select
                :items="lists.users"
                v-model="item.current_user_item"
                item-text="name_user"
                item-value="id_user"
                label="Текущий пользователь"
              ></v-select>
              <v-switch
                v-model="item.depreciation_item"
                color="error"
                :label="`Списание предмета: ${(item.depreciation_item ==true)?'Да':'Нет'}`"
              ></v-switch>
            </v-flex>
            <v-flex xs12 sm12 md6 lg6 xl6>
              <v-select
                :items="lists.list_status_item"
                v-model="item.status_item"
                item-text="name_status"
                item-value="id_status"
                label="Статус"
              ></v-select>
              <v-select
                :items="lists.list_accounting_method"
                v-model="item.accounting_item"
                item-text="name_method"
                item-value="id_method"
                label="Метод учёта"
              ></v-select>
            </v-flex>
          </v-layout>
          <v-layout row wrap>
            <v-flex xs12 sm12 md12 lg12 xl12>
              <v-text-field label="Основание перемещения" v-model="item.reason_for_move"></v-text-field>
            </v-flex>
          </v-layout>
          <v-layout row wrap>
            <v-flex xs12 sm12 md12 lg12 xl12>
              <v-text-field v-model="item.num_agrement_item" label="№ договора"></v-text-field>
            </v-flex>
          </v-layout>
          <v-layout row wrap>
            <v-flex xs12 sm12 md12 lg12 xl12>
              <v-menu>
                <template v-slot:activator="{ on }">
                  <v-text-field
                    v-model="item.date_agrement_item"
                    label="Дата договора"
                    readonly
                    clearable
                    v-on="on"
                  ></v-text-field>
                </template>
                <v-date-picker v-model="item.date_agrement_item" locale="ru" :first-day-of-week="1"></v-date-picker>
              </v-menu>
            </v-flex>
          </v-layout>
          <v-layout row wrap>
            <v-flex xs12 sm12 md12 lg12 xl12>
              <v-text-field v-model="item.notation_item" label="Примечание"></v-text-field>
            </v-flex>
          </v-layout>
        </v-container>
      </v-card-text>
    </v-card>
  </v-dialog>
</template>
<script>
class DefaultItem {
  constructor() {
    this.caption_item = null;
    this.reg_num_item = null;
    this.ser_num_item = "";
    this.num_agrement_item = "";
    this.date_agrement_item = null;
    this.notation_item = null;
    this.accounting_item = 1;
    this.buy_date_item = new Date().toISOString().slice(0, 10);
    this.guarantee_date_item = new Date().toISOString().slice(0, 10);
    this.comment_item = null;
    this.current_user_item = 1;
    this.status_item = 1;
    this.depreciation_item = 0;
  }
}
import ItemsService from "../../services/ItemsService";
import ListsService from "../../services/ListsService";
import { get } from "http";

export default {
  props: {
    editedItem: Object,
    dialog: Boolean,
    editedIndex: { type: Number, default: -1 }
  },
  data() {
    return {
      lists: {}
    };
  },
  methods: {
    async saveItem() {
      try {
        if (this.editedIndex === -1) {
          await ItemsService.create(this.editedItem);
        } else {
          await ItemsService.update(this.editedItem);
        }
      } catch (error) {}
    },
    close() {
      Event.$emit("closeDialog", 0);
      setTimeout(() => {
        this.item = new DefaultItem();
      }, 300);
    },
    save() {
      this.saveItem();
      this.close();
    },
    async getList(name) {
      let data = await ListsService.list(name);
      this.lists[name] = data.data;
    }
  },
  mounted() {
    this.getList("list_status_item");
    this.getList("list_accounting_method");
    this.getList("users");
  },
  computed: {
    formTitle() {
      return this.editedIndex === -1
        ? "Добавить предмет"
        : "Редактировать предмет";
    },
    item: {
      get: function() {
        return this.editedItem;
      },
      set: function() {}
    }
  }
};
</script>