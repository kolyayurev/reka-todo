import _ from 'lodash';
window._ = _;


import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

import "bootstrap/dist/css/bootstrap.min.css"
import "bootstrap"
import "bootstrap-icons/font/bootstrap-icons.scss"

import { createApp } from 'vue';
import BV from '@coreui/bootstrap-vue';

import Base from './mixins/base';

const app = createApp({});

app.use(BV);
app.mixin(Base);

import Loading from './components/Loading.vue';
app.component('v-loading', Loading);

import Board from './components/Board.vue';
app.component('v-board', Board);

import Permissions from './components/Permissions.vue';
app.component('v-permissions', Permissions);


app.mount('#app');

