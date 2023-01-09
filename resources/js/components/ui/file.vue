
<template>
<div class="ui-file">
    <div class="row gx-5">
        <div class="col-sm-12">
            <button type="button" class="btn btn-primary ui-file__button" @click.prevent="openExplorer">Прикрепить файл</button>
        </div>
        <div class="col-xs-24 col-sm-12"> 
            <div class="ui-file__list" v-if="files.length">
                <div class="ui-file__files">
                    <span class="ui-file__file"  v-for="name in getFilesName()" :key="name">{{name}}</span>
                </div>
                <div v-if="files.length" class="ui-file__button-reset " @click="resetFile()">&times;</div>
            </div>
          
        </div>
    </div>
    <div class="ui-file__footer">
        <div class="">
            {{ 'Форматы'+ accept }}
        </div>
        <div class="">
            {{ 'Максимальынй размер '+ printMaxSize() }}
        </div>
    </div>
    <input :multiple="multiple"  type="file" :name="name" id="" @change="fileChange" ref="file"  :accept="accept">
</div>

</template>
<script>

export default {
    name:'v-file',
    props:{
        accept:{
            type: String,
            default: function() {
                return '.doc, .docx,.odt,.txt,.pdf'
            }
        },
        maxSize:{
            type: Number,
            default: function() {
                return  1*1024*1024 // 1 MB
            }
        },
        multiple:{
            type: Boolean,
            default: function() {
                return false
            }
        },
        name:{
            type: String,
            default: function() {
                return 'file'
            }
        },
    },
    data(){
        return {
            files: '',

        }
    },
    methods:{

        /**
         * getters 
         */
        getFilesName(){
            let names = []
            for (let index = 0; index < this.files.length; index++) {
                names.push(this.files[index].name);
            }
            return names;
        },
        /**
         * staff functions
         */
        fileChange(event){
            event.preventDefault();

            let files = event.target.files

            for (let i = 0; i < files.length; i++) {
                if (files[i].size > this.maxSize) {
                    this.warningMsg('Превышен размер файла');
                    return;
                }
            }
             
      
            this.files = event.target.files
        },
        resetFile(){
            this.files = []
            this.$refs.file.value = '';
        },
        openExplorer(){
            this.$refs.file.click()
        },
        printMaxSize(){
            var kb = 1024;
            var mb = 1024*kb;
            if(this.maxSize>mb)
                return parseFloat(this.maxSize/mb).toFixed(1)+' Mb';
            
            return parseFloat(this.maxSize/kb).toFixed(1)+' Kb';


        }
    },
    
}
</script>
