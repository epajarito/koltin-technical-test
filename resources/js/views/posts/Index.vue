<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 my-2">
                <div class="card">
                    <div class="card-header border-0">
                        <h3 class="mb-0 float-left">Publicaciones</h3>
                        <div class="w-50 float-right text-right">
                            <router-link class="btn btn-sm btn-primary" to="/posts/create">
                                Nueva Publicación
                            </router-link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <card class="card-body">
                        <div class="row">
                            <div class="col-12 my-3" v-for="post in posts">
                                <div class="card card-custom">
                                    <img :src="post.attributes.image" class="card-img-top" :alt="post.attributes.title">
                                    <div class="card-body">
                                        <h5 class="card-title">
                                            {{ post.attributes.title }}
                                        </h5>
                                        <p class="card-text">
                                            {{ post.attributes.description }}
                                        </p>
                                        <router-link :to="`/posts/chat/${post.id}`" class="btn btn-primary">
                                            CHAT
                                        </router-link>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </card>
                </div>
                <div class="card-footer py-4">
                    <pagination-component v-if="pagination" :pagination="pagination" :fetchItems="fetchItems"/>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import {mapGetters,mapActions,mapState} from 'vuex'
import PaginationComponent from '../../components/Pagination.vue'
export default {
    components:{
        PaginationComponent
    },
    data(){
        return {
            post : {}
        }
    },
    mounted() {
        this.fetchItems();
    },
    methods:{
        ...mapActions({
            'get' : 'posts/get'
        }),
        async fetchItems(url){
            this.get(url)
        }
    },
    computed:{
        ...mapGetters({
            'posts' : 'posts/posts',
            'pagination' : 'posts/pagination',
        }),
        ...mapState('posts',['errors']),
    }
}
</script>
<style scoped>
.card-custom {
    flex-direction: row;
}
.card-custom img {
    width: 30%;
}
</style>

