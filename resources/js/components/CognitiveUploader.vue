<template>
  <div>
    <section class="section">
      <h2 class="title">Azure Cognitive</h2>
      <div class="card">
        <div v-if="file" class="card-image">
          <figure class="image is-4by3">
            <img :src="fileImage" alt="image-preview" />
          </figure>
        </div>
        <div class="card-content">
          <form class="form">
            <b-field class="file">
              <b-upload accept="image/*" v-model="file">
                <a class="button is-link">
                  <b-icon pack="fas" icon="upload" size="is-small"></b-icon>
                  <span>Click to upload</span>
                </a>
              </b-upload>
              <span class="file-name" v-if="file">
                {{ file.name }}
              </span>
            </b-field>

            <b-button type="is-success" :loading="uploadLoading" @click="upload"
              >Submit</b-button
            >
          </form>
          <h3 class="subtitle">Caption</h3>
          <p>{{ caption }}</p>
        </div>
      </div>
    </section>
    <section class="section">
      <h2 class="title">Azure Blob List</h2>
      <a class="button is-link" href="/blob">Go here to see the list</a>
    </section>
    <a class="button is-link" href="/">Back to Home</a>
  </div>
</template>

<script>

export default {
  data() {
    return {
      file: null,
      uploadLoading: false,
      caption: null,
    };
  },
  computed: {
    fileImage: {
      get: function () {
        if (this.file) {
          return window.URL.createObjectURL(this.file);
        } else {
          return "";
        }
      },
    },
  },
  methods: {
    upload() {
      if (this.file) {
        this.uploadLoading = true;
        let formData = new FormData();
        formData.append("cognitive_file", this.file);
        window.axios
          .post("/api/cognitive", formData)
          .then((response) => {
            this.uploadLoading = false;
            let data = response.data;
            let caption = data.captions;
            console.log(caption);
            this.caption = caption;
          })
          .catch((err) => {
            this.uploadLoading = false;
            console.log(err);
          });
      }
    },
  },
};
</script>
