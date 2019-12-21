<template>
  <div>
    <h2 class="title">Uploader</h2>
    <form class="form">
      <b-field class="file">
        <b-upload v-model="file">
            <a class="button is-primary">
                <b-icon icon="upload"></b-icon>
                <span>Click to upload</span>
            </a>
        </b-upload>
        <span class="file-name" v-if="file">
            {{ file.name }}
        </span>
        </b-field>
    </form>
  </div>
</template>