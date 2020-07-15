<template>
  <div>
    <section>
      <v-layout row wrap justify-space-between>
        <v-toolbar flat color="white">
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
          <v-btn icon right @click="getUsers">
            <v-icon>refresh</v-icon>
          </v-btn>
        </v-toolbar>
        <v-flex xs12>
          <v-treeview
            :items="users"
            item-key="id_user"
            item-text="name_user"
            :active.sync="active"
            activatable
            hoverable
            dense
            transition
            :search="search"
          >
            <template v-slot:prepend="{ item, open }">
              <v-icon v-if="!item.type_user">{{ open ? 'mdi-folder-open' : 'mdi-folder' }}</v-icon>
              <!-- <v-icon v-else>{{ type_icon["_"+item.type_user] }}</v-icon> -->

              <v-icon
                v-else
              >{{ open ? type_icon["_"+item.type_user].open: type_icon["_"+item.type_user].close}}</v-icon>
            </template>
          </v-treeview>
        </v-flex>
      </v-layout>
    </section>

    <v-dialog v-model="dialog" fullscreen hide-overlay transition="dialog-bottom-transition">
      <v-toolbar>
        <v-btn icon @click="dialog = false; active = []">
          <v-icon>close</v-icon>
        </v-btn>
        <v-toolbar-title>{{selected.name_user}}</v-toolbar-title>
        <v-spacer></v-spacer>
        <v-toolbar-items>
          <v-btn
            v-show="selectedItems.length > 0"
            color="success"
            icon
            @click="openLink(`${$root.url}material_card/${selected.id_user}`)"
          >
            <v-icon>assignment_ind</v-icon>
          </v-btn>
          <v-btn
            v-show="selectedItems.length > 0"
            color="primary"
            icon
            @click="openLink(`${$root.url}barcode/${selected.id_user}`)"
          >
            <v-icon>straighten</v-icon>
          </v-btn>
          <v-btn color="error" icon @click="deleteUser()">
            <v-icon>delete</v-icon>
          </v-btn>
          <v-btn color="warning" icon @click="userDialog = true">
            <v-icon>edit</v-icon>
          </v-btn>
        </v-toolbar-items>
      </v-toolbar>
      <v-card>
        <v-data-table :headers="headers" :items="selectedItems" class="elevation-1">
          <template v-slot:item.actions="{ item }">
            <v-icon small class="mr-2" @click="hystoryItem(item)">query_builder</v-icon>
            <v-icon small class="mr-2" @click="editItem(item)">mdi-pen</v-icon>
            <v-icon small @click="deleteItem(item)">mdi-delete</v-icon>
          </template>
        </v-data-table>
      </v-card>
    </v-dialog>
    <User :editingUser="selected" :dialog="userDialog"></User>
    <Item :editedItem="editedItem" :dialog="editDialog" :editedIndex="editedItem.id_item"></Item>
    <Hystory
      v-if="hystoryDialog"
      :dialog="hystoryDialog"
      :id="editedItem.id_item"
      :caption_item="editedItem.caption_item"
    ></Hystory>
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
import Hystory from "./modals/Hystory";
import ItemsService from "../services/ItemsService";
import UsersService from "../services/UsersService";
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
      hystoryDialog: false,
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
          value: "actions",
          sortable: false
        }
      ],
      type_icon: {
        _1: {
          open: "mdi-folder-open",
          close: "mdi-folder"
        },
        _2: {
          open: "mdi-human",
          close: "mdi-human-handsdown"
        },
        _3: {
          open: "mdi-console-line",
          close: "mdi-contacts"
        }
      }
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
      let data = await UsersService.getItems(this.active[0]);
      this.selectedItems = data.data;
    },
    hystoryItem(item) {
      this.editedItem = Object.assign({}, item);
      this.hystoryDialog = true;
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
    openLink(link) {
      window.open(link);
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
    Hystory
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
      this.hystoryDialog = false;
    });
  }
};
</script>
<style scoped>
</style>
