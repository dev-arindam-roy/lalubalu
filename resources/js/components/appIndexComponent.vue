<template>
    <div id="appIndex">
        <header-nav :is-user-logged-in="isLogeedin" v-show="isNavRequired"></header-nav>
        <router-view :key="$route.path"></router-view>
    </div>
</template>

<script>
import headerNav from '../components/headerNavComponent.vue'
export default {
    name : 'app-index',
    props:{
        isNavRequired: {
            type: Boolean,
            default: true
        } 
    },
    components: {
        headerNav
    },
    data() {
        return {
            isLogeedin: false,
        }
    },
    mounted() {
        var _this = this;
    }
}
</script>

<style scoped>

</style>
