<template>
  <v-dialog v-model="dialog" max-width="600px" persistent transition="dialog-bottom-transition">
    <v-card>
      <v-toolbar>
        <v-btn icon @click="close">
          <v-icon>close</v-icon>
        </v-btn>
        <v-spacer></v-spacer>
        
        <v-btn class="success" icon @click="save">
          <v-icon>save</v-icon>
        </v-btn>
      </v-toolbar>
      <v-card-title></v-card-title>
      <v-card-text>
        <v-text-field v-model="user.name_user" label="Имя склада" clearable></v-text-field>
        <v-text-field v-model="user.requisites_user" label="Реквизиты склада" clearable></v-text-field>
        <v-select
          :items="lists.list_type_user"
          v-model="user.type_user"
          item-text="name_type"
          item-value="id_type"
          label="Тип склада"
        ></v-select>
        <v-select
          :items="lists.users"
          v-model="user.parent_user"
          item-text="name_user"
          item-value="id_user"
          label="Родитель склада"
        ></v-select>
      </v-card-text>
    </v-card>
  </v-dialog>
</template>
<script>
import ListsService from "../../services/ListsService";
import UsersService from "../../services/UsersService";

export default {
  props: {
    dialog: Boolean,
    editingUser: Object
  },
  data() {
    return {
      lists: {}
    };
  },
  methods: {
    async saveUser() {
      if (this.user.id_user !== undefined) {
        await UsersService.update(this.user);
      } else {
        await UsersService.create(this.user);
      }
      this.close();
    },
    async getList(name) {
      let data = await ListsService.list(name);
      this.lists[name] = data.data;
    },
    save() {
      this.saveUser();
    },
    close() {
      Event.$emit("closeDialog", 0);
    }
  },
  computed: {
    user: {
      get: function() {
        return this.editingUser;
      },
      set: function() {}
    }
  },
  mounted() {
    this.getList("list_type_user");
    this.getList("users");
  }
};
</script>