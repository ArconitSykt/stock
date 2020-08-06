<template>
  <v-dialog v-model="dialog" fullscreen hide-overlay transition="dialog-bottom-transition">
    <v-card>
      <v-toolbar>
        <v-btn icon @click="close">
          <v-icon>close</v-icon>
        </v-btn>
        <v-toolbar-title>Импорт данных</v-toolbar-title>
      </v-toolbar>
      <v-card-text>
        <v-container grid-list-xs>
          <v-stepper v-model="e1">
            <v-stepper-header>
              <v-stepper-step :complete="e1 > 1" step="1">Выбор файла для импорта</v-stepper-step>
              <v-divider></v-divider>
              <v-stepper-step :complete="e1 > 2" step="2">Склад для импорта</v-stepper-step>
              <v-divider></v-divider>
              <v-stepper-step :complete="e1 > 3" step="3">Импорт</v-stepper-step>
              <v-divider></v-divider>
              <v-stepper-step step="4">Завершение</v-stepper-step>
            </v-stepper-header>

            <v-stepper-items>
              <v-stepper-content step="1">
                <v-card class="mb-12" flat>
                  <v-file-input
                    chips
                    show-size
                    label="Выберите EXCEL файл для загрузки"
                    accept=".xls, .xlsx"
                    v-model="files"
                    :disabled="successUpload"
                  ></v-file-input>
                  <p>
                    Пример файла Excel
                    <a href="templates/import_example.xlsx">Скачать шаблон</a>
                  </p>
                  <v-alert v-if="successUpload" type="success" close-icon="mdi-delete">{{message}}</v-alert>
                </v-card>
                <v-btn
                  v-if="!successUpload"
                  color="success"
                  @click="submit"
                  :disabled="files.length == 0 "
                  :loading="upload"
                >
                  <v-icon>get_app</v-icon>Загрузить
                </v-btn>
                <v-btn color="primary" v-if="successUpload" @click="e1++; message = null">Далее</v-btn>
                <!-- <v-btn color="primary" @click="e1++">Далее</v-btn> -->
              </v-stepper-content>

              <v-stepper-content step="2">
                <v-card class="mb-12" flat>
                  <v-layout row wrap>
                    <v-flex xs10 sm10 md11 lg11 xl11>
                      <v-select
                        :items="lists.users"
                        v-model="current.user"
                        item-text="name_user"
                        item-value="id_user"
                        label="Склад для импорта"
                      ></v-select>
                    </v-flex>
                    <v-flex xs2 sm2 md1 lg1 xl1>
                      <v-btn color="blue-grey" text icon @click="getList('users')">
                        <v-icon>refresh</v-icon>
                      </v-btn>
                    </v-flex>
                  </v-layout>
                </v-card>

                <v-btn color="primary" @click="e1++">Далее</v-btn>

                <v-btn text @click="e1--">Назад</v-btn>
              </v-stepper-content>

              <v-stepper-content step="3">
                <v-card class="mb-12" flat>
                  <v-card-title primary-title>
                    <v-btn color @click="importDataM()" v-if="!successImport">Начать импорт</v-btn>
                  </v-card-title>
                  <v-card-text v-if="importData">
                    <v-progress-linear :height="15" indeterminate color="purple darken-3"></v-progress-linear>
                  </v-card-text>
                  <v-alert v-if="successImport" type="success" close-icon="mdi-delete">{{message}}</v-alert>
                </v-card>

                <v-btn color="primary" v-if="successImport" @click="e1++">Далее</v-btn>

                <v-btn text @click="e1--" v-if="!importData">Назад</v-btn>
              </v-stepper-content>
              <v-stepper-content step="4">
                <v-card class="mb-12">
                  <v-card-text v-html="result"></v-card-text>
                </v-card>

                <v-btn color="primary" @click="close()">Готово</v-btn>

                <v-btn text @click="e1--">Назад</v-btn>
              </v-stepper-content>
            </v-stepper-items>
          </v-stepper>
        </v-container>
      </v-card-text>
    </v-card>
  </v-dialog>
</template>
<script>
import ImportService from "../../services/ImportService";
import ListsService from "../../services/ListsService";

export default {
  props: {
    dialog: Boolean,
  },
  data() {
    return {
      e1: 1,
      files: [],
      upload: false,
      importData: false,
      successUpload: false,
      successImport: false,
      message: "",
      fileName: "",
      lists: [],
      current: {
        user: 1,
      },
      result: "",
    };
  },
  methods: {
    async submit() {
      this.upload = true;
      const config = { "content-type": "multipart/form-data" };
      const formData = new FormData();
      formData.append("name", "upload");
      formData.append("file", this.files);
      let response = await ImportService.add(formData, config);
      if (response.data != false) {
        this.message = "Файл успешно загружен для импорта!";
        this.upload = false;
        this.successUpload = true;
        this.fileName = response.data;
      } else {
        this.message = "Что-то пошло не так :(";
      }
    },

    async getList(name) {
      let data = await ListsService.list(name);
      this.lists[name] = data.data;
    },
    importDataM() {
      this.importData = true;
      axios
        .post("items/import", { link: this.fileName, id: this.current.user })
        .then((response) => {
          this.message = "Импорт завершён!";
          this.successImport = true;
          this.importData = false;
          this.result = response.data;
        })
        .catch(() => {
          console.log(response);
        });
    },
    close() {
      Event.$emit("closeDialog", 0);
      this.e1 = 1;
      this.files = [];
      this.upload = false;
      this.importData = false;
      this.successUpload = false;
      this.successImport = false;
      this.message = "";
      this.fileName = "";
    },
  },
  mounted() {
    this.getList("users");
  },
};
</script>