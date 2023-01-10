<template>
    <div class="container" >
        <div class="row justify-content-start">
            <div class="col">
                <v-loading :status="loading"></v-loading>


                <div class="row" >
                    <div class="col-md-12 col-lg-6 col-xl-4"  v-for="list in board.lists" :key="list.id">
                        <div class="card">
                            <div class="card-header">
                                {{ list.name }}
                            </div>
                            <div class="accordion accordion-flush" >
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#searchCollapse" aria-expanded="false" aria-controls="searchCollapse">
                                        Поиск и сортировка
                                    </button>
                                    </h2>
                                    <div id="searchCollapse" class="accordion-collapse collapse">
                                        <div class="accordion-body">
                                            <input class="form-control me-2 mb-2" type="search" placeholder="Поиск" v-model="search">
                                            <div class="clear"></div>
                                            <template v-for="tag in board.tags" :key="tag">
                                                <input type="checkbox" class="btn-check" :id="tag.id" :value="tag.name" v-model="searchTags" autocomplete="off">
                                                <label class="btn btn-outline-primary mb-1 me-1" :for="tag.id">{{ tag.name }}</label>
                                            </template>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body" >
                                <div class="card list-card mb-3" :class="{'border-success':!card.done,'border-secondary':card.done}" v-for="card in sortedList(list.cards)" :key="card.id">
                                    <a class="list-card__image-box" v-if="card.photo" :href="storagePath(card.photo)" target="_blank">
                                        <img  :src="storagePath(card.photo_thumbnail)" class="list-card__img" alt="sdfd"/>
                                    </a>
                                    <div class="card-body list-card__body">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" v-model="card.done" @change="onChangeDone(card)">
                                            <label class="form-check-label list-card__title" :class="{'text-success':!card.done,'text-secondary text-decoration-line-through':card.done}">{{ card.name }}</label>
                                        </div>
                                        <div class="clearfix"></div>
                                        <span class="badge text-bg-secondary me-1 mb-1 " v-for="tag in card.tags" :key="tag">{{ tag.name }}</span>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="card-actions">
                                        <button class="card-action" @click="editCard(card)" ><i class="bi bi-pencil-fill"></i></button>
                                        <button class="card-action" @click="deleteCard(card.id)"><i class="bi bi-trash-fill"></i></button>
                                    </div>
                                   
                                </div>
                                <div class="card mb-3"  v-if="!sortedList(list.cards).length" >
                                    <div class="card-header">
                                        <p class="text-center mb-0">Здесь ничего нет  </p>
                                    </div>
                                </div>  
                                
                                <button type="button" class="btn btn-success w-100" @click="addCard(list.id)">Добавить</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
          
        </div>
    </div>
    <CModal :visible="visibleCardDialog" @close="closeCardDialog" >
        <CModalHeader>
            <CModalTitle> {{ isEdit ? 'Редактирование' :'Новая задача' }}</CModalTitle>
        </CModalHeader>
        <CModalBody class="card-modal">
            <form @submit.prevent="submitCardForm" ref="cardForm">
                <input type="hidden"  name="list_id" v-model="cardForm.list_id">

                <div class="mb-3">
                    <input class="form-control"  name="name" :class="{ 'is-invalid' : v$.cardForm.name.$error }" placeholder="Наименование" v-model="cardForm.name">
                    <div class="invalid-feedback" >
                        Поле не должно быть пустым
                    </div>
                </div>
                <a class="image-box" v-if="cardForm.photo" :href="storagePath(cardForm.photo)" target="_blank">
                    <img  :src="storagePath(cardForm.photo_thumbnail)" class="image-box__img" alt="sdfd"/>
                    <button class="image-box__remove-button" @click.prevent="removePhoto()"><i class="bi bi-trash-fill"></i></button>
                    <input type="hidden" name="photo" v-model="cardForm.photo">
                </a>
                <v-file
                    v-else
                    accept=".jpg,.jpeg,.png"
                    :max-size="2 * 1024 * 1024"
                    name="photo"
                    ref="file"
                ></v-file>
            </form>
            <hr>
            <form @submit.prevent="submitTagForm" >
                <div class="mb-3">
                    <label for="tagInput" class="form-label">Теги</label>
                    <input class="form-control"  :class="{ 'is-invalid' : v$.tagForm.name.$error }"  placeholder="Тег" id="tagInput" v-model="tagForm.name">
                    <div class="invalid-feedback" >
                        Поле не должно быть пустым
                    </div>
                </div>
                <span class="badge text-bg-success me-1 mb-1 tag" 
                    v-for="(tag,index) in cardForm.tags" :key="tag"
                    @click="removeTag(index)"
                    >
                    {{ tag.name }}
                </span>
                <div class="mb-3">
                    <label class="form-label">Существующие теги</label>
                    <div class="clearfix"></div>
                    <span class="badge text-bg-primary me-1 mb-1 tag" 
                            v-for="tag in filterTags" :key="tag" @click="addTag(tag)">
                            {{ tag.name }}
                    </span>
                </div>
            </form>
        </CModalBody>
        <CModalFooter>
            <button type="submit" class="btn btn-primary" @click.prevent="submitCardForm">{{ isEdit ? 'Сохранить' :'Добавить' }}</button>
        </CModalFooter>
    </CModal>
</template>

<script>
import { useVuelidate } from '@vuelidate/core'
import { required, maxLength } from '@vuelidate/validators'
import file from "@/components/ui/file.vue";

function copyObject(Object){
    return JSON.parse(JSON.stringify(Object));
}

