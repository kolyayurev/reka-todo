import _ from 'lodash';
window._ = _;


import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

import "bootstrap/dist/css/bootstrap.min.css"
import "bootstrap"

import { createApp } from 'vue';
import BV from '@coreui/bootstrap-vue';

import Base from './mixins/base';

const app = createApp({});

app.use(BV);
app.mixin(Base);

import Todo from './components/Todo.vue';
app.component('todo', Todo);


app.mount('#app');

