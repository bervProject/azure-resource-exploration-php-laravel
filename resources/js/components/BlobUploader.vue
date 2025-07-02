<template>
  <div>
    <section class="section">
      <h2 class="title">Azure Blob Uploader</h2>
      <form class="form">
        <b-field class="file">
          <b-upload v-model="file">
            <a class="button is-link">
              <b-icon pack="fas" icon="upload" size="is-small"></b-icon>
              <span>Click to upload</span>
            </a>
          </b-upload>
          <span class="file-name" v-if="file">
            {{ file.name }}
          </span>
        </b-field>
        <b-button type="is-success" :loading="uploadLoading" @click="upload">Submit</b-button>
      </form>
    </section>
    <section class="section">
      <h2 class="title">Azure Blob List</h2>
      <b-button type="is-primary" @click="loadData">Refresh List</b-button>
      <b-table :loading="loading" :data="data">
        <b-table-column field="name" label="File Name" v-slot="props">
          {{ props.row.name }}
        </b-table-column>
        <b-table-column field="url" label="URL" v-slot="props">
          <a class="button is-primary" :href="props.row.url">LINK</a>
        </b-table-column>
      </b-table>
    </section>
    <a class="button is-link" href="/">Back to Home</a>
  </div>
</template>

<script>

export default {
  data() {
    return {
      file: null,
      data: [],
      loading: false,
      uploadLoading: false,
    };
  },
  methods: {
    upload() {
      if (this.file) {
        this.uploadLoading = true;
        let formData = new FormData();
        formData.append("blob_file", this.file);
        window.axios
          .post("/api/blob", formData)
          .then((response) => {
            this.uploadLoading = false;
            console.log(response);
            this.loadData();
          })
          .catch((err) => {
            this.uploadLoading = false;
            console.log(err);
          });
      }
    },
    loadData() {
      this.loading = true;
      window.axios
        .get("/api/blob")
        .then((response) => {
          let data = response.data;
          this.data = data;
          this.loading = false;
        })
        .catch((error) => {
          console.error(error);
          this.loading = false;
        });
    },
  },
  mounted() {
    this.loadData();
  },
};
</script>
