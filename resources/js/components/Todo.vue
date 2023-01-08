<template>
    <div class="container" >
        <div class="row justify-content-start">
            <div class="col-md-8">
                <transition name="fade">
                <div class="text-center" v-if="prLoading">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
                <div class="row" v-else>
                    <div class="col-md-6"  v-for="list in board.lists" :key="list.id">
                        <div class="card">
                            <div class="card-header">
                                {{ list.name }}
                            </div>
                            <div class="card-body" >
                                <div class="card mb-3" v-for="card in list.cards" :key="card.id">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ card.name }}</h5>
                                        <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                                            <button type="button" class="btn btn-warning" @click="editCard(card.id)" disabled>Редактировать</button>
                                            <button type="button" class="btn btn-danger" @click="deleteCard(card.id)">Удалить</button>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-success w-100" @click="openCardDialog(list.id)">Добавить</button>
                            </div>
                        </div>
                    </div>
                </div>
                </transition>
            </div>
          
        </div>
    </div>
    <CModal :visible="visibleCardDialog" @close="closeCardDialog">
        <CModalHeader>
            <CModalTitle>Новая задача</CModalTitle>
        </CModalHeader>
        <CModalBody>
            <form @submit.prevent="submitCardForm">
                <div class="mb-3">
                    <input class="form-control"  :class="{ 'is-invalid' : v$.cardForm.name.$error }" v-model="cardForm.name">
                    <div class="invalid-feedback" >
                        Поле не должно быть пустым
                    </div>
                </div>
                <button type="submit" class="btn btn-primary" @click.prevent="submitCardForm">Добавить</button>
            </form>
        </CModalBody>
    </CModal>
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
            visibleCardDialog:false,
            cardForm:{
                name:null,
                list_id: null,
            }
        }
    },
    validations () {
        return {
        cardForm: {
            name: { required },
        }
        }
    },

    mounted() {
        this.loadBoard()
    },
    methods:{
        loadBoard(){
            var _this = this;
            this.getAxios('/ajax/todo/board', {}, function (response) {
                _this.board = response.data.board;
            });
        },
        deleteCard(id){
            var _this = this;
            this.deleteAxios('/ajax/todo/card/'+id,  function (response) {
                _this.loadBoard()
            });
        },
        openCardDialog(id){
            this.cardForm.list_id =  id;
            this.visibleCardDialog = true;
        },
        closeCardDialog(){
            this.visibleCardDialog = false;
        },
        async submitCardForm () {
            const valid = await this.v$.$validate()
            if (!valid) return
            var _this = this;
            this.postAxios('/ajax/todo/card/', { ...this.cardForm }, function (response) {
                _this.closeCardDialog();
                _this.loadBoard()
            });
        }
    }
}
</script>

<style lang="scss">
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.5s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;

}
</style>