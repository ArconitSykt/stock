<template>
  <v-dialog v-model="dialog" fullscreen hide-overlay transition="dialog-bottom-transition">
    <v-card>
      <v-toolbar>
        <v-btn icon @click="close">
          <v-icon>close</v-icon>
        </v-btn>
      </v-toolbar>
      <v-card-text>
        <v-container grid-list-xs>
          <v-text-field v-model="agreement.num_agreement" label="Номер договора" clearable></v-text-field>
          <v-menu transition="scale-transition" offset-y min-width="290px">
            <template v-slot:activator="{ on }">
              <v-text-field
                v-model="agreement.date_agreement"
                label="Дата договора"
                readonly
                clearable
                v-on="on"
              ></v-text-field>
            </template>
            <v-date-picker
              v-model="agreement.date_agreement"
              locale="ru"
              :first-day-of-week="1"
              no-title
              scrollable
            ></v-date-picker>
          </v-menu>
          <v-btn
            v-if="agreement.num_agreement != null || agreement.date_agreement != null"
            color="success"
            flat
            @click="getData"
          >
            <v-icon>search</v-icon>Искать
          </v-btn>
        </v-container>

        <table class="table table-bordered table-striped">
          <caption class="text-center">
            <h2>Список предметов по договору №{{agreement.num_agreement}}</h2>
          </caption>
          <thead>
            <tr>
              <th>№</th>
              <th>Наименование</th>
              <th>Инвентарный номер</th>
              <th>Серийный номер</th>
              <th>Текущий склад</th>
              <th>№ договора</th>
              <th>Дата договора</th>
              <th>Пояснение к договору</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(item, index) in result" :key="index">
              <td>{{index+1}}</td>
              <td>{{item.caption_item}}</td>
              <td>{{item.reg_num_item}}</td>
              <td>{{item.ser_num_item}}</td>
              <td>{{item.name_user}}</td>
              <td>{{item.num_agrement_item}}</td>
              <td>{{item.date_agrement_item}}</td>
              <td>{{item.notation_item}}</td>
            </tr>
          </tbody>
          <tfoot>
            <tr class="cyan lighten-5">
              <td colspan="2">
                <strong>Итого предметов</strong>
              </td>
              <td colspan="6">{{length}}</td>
            </tr>
          </tfoot>
        </table>
      </v-card-text>
    </v-card>
  </v-dialog>
</template>
<script>
import AgreementsService from "../../services/AgreementsService";

export default {
  props: {
    dialog: Boolean
  },
  data() {
    return {
      agreement: { num_agreement: null, date_agreement: null },
      result: []
    };
  },
  methods: {
    async getData() {
      let data = await AgreementsService.search(this.agreement);
      this.result = data.data;
    },
    close() {
      Event.$emit("closeDialog", 0);
      this.result = [];
    }
  },
  computed: {
    length() {
      return this.result.length;
    }
  }
};
</script>