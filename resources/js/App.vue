<template>
    <div>
        <loading :active.sync="loading" />
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm" v-if="is_logged">
            <div class="container">
                <router-link class="navbar-brand" to="/">
                    Servicios Online
                </router-link>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->

                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{ user.name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown" @click="logout">
                                <a class="dropdown-item">
                                    Salir
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="wrapper fixed-left">
            <div id="content" class="py-4_">
                <router-view></router-view>
            </div>

        </div>
        <!--main class="py-4">
            <router-view></router-view>
        </main-->
    </div>
</template>
<script>
    import {mapState,mapGetters,mapActions,mapMutations} from 'vuex'
    import Loading from 'vue-loading-overlay'
    import 'vue-loading-overlay/dist/vue-loading.css'
    export default {
        components:{
            Loading
        },
        mounted() {
            this.checkSession()
        },
        methods:{
            ...mapActions('auth',['logout']),
            ...mapMutations('auth',['checkSession'])
        },
        computed:{
            ...mapState(['loading']),
            ...mapState('auth',['is_logged','user']),
            ...mapGetters('auth',['user'])
        }
    }
</script>
<style>
*, *:after, *:before {
    box-sizing:border-box;
    -moz-box-sizing:border-box;
    -webkit-box-sizing:border-box;
}
.blue {
    background: #2abdfc;
    color: #fff;
}
.navbar {
    padding: 10px 10%;
}
#logo {
    display: inline-block;
    margin-top: 7px;
    color: #fff;
}
#link {
    color: #fff;
    font-weight: bold;
    margin: 0 10px;
}
i { margin: 0 7px; }
#sidebarCollapse {
    color: #fff;
    background: transparent;
    outline: none;
    margin: 0 20px;
}
#sidebarCollapse:hover {
    color: #2abdfc;
    background: #fff;
    outline: none;
}
.wrapper {
    display: flex;
    width: 100%;
    align-items: stretch;
}.wrapper {
     display: flex;
     width: 100%;
     align-items: stretch;
 }

#sidebar ul li.active>a,
a[aria-expanded="true"] {
    color: #fff;
    background: #8a5fff;
}
a[data-toggle="collapse"] {
    position: relative;
}
.dropdown-toggle::after {
    display: block;
    position: absolute;
    top: 50%;
    right: 20px;
    transform: translateY(-50%);
}

#content {
    width: 100%;
    padding: 40px;
    min-height: 100vh;
    transition: all 0.3s;
}
@media (max-width:800px) {
    #sidebar {
        margin-left: -250px;}
    #sidebar.active{
        margin-left: 0px;
    }
    #sidebarCollapse span{
        display: none;
    }
    .card {
        width:100%;
    }
}
@media (max-width:400px) {
    #sidebar {
        margin-top: -20px;
    }
    #logo {
        display: none;
    }
}
</style>
