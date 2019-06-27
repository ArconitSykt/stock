<template>
  <div>
    <v-toolbar flat color="white">
      <v-text-field v-model="name" label="Имя файла для загрузки"></v-text-field>
      <v-spacer></v-spacer>
      <input
        label="Выберите файл"
        prepend-icon="attach_file"
        type="file"
        ref="file"
        name="file"
        @change="onAttachmentChange"
      >
      <v-spacer></v-spacer>
      <v-btn color="success" flat type="submit" @click="submit">
        <v-icon>get_app</v-icon>Загрузить
      </v-btn>
      <v-btn color="blue-grey" dark flat @click="searchDialog = true">
        <v-icon>search</v-icon>Поиск предметов по № договора
      </v-btn>
    </v-toolbar>
    <v-divider></v-divider>
    <v-toolbar flat color="white">
      <v-text-field
        v-model="search"
        append-icon="search"
        label="Поиск документа"
        clearable
        single-line
      ></v-text-field>
      <v-btn color="blue-grey" flat icon @click="getAgreements">
        <v-icon>refresh</v-icon>
      </v-btn>
    </v-toolbar>
    <v-data-table :items="agreements" :headers="headers" :search="search" disable-initial-sort>
      <template v-slot:items="props">
        <td>{{ props.item.name_file }}</td>
        <td>
          <a class="link" :href="$root.url + props.item.path_file" target="_blank">
            <v-icon>touch_app</v-icon>Просмотр
          </a>
        </td>
        <td>{{props.item.date_load_file}}</td>
      </template>
    </v-data-table>

    <SearchAgreements  :dialog="searchDialog"></SearchAgreements>
  </div>
</template>
<script>
import AgreementsService from "../services/AgreementsService";
import SearchAgreements from "./modals/SearchAgreements";
export default {
  data() {
    return {
      name: null,
      attachment: null,
      agreements: [],
      search: null,
      searchDialog: false,
      headers: [
        {
          text: "Название документа",
          value: "name_file"
        },
        {
          text: "Просмотр",
          value: "path_file",
          sortable: false
        },
        {
          text: "Дата загрузки",
          value: "date_load_file"
        }
      ]
    };
  },
  methods: {
    async getAgreements() {
      let data = await AgreementsService.index();
      this.agreements = data.data;
    },
    async submit() {
      const config = { "content-type": "multipart/form-data" };
      const formData = new FormData();
      formData.append("name", this.name);
      formData.append("file", this.attachment);
      let response = await AgreementsService.add(formData, config);
      this.name = null;
      this.attachment = null;
      setTimeout(() => {
        this.getAgreements();
      }, 400);
    },
    onAttachmentChange(e) {
      this.attachment = this.$refs.file.files[0];
    }
  },
  mounted() {
    Event.$on("closeDialog", (item, response) => {
      this.searchDialog = false;
    });
    this.getAgreements();
  },
  components:{
    SearchAgreements
  }
};
</script>
<style scoped>
.link:hover {
  text-decoration: none;
}
</style>
