<template>
  <div>
    <v-container grid-list-xs>
      <v-layout row wrap justify-space-between>
        <v-toolbar flat color="white" class="elevation-1">
          <v-text-field
            v-model="search"
            append-icon="search"
            label="Поиск склада"
            single-line
            clearable
          ></v-text-field>
          <v-spacer></v-spacer>
          <v-btn right color="success" @click="userDialog = true">
            <v-icon>add</v-icon>Добавить склад
          </v-btn>
        </v-toolbar>
        <v-flex xs12>
          <v-treeview
            :items="users"
            item-key="id_user"
            item-text="name_user"
            activatable
            active-class="light-green lighten-3"
            :active.sync="active"
            hoverable
            :transition="true"
            :search="search"
          ></v-treeview>
        </v-flex>
      </v-layout>
    </v-container>

    <v-dialog v-model="dialog" fullscreen hide-overlay transition="dialog-bottom-transition">
      <v-toolbar>
        <v-btn icon @click="dialog = false; active = []">
          <v-icon>close</v-icon>
        </v-btn>
        <v-toolbar-title>{{selected.name_user}}</v-toolbar-title>
        <v-spacer></v-spacer>
        <v-toolbar-items>
          <v-btn v-show="selectedItems.length > 0" color="primary" icon @click="openLink(selected.id_user)">
            <v-icon>straighten</v-icon>
          </v-btn>
          <v-btn class="error" icon @click="deleteUser()">
            <v-icon>delete</v-icon>
          </v-btn>
          <v-btn color="warning" icon @click="userDialog = true">
            <v-icon>edit</v-icon>
          </v-btn>
        </v-toolbar-items>
      </v-toolbar>
      <v-card>
        <v-data-table
          :headers="headers"
          :items="selectedItems"
          class="elevation-1"
          disable-initial-sort
        >
          <template v-slot:items="props">
            <td>{{ props.item.caption_item }}</td>
            <td>{{ props.item.reg_num_item }}</td>
            <td>{{ props.item.ser_num_item }}</td>
            <td>{{ props.item.comment_item }}</td>
            <td>{{ props.item.name_status }}</td>
            <td class="justify-center layout px-0">
              <v-icon small class="mr-2" @click="editItem(props.item)">edit</v-icon>
              <v-icon small @click="deleteItem(props.item)">delete</v-icon>
            </td>
          </template>
        </v-data-table>
      </v-card>
    </v-dialog>
    <User :editingUser="selected" :dialog="userDialog"></User>
    <Item :editedItem="editedItem" :dialog="editDialog" :editedIndex="editedItem.id_item"></Item>
  </div>
</template>
<script>
class DefaultUser {
  constructor() {
    name_user: "";
  }
}

import Item from "./modals/Item";
import User from "./modals/User";
import ItemsService from "../services/ItemsService";
import UsersService from "../services/UsersService";
import BarcodeService from "../services/BarcodeService";
import Axios from "axios";

export default {
  data() {
    return {
      search: "",
      dialog: false,
      users: [],
      rawUsers: [],
      active: [],
      editedItem: {},
      editDialog: false,
      userDialog: false,
      barcodeDialog: false,
      selectedItems: [],
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
          text: "Статус",
          value: "name_status"
        },
        {
          text: "Действия",
          value: "caption_item",
          sortable: false
        }
      ]
    };
  },
  methods: {
    async getUsers() {
      let data = await UsersService.index();
      let rawData = await UsersService.raw();
      this.users = data.data;
      this.rawUsers = rawData.data;
    },

    deleteUser() {
      if (confirm(`Удалить ${this.selected.name_user}?`)) {
        try {
          UsersService.delete(this.selected);
          this.dialog = false;
        } catch (error) {
          this.message = error;
        }
      } else {
      }
      this.active = [];
      this.getUsers();
    },

    async getItems() {
      await axios
        .get("items/user/" + this.active[0])
        .then(response => (this.selectedItems = response.data));
    },
    editItem(item) {
      this.editedItem = Object.assign({}, item);
      this.editDialog = true;
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
    openLink(id) {
      window.open('barcode/'+ id);
    }
  },
  computed: {
    selected() {
      if (!this.active.length) return new DefaultUser();
      const id = this.active[0];
      this.dialog = true;
      this.getItems();
      return this.rawUsers.find(user => user.id_user === id);
    }
  },
  components: {
    Item,
    User,
  },
  created() {
    this.getUsers();
  },
  mounted() {
    Event.$on("closeDialog", (item, response) => {
      this.getItems();
      this.getUsers();
      this.editDialog = false;
      this.userDialog = false;
    });
  }
};
</script>
<style scoped>
</style>
