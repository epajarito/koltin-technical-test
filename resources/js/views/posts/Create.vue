<template>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        Crear Publicación
                    </div>

                    <div class="card-body">
                        <form-component
                            :post="post"
                            :on-submit="onSubmit"
                        >
                        </form-component>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import formComponent from './_form'
import {mapActions,mapGetters,mapState} from 'vuex'
export default {
    components : {
        formComponent
    },
    data(){
        return{
            post : {}
        }
    },
    methods:{
        ...mapActions('posts',['store','get']),
        async onSubmit(){
            let formData = new FormData();
            for(let i in this.post){
                formData.append(i,this.post[i])
            }
            formData.append('user_id',this.user.id)
            await this.store(formData)
            if(this.created){
                await this.get();
                this.$router.push('/posts')
            }
        }
    },
    computed:{
        ...mapGetters({
            'user' : 'auth/user',
            '_post' : 'posts/post',
            'posts' : 'posts/posts',
        }),
        ...mapState(['created'])
    }
}
</script>
