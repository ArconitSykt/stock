<template>
  <div>
    <v-toolbar flat color="white">
      <template>
        <v-checkbox label="Договор" v-model="check.add1"></v-checkbox>
        <v-checkbox label="Доп.соглашение №1 передача" v-model="check.add2"></v-checkbox>
        <v-checkbox label="Доп.соглашение №2 рассторжение" v-model="check.add3"></v-checkbox>
        <v-checkbox label="Акт возврата имущества" v-model="check.add4"></v-checkbox>
        <v-checkbox label="Акт-приема передачи" v-model="check.add5"></v-checkbox>
        <v-btn color="primary" icon flat @click="compile">
          <v-icon>get_app</v-icon>
        </v-btn>
      </template>
    </v-toolbar>
    <v-divider></v-divider>
    <v-layout row wrap>
      <v-flex xs6>
        <v-card>
          <v-card-title primary-title>Предметы</v-card-title>
          <v-card-text>
            <v-toolbar color="white" flat>
              <v-text-field v-model="search" label="Поиск" clearable></v-text-field>
              <v-spacer></v-spacer>
              <v-text-field v-model="type" label="Тип группы предметов"></v-text-field>
              <v-btn color="success" icon flat :disabled="!type" @click="addToFormItems">
                <v-icon>assignment_turned_in</v-icon>
              </v-btn>
            </v-toolbar>
            <v-data-table
              v-model="selected"
              :headers="headers"
              :items="items"
              :search="search"
              item-key="id_item"
              disable-initial-sort
              select-all
            >
              <template v-slot:items="props">
                <td>
                  <v-checkbox v-model="props.selected" primary hide-details></v-checkbox>
                </td>
                <td>{{ props.item.caption_item }}</td>
                <td>{{ props.item.reg_num_item }}</td>
                <td>{{ props.item.name_user }}</td>
              </template>
            </v-data-table>
          </v-card-text>
        </v-card>
      </v-flex>
      <v-flex xs6 pl-2>
        <v-card>
          <v-card-title primary-title>Выбранные предметы</v-card-title>
          <v-list>
            <template v-for="(item, name) in form.items">
              <v-list-tile :key="item.id_item" @click="!true">
                <v-list-tile-content :key="item.id_item">
                  <v-list-tile-title>Тип группы: {{name}}</v-list-tile-title>
                  <v-list-tile-sub-title>Позиций в группе: {{item.length}}</v-list-tile-sub-title>
                </v-list-tile-content>
              </v-list-tile>
            </template>
          </v-list>
        </v-card>
      </v-flex>
    </v-layout>
    <v-layout row wrap>
      <v-flex xs4 py-2 px-2>
        <v-card>
          <v-card-title primary-title>Договор</v-card-title>
          <v-card-text>
            <v-text-field v-model="form.num" label="Номер договора"></v-text-field>
            <v-text-field v-model="form.num_add" label="Номер доп.соглашения"></v-text-field>
            <v-divider></v-divider>
            <v-text-field v-model="form.date" label="Дата формата (01.01.2019)"></v-text-field>
            <v-text-field v-model="form.date_string" label="Дата формата (01 января 2019 г.)"></v-text-field>
            <v-text-field v-model="form.date_end" label="Дата завершения формата (01.01.2019)"></v-text-field>
          </v-card-text>
        </v-card>
      </v-flex>
      <v-flex xs4 py-2 px-2>
        <v-card>
          <v-card-title primary-title>Контрагент</v-card-title>
          <v-card-text>
            <v-text-field v-model="form.c_org" label="Название организации"></v-text-field>
            <v-text-field v-model="form.c_position" label="Должность"></v-text-field>
            <v-text-field v-model="form.c_r_position" label="Должность в падеже"></v-text-field>
            <v-text-field v-model="form.c_name" label="ФИО ответсвенного (в род.падеже)"></v-text-field>
            <v-text-field v-model="form.c_short_name" label="ФИО для реквизитов (И.И. Иванов)"></v-text-field>
            <v-divider inset></v-divider>
            <v-subheader inset>Реквизиты и контактные данные</v-subheader>
            <v-text-field v-model="form.c_index" label="Почтовый индекс"></v-text-field>
            <v-text-field v-model="form.c_region" label="Регион"></v-text-field>
            <v-text-field v-model="form.c_street" label="Улица, дом"></v-text-field>
            <v-text-field v-model="form.c_inn_kpp" label="ИНН/КПП"></v-text-field>
            <v-text-field v-model="form.c_bik" label="БИК"></v-text-field>
            <v-text-field v-model="form.c_rs" label="Р/С"></v-text-field>
            <v-text-field v-model="form.c_phone" label="Телефон"></v-text-field>
          </v-card-text>
        </v-card>
      </v-flex>
      <v-flex xs4 py-2 px-2>
        <v-card>
          <v-card-title primary-title>РИЦОКО</v-card-title>
          <v-card-text>
            <v-text-field v-model="form.r_position" label="Должность"></v-text-field>
            <v-text-field v-model="form.r_r_position" label="Должность в падеже"></v-text-field>
            <v-text-field v-model="form.r_name" label="ФИО ответсвенного (в род.падеже)"></v-text-field>
            <v-text-field v-model="form.r_short_name" label="ФИО для реквизитов (И.И. Иванов)"></v-text-field>
            <v-text-field v-model="form.r_document" placeholder="Устав или номер приказа">
              <template v-slot:label>на основании {{form.r_document}}</template>
            </v-text-field>
          </v-card-text>
        </v-card>
      </v-flex>
    </v-layout>
  </div>
