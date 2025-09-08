import './bootstrap';

import { createApp } from 'vue';

const app = createApp({});

import Buefy from 'buefy';
app.use(Buefy);

import BlobUploader from './components/BlobUploader.vue';
import CognitiveUploader from './components/CognitiveUploader.vue';

app.component('blob-uploader', BlobUploader);
app.component('cognitive-uploader', CognitiveUploader);

app.mount('#app');
