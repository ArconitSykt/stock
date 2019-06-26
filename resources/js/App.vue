<template>
  <v-app>
    <v-toolbar app>
      <v-img
        :src="`images/logo.png`"
        :lazy-src="`images/logo.png`"
        max-width="200px"
        max-height="80px"
      ></v-img>
      <v-spacer></v-spacer>
      <v-btn flat @click="navigateTo({name: 'Items'})">Список оборудования и мебели</v-btn>
      <v-btn flat @click="navigateTo({path: '/users'})">Список складов</v-btn>
      <v-btn flat @click="navigateTo({path: '/agreements'})">Договоры</v-btn>
    </v-toolbar>
    <v-content>
      <v-container fluid>
        <router-view></router-view>
      </v-container>
    </v-content>
    <v-footer app></v-footer>
  </v-app>
</template>

<script>
export default {
  name: "App",
  components: {},
  methods: {
    navigateTo(route) {
      this.$router.push(route);
    }
  },
  mounted() {}
};
</script>

<style>
@media print {
  .no-print {
    display: none !important;
  }
  .print {
    margin: 0;
    padding: 0;
    padding-left: 0mm;
  }
}
#app {
  font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  color: #2c3e50;
}
.v-treeview-node__label {
  cursor: pointer;
  font-size: 8px;
}
.v-treeview-node {
  border: 1px solid rgb(202, 202, 202);
  background-color: #fff;
}
</style>
