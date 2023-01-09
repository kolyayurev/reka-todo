<template>
<transition name="fade">
    <div class="loading-box text-center" v-show="status">
        <div class="spinner-border" role="status">
            <span class="visually-hidden">Загрузка...</span>
        </div>
    </div>
</transition>
</template>
<script>
export default {
    props:{
        status: Boolean,
    }
}
</script>