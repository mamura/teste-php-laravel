import './bootstrap';

// CSS
import '../sass/app.scss';

import { createApp } from 'vue';
import FileUpload from './components/FileUpload.vue';
import ProcessButton from './components/ProcessButton.vue';

const app = createApp({});
app.component('file-upload', FileUpload);
app.component('process-button', ProcessButton);

app.mount('#app');