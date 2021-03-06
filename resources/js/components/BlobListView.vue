<template>
  <div>
    <h2 class="title">Azure Blob List</h2>
    <b-table :data="data">
      <b-table-column field="name" label="File Name" v-slot="props">
        {{ props.row.name }}
      </b-table-column>
      <b-table-column field="url" label="URL" v-slot="props">
        <a class="button is-primary" :href="props.row.url">LINK</a>
      </b-table-column>
    </b-table>
    <a class="button is-link" href="/">Back to Home</a>
  </div>
</template>

<script>
import Vue from "vue";
import { Table } from "buefy";
import axios from "axios";

Vue.use(Table);
export default {
  data() {
    return {
      data: [],
    };
  },
  methods: {
    loadData() {
      axios
        .get("/api/blob")
        .then((response) => {
          let data = response.data;
          this.data = data;
        })
        .catch((error) => {
          console.error(error);
        });
    },
  },
  mounted() {
    this.loadData();
  },
};
</script>
