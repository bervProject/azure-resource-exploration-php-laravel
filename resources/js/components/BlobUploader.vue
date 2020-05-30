<template>
    <div>
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
            <b-button type="is-success" @click="upload">Submit</b-button>
        </form>
    </div>
</template>

<script>
    import Vue from 'vue';
    import {Field, Button, Upload, Icon} from 'buefy';

    Vue.use(Field);
    Vue.use(Upload);
    Vue.use(Icon);
    Vue.use(Button);
    export default {
        data() {
            return {
                file: null
            }
        },
        methods: {
            upload(){
                if (this.file) {
                    window.axios.post('/api/blob/upload').then(response => {
                        console.log(response);
                    }).catch(err => {
                        console.log(err);
                    })
                }
            }
        }
    }
</script>
