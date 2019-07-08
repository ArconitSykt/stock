<template>
  <div>
    <v-toolbar flat color="white">
      <template>
        <v-text-field v-model="search" append-icon="search" label="Поиск" clearable single-line></v-text-field>
        <v-spacer></v-spacer>
        <v-btn color="success" dark class="mb-2" @click="dialog = true">
          <v-icon>add</v-icon>Добавить предмет
        </v-btn>
      </template>
      <Item :editedItem="editedItem" :dialog="dialog" :editedIndex="editedIndex"></Item>
      <v-btn color="blue-grey" flat icon @click="getItems">
        <v-icon>refresh</v-icon>
      </v-btn>
    </v-toolbar>

    <v-data-table
      :headers="headers"
      :items="items"
      :search="search"
      class="elevation-1"
      disable-initial-sort
      :loading="loading"
    >
      <template v-slot:items="props">
        <td>{{ props.item.caption_item }}</td>
        <td>{{ props.item.reg_num_item }}</td>
        <td>{{ props.item.ser_num_item }}</td>
        <td>{{ props.item.comment_item }}</td>
        <td>{{ props.item.name_user }}</td>
        <td>{{ props.item.name_status }}</td>
        <td class="justify-center layout px-0">
          <v-icon small class="mr-2" @click="editItem(props.item)">edit</v-icon>
          <v-icon small @click="deleteItem(props.item)">delete</v-icon>
        </td>
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
        <v-icon>close</v-icon>
      </v-btn>
    </v-snackbar>
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
    this.guarantee_date_item = new Date().toISOString().slice(0, 10);
    this.comment_item = null;
    this.current_user_item = 1;
    this.status_item = 1;
    this.depreciation_item = 0;
  }
}
import Item from "./modals/Item";
import ItemsService from "../services/ItemsService";
import ListsService from "../services/ListsService";
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
          value: "caption_item"
        },
        {
          text: "Инвентарный номер",
          value: "reg_num_item"
        },
        {
          text: "Серийный номер",
          value: "ser_num_item"
        },
        {
          text: "Комментарий",
          value: "comment_item"
        },
        {
          text: "Текущий пользователь",
          value: "name_user"
        },
        {
          text: "Статус",
          value: "name_status"
        },
        {
          text: "Действия",
          value: "caption_item",
          sortable: false
        }
      ],
      items: [],
      lists: {}
    };
  },
  computed: {
    formTitle() {
      return this.editedIndex === -1
        ? "Добавить предмет"
        : "Редактировать предмет";
    }
  },

  watch: {
    dialog(val) {
      val || this.close();
    }
  },
  mounted() {
    Event.$on("closeDialog", (item, response) => {
      this.editedIndex = -1;
      this.getItems();
      this.dialog = false;
    });
  },
  created() {
    this.getItems();
  },
  methods: {
    async getItems() {
      this.loading = true;
      let data = await ItemsService.index();
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
    }
  },
  components: {
    Item
  }
};
</script>
<style scoped>
</style>
