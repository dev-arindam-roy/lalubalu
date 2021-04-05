<template>
    <div id="headerNav">
        <nav class="navbar navbar-expand-lg navbar-dark theme-dark-green-primary-bgcolor">
            <router-link class="navbar-brand" :to="{name: 'root.index'}">
                <img src="/public/assets/images/logo.png" style="width:32px;">
                <span><strong>Lalubalu</strong></span>
            </router-link>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarText">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <router-link class="nav-link" :to="{name: 'quick.digitalCard'}">Digital Card</router-link>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Market Place</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Search Petshop</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Search Doctor</a>
                    </li>
                </ul>
            </div>
            <div class="collapse navbar-collapse" id="navbarTogglerDemo01" v-if="!isUserLoggedIn">
                <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Create Account</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Sign In</a>
                    </li>
                </ul>
            </div>
            <div class="collapse navbar-collapse" id="navbarTogglerDemo01" v-if="isUserLoggedIn">
                <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="#">My Account</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Logout</a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</template>

<script>
export default {
    name : 'header-nav',
    props:{
        isUserLoggedIn: {
            type: Boolean,
            default: false
        } 
    },
    components: {
        
    },
    data() {
        return {

        }
    },
    mounted() {
        
    }
}
</script>

<style scoped>

</style>