</template>
<script>
import ItemsService from "../services/ItemsService";
import DocPackService from "../services/DocPackService";
import SaveDoc from "../includes/SaveDoc";
import { log } from "util";
export default {
  data() {
    return {
      form: {
        num: "25A",
        num_add: "1B",
        r_document: "внутреннего Устава",
        date: "01.01.2019",
        date_string: "01 января 2019",
        date_end: "01.01.2020",
        r_position: "директор",
        r_r_position: "директора",
        r_name: "Попова Олега Васильевича",
        r_short_name: "О.В. Попов",
        c_position: "начальник",
        c_r_position: "начальника",
        c_name: "Иванова Ивана Ивановича",
        c_short_name: "И.И. Иванов",
        c_org: "Рога и Копыта",
        c_index: "167023",
        c_region: "Республика Коми",
        c_street: "ул. Пушкина, д.276",
        c_inn_kpp: "2312323243/43423324",
        c_bik: "666666666",
        c_rs: "777777777777777777/88",
        c_phone: "8 (800) 255-35-35",
        items: {}
      },
      check: {
        add1: false,
        add2: false,
        add3: false,
        add4: false,
        add5: false
      },
      headers: [
        { text: "Наименование", value: "caption_item" },
        { text: "Инвентарный номер", value: "reg_num_item" },
        { text: "Пользователь", value: "name_user" }
      ],
      items: [],
      search: "",
      selected: [],
      type: null
    };
  },
  methods: {
    compile() {
      if (this.check.add1 == true) {
        this.getHtml("Договор");
      }
      if (this.check.add2 == true) {
        this.getHtml("Доп.соглашение №1 передача");
      }
      if (this.check.add3 == true) {
        this.getHtml("Доп.соглашение №2 рассторжение");
      }
      if (this.check.add4 == true) {
        this.getHtml("Акт возврата имущества");
      }
      if (this.check.add5 == true) {
        axios
          .post("trans_report", this.form, {
            responseType: "blob"
          })
          .then(response => {
            const url = window.URL.createObjectURL(new Blob([response.data]));
            console.log(response);
            const link = document.createElement("a");
            link.href = url;
            link.setAttribute(
              "download",
              `Акт-приема передачи ${this.form.c_org}.xls`
            );
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
          });
      }
    },
    getHtml(url) {
      let rawHtml = "";
      axios.get(`templates/${url}.html`).then(response => {
        rawHtml = response.data;
        SaveDoc.getWord(rawHtml, this.form, `${url} с ${this.form.c_org}`);
      });
    },
    async getItems() {
      let data = await ItemsService.index();
      this.items = data.data;
    },
    addToFormItems() {
      this.form.items[this.type] = this.selected;
      this.selected = [];
      this.type = null;
    },
    async transReport() {
      return await DocPackService.index(this.form);
    }
  },
  mounted() {
    this.getItems();
  }
};
</script>