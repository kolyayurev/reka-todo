<template>
<v-loading :status="loading"></v-loading>
<h3>Разрешения для доски "{{ board.name  }}"</h3>
<hr>
<div class="row">
    <div class="col-md-6">
        <form @submit.prevent="submitForm">
            <input class="form-control me-2 mb-2" :class="{ 'is-invalid' : v$.form.email.$error || errors.email }" type="search" placeholder="Email" v-model="form.email">
            <div class="invalid-feedback" v-if="errors.email">
                {{ errors.email[0] }}
            </div>
            <div class="invalid-feedback" v-if="v$.form.email.$error">
                Поле должно быть email адрессом
            </div>
        </form>
        <table class="table">
            <thead>
                <tr>
                <th scope="col">Пользователь (email)</th>
                <th scope="col">Просмотр</th>
                <th scope="col">Редактирование</th>
                <th scope="col">Действия</th>
                </tr>
            </thead>
            <tbody>
                <tr v-if="!board.guests || !board.guests.length"><td colspan="4" class="text-center">Здесь пока ничего нет</td></tr>
                <tr v-else v-for="guest in board.guests" :key="guest.id">
                <td> {{ guest.email }}</td>
                <td>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" v-model="guest.pivot.read" :checked="guest.pivot.read" @change="onChange(guest,'read')">
                    </div>
                </td>
                <td>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" v-model="guest.pivot.write" :checked="guest.pivot.write" @change="onChange(guest,'write')">
                    </div>
                </td>
                <td class="text-center">
                    <button type="button" class="btn btn-danger" @click="removeGuest(guest.id)"><i class="bi bi-trash-fill"></i></button>
                </td>

                </tr>
               
            </tbody>
        </table>
    </div>
</div>

</template>

<script>
import { useVuelidate } from '@vuelidate/core'
import { required, email } from '@vuelidate/validators'
export default {
    setup () {
        return { v$: useVuelidate() }
    },
    data(){
        return {
            board:{},
            form:{
                email: null
            },
            errors:{},
        }
    },
    watch:{
        'form.email'(value) {
            if(!value)
            {
                this.v$.form.$reset();
                this.error = {};
            }
        }
    },
    validations () {
        return {
            form: {
                email: { required,  email },
            },
        }
    },
    mounted() {
        this.loadPermissions()
    },
    methods:{
        loadPermissions(){
            var _this = this;
            this.getAxios('/ajax/todo/board/'+boardId+'/permissions', {}, function (response) {
                _this.board = response.data.board;
            });
        },
        async submitForm () {
            const valid = await this.v$.form.$validate()
            if (!valid) return
            var _this = this;

            this.errors = {};

            this.putAxios('/ajax/todo/board/'+boardId+'/permissions/add-guest', { ...this.form }, 
                function (response) {
                    _this.clearForm();
                    _this.loadPermissions()
                },
                function (response) {
                    _this.errors = response.data.messages;
                }
            );
          
        },
        onChange(guest,permission){

            let data = { 'permission' : permission, 'status': guest.pivot[permission]};

            var _this = this;

            this.putAxios('/ajax/todo/board/'+boardId+'/permissions/'+guest.id+'/change', data, 
                function (response) {
                    _this.loadPermissions()
                },
            );
        },
        removeGuest(id){
            var _this = this;

            this.deleteAxios('/ajax/todo/board/'+boardId+'/permissions/'+id,  
                function (response) {
                    _this.loadPermissions()
                },
            );
        },
        clearForm(){
            this.form = { email : null };
            this.v$.form.$reset()
        },
    }
}
</script>

