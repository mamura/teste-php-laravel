import './bootstrap';

// CSS
import '../sass/app.scss';

import { createApp } from 'vue';
import FileUpload from './components/FileUpload.vue';

const app = createApp({});
app.component('file-upload', FileUpload);

app.mount('#app');