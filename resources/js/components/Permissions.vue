<template>
<v-loading :status="loading"></v-loading>
<h3>Разрешения для доски "{{ board.name  }}"</h3>
<hr>
<div class="row">
    <div class="col-md-6">
        <input class="form-control me-2 mb-2" type="search" placeholder="Email" v-model="newUser">

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
                <tr>
                <td>Mark</td>
                <td>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" checked>
                    </div>
                </td>
                <td>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch">
                    </div>
                </td>
                <td>
                    <button type="button" class="btn btn-danger"><i class="bi bi-trash-fill"></i></button>
                </td>

                </tr>
               
            </tbody>
        </table>
    </div>
</div>

</template>

<script>

export default {

    data(){
        return {
            board:{},
            newUser: null
        }
    },

    mounted() {
        this.loadBoard()
    },
    methods:{
        loadBoard(){
            var _this = this;
            this.getAxios('/ajax/todo/board/'+boardId, {}, function (response) {
                _this.board = response.data.board;
            });
        },
    }
}
</script>

