<template>
  <div>
    <v-toolbar flat color="white">
      <template>
        <v-text-field
          v-model="search"
          append-icon="mdi-magnify"
          label="Поиск"
          clearable
          single-line
        ></v-text-field>
        <v-spacer></v-spacer>

        <v-select
          :items="lists['list_year']"
          v-model="current_year"
          item-text="caption_year"
          item-value="value_year"
          label="Выбрать год"
          @change="getItems"
        ></v-select>
        <v-spacer></v-spacer>
        <v-select
          :items="status_item"
          v-model="curent_status"
          item-text="caption"
          item-value="value"
          label="Статус"
          @change="getItems"
        ></v-select>
        <v-spacer></v-spacer>
        <v-btn color="success" dark class="mb-2" @click="dialog = true">
          <v-icon>mdi-plus</v-icon>Добавить предмет
        </v-btn>
      </template>
      <Item :editedItem="editedItem" :dialog="dialog" :editedIndex="editedIndex"></Item>
      <v-btn color="blue-grey" text icon @click="getItems">
        <v-icon>refresh</v-icon>
      </v-btn>
      <v-btn color="indigo" text icon @click="uploadDialog = true">
        <v-icon>import_export</v-icon>
      </v-btn>
    </v-toolbar>

    <v-data-table
      :headers="headers"
      :items="items"
      :search="search"
      class="elevation-1"
      :loading="loading"
      clearable
    >
      <template v-slot:item.actions="{ item }">
        <v-icon small class="mr-2" @click="editItem(item)">mdi-pen</v-icon>
        <v-icon small @click="deleteItem(item)">mdi-delete</v-icon>
      </template>
      <template v-slot:no-results>
        <v-alert
          :value="true"
          color="error"
          icon="warning"
        >Результат вашего запроса: "{{ search }}" не найден :-(</v-alert>
      </template>
    </v-data-table>

    <v-snackbar v-model="snackbar" bottom right :timeout="3000" color="success">
      {{message}}
      <v-btn flat @click="snackbar = false">
        <v-icon>mdi-close</v-icon>
      </v-btn>
    </v-snackbar>
    <UploadImport :dialog="uploadDialog"></UploadImport>
  </div>
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
    this.guarantee_date_item = null;
    this.comment_item = null;
    this.current_user_item = 1;
    this.status_item = 1;
    this.depreciation_item = 0;
  }
}
import Item from "./modals/Item";
import ItemsService from "../services/ItemsService";
import ListsService from "../services/ListsService";
import UploadImport from "./modals/UploadImport";

export default {
  data() {
    return {
      loading: false,
      snackbar: false,
      message: null,
      dialog: false,
      search: "",
      editedIndex: -1,
      editedItem: new DefaultItem(),
      headers: [
        {
          text: "Название предмета",
          align: "left",
          value: "caption_item",
        },
        {
          text: "Инвентарный номер",
          value: "reg_num_item",
        },
        {
          text: "Серийный номер",
          value: "ser_num_item",
        },
        {
          text: "Комментарий",
          value: "comment_item",
        },
        {
          text: "Текущий пользователь",
          value: "name_user",
        },
        {
          text: "Статус",
          value: "name_status",
        },
        {
          text: "Действия",
          value: "actions",
          sortable: false,
        },
      ],
      items: [],
      lists: {},
      current_year: 0,
      curent_status: 1,
      uploadDialog: false,
      status_item: [
        { caption: "Не списанные", value: 1 },
        { caption: "Все", value: 2 },
        { caption: "Списанные", value: 3 },
      ],
    };
  },
  computed: {
    formTitle() {
      return this.editedIndex === -1
        ? "Добавить предмет"
        : "Редактировать предмет";
    },
  },

  watch: {
    dialog(val) {
      val || this.close();
    },
  },
  mounted() {
    Event.$on("closeDialog", (item, response) => {
      this.editedIndex = -1;
      this.getItems();
      this.dialog = false;
      this.uploadDialog = false;
    });
  },
  created() {
    this.getItems();
    this.getList("list_year");
  },
  methods: {
    async getItems() {
      this.loading = true;
      let data = null;
      if (this.current_year == 0) {
        if (this.curent_status == 1) {
          data = await ItemsService.filter(this.curent_status);
        }
        if (this.curent_status == 2) {
          data = await ItemsService.index();
        }
        if (this.curent_status == 3) {
          data = await ItemsService.filter(this.curent_status);
        }
      } else {
        data = await ItemsService.selectYear(this.current_year);
      }
      this.items = data.data;
      this.loading = false;
    },

    editItem(item) {
      this.editedIndex = this.items.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialog = true;
    },

    deleteItem(item) {
      if (confirm(`Удалить ${item.caption_item}?`)) {
        try {
          ItemsService.delete(item);
        } catch (error) {
          this.message = error;
        }
        this.getItems();
      } else {
      }
    },
    close() {
      this.dialog = false;
      setTimeout(() => {
        this.editedItem = new DefaultItem();
        this.editedIndex = -1;
      }, 300);
    },
    async getList(name) {
      let data = await ListsService.list(name);
      this.lists[name] = data.data;
    },
  },
  components: {
    Item,
    UploadImport,
  },
};
</script>
<style scoped>
</style>