export default {
    components: {
        'v-file': file,
    },
    setup () {
        return { v$: useVuelidate() }
    },
    data(){
        return {
            board:{},
            visibleCardDialog:false,
            isEdit: false,
            cardForm:{
                name:null,
                list_id: null,
                tags:[]
            },
            tagForm:{
                name:null,
                board_id: null,
            },
            search: null,
            searchTags:[]
        }
    },
    computed:{
        
        filterTags(){
            let  tagNames =  this.cardForm.tags.map(tag => tag.name);
            return  tagNames.length ? this.board.tags.filter((tag) => !tagNames.includes(tag.name)): this.board.tags;
        },
    },
    validations () {
        return {
            cardForm: {
                name: { required,  maxLength: maxLength(255), },
            },
            tagForm: {
                name: { required,  maxLength: maxLength(255), },
            }
        }
    },

    mounted() {
        this.loadBoard()
    },
    methods:{
        storagePath(path){
            return '/storage/'+path;
        },
        loadBoard(){
            var _this = this;
            this.getAxios('/ajax/todo/board/'+boardId, {}, function (response) {
                _this.board = response.data.board;
                _this.tagForm.board_id = response.data.board.id;
            });
        },
        enableEditMode(){
            this.isEdit = true;
        },
        disableEditMode(){
            this.isEdit = false;
        },
        editCard(card){
            this.enableEditMode();
            this.cardForm = copyObject(card);
            this.openCardDialog();
        },
        addCard(listId){
            this.disableEditMode();                
            this.clearCardForm();
            this.clearTagForm();
            this.cardForm.list_id =  listId;
            this.openCardDialog();
        },
        deleteCard(id){
            var _this = this;
            this.deleteAxios('/ajax/todo/board/'+this.board.id+'/card/'+id,  function (response) {
                _this.loadBoard()
            });
        },
        openCardDialog(){
            this.visibleCardDialog = true;
        },
        closeCardDialog(){
            this.visibleCardDialog = false;
        },
        async submitCardForm () {
            const valid = await this.v$.cardForm.$validate()
            if (!valid) return
            var _this = this;

            let formData = new FormData(this.$refs.cardForm);
            formData.set('tags', JSON.stringify(this.cardForm.tags));

            this.postAxios(this.isEdit?'/ajax/todo/board/'+this.board.id+'/card/'+this.cardForm.id:'/ajax/todo/board/'+this.board.id+'/card/', formData, function (response) {
                _this.closeCardDialog();
                _this.clearCardForm();
                _this.clearTagForm();
                if(_this.isEdit)
                    _this.disableEditMode();
                _this.loadBoard();
            });
          
        },
        async submitTagForm(){
            const valid = await this.v$.tagForm.$validate()
            if (!valid) return
            this.addTag(this.tagForm);
            this.clearTagForm();
        },
        clearCardForm(){
            this.cardForm = { name:null,list_id: null, tags:[] };
            this.v$.cardForm.$reset()
        },
        clearTagForm(){
            this.tagForm.name = null;
            this.v$.tagForm.$reset();
        },
        addTag(tag){
            this.cardForm.tags.push(copyObject(tag));
        },
        removeTag(index){
            this.cardForm.tags.splice(index, 1);
        },
        
        toDone(id){
            var _this = this;
            this.putAxios('/ajax/todo/board/'+this.board.id+'/card/'+id+'/done', {}, function (response) {
                _this.loadBoard()
            },
            ()=>{},
            (r)=>{
                _this.errorMsg('Не удалось',r.data.msg);
                _this.loadBoard()
            },
            );
        },
        toUndone(id){
            var _this = this;
            this.putAxios('/ajax/todo/board/'+this.board.id+'/card/'+id+'/undone', {}, function (response) {
                _this.loadBoard()
            },
            ()=>{},
            (r)=>{
                _this.errorMsg('Не удалось',r.data.msg);
                _this.loadBoard()
            },
            );
        },
        onChangeDone(card){
            card.done ? this.toDone(card.id) : this.toUndone(card.id)
        },
        removePhoto(){
            this.cardForm.photo = null;
        },
        sortedList (cards) {
            var _this = this
            if(this.search)
                cards = _.filter(cards,function( card ) { return card.name.indexOf( _this.search ) !== -1; });
            if(this.searchTags.length)
                cards = _.filter(cards,function( card ) { return card.tags.filter((tag) => _this.searchTags.includes(tag.name) ).length; });
            
            cards.sort((a, b) =>  a.id > b.id ?  -1 : 1);
            cards.sort((a, b) =>  (a.done === b.done)? 0 : a.done? 1 : -1);

            return cards;
        },
    }
}
</script>

<style lang="scss">
.loading-box{
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: opacity 0.6s ease;
    background-color: rgba( #ffffff,.9);
    opacity: .5;
    z-index:3;
    padding: 5px;

}


.tag{
    cursor: pointer;
}
.card-modal
{   
    
    .image-box{
        display: flex;
        position: relative;
        width: 150px;
        height: 150px;

        &__remove-button{
            position: absolute;
            top:0;
            right: 0;
            background: none;
            border: 0;
            transition: opacity 0.5s ease;
            background-color: rgba( #ffffff,.9);
            opacity: .5;
            z-index:2;
            padding: 5px;
            &:hover{
                opacity: 1;
            }
        }
    }
}
.list-card{
    overflow: hidden;
    &__image-box{
        align-self: center;
        max-width: 200px;
    }
    &__img{
        width: 100%;
    }
    &__title{
    }
    &__body{
        position: relative;
        padding-right: 60px;
    }
}
.card-actions{
    position: absolute;
    top:0;
    right: 0;
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    transition: opacity 0.5s ease;
    background-color: rgba( #ffffff,.9);
    opacity: .5;
    z-index:2;
    padding: 5px;
    &:hover{
        opacity: 1;
    }
}
.card-action{
    display: flex;
    background: none;
    border: 0;
}
</style>