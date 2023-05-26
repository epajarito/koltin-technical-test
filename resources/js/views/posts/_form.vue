<template>
    <form @submit.prevent="onSubmit(post)">

        <div class="form-group row">
            <label for="name" class="col-md-4 col-form-label text-md-right">
                Titulo
            </label>
            <div class="col-md-6">
                <input id="name" type="text" class="form-control" :class="{'is-invalid' : errors.hasOwnProperty('title')}" v-model="post.title" required autofocus>

                <span class="invalid-feedback" role="alert" v-if="errors.hasOwnProperty('title')">
                    <strong>
                        {{ errors.title[0] }}
                    </strong>
                </span>
            </div>
        </div>

        <div class="form-group row">
            <label for="created_at" class="col-md-4 col-form-label text-md-right">
                Descripción
            </label>

            <div class="col-md-6">
                <textarea id="created_at"  class="form-control" v-model="post.description" required></textarea>
                <span class="invalid-feedback" role="alert">
                    <strong>error</strong>
                </span>
            </div>
        </div>

        <div class="form-group row">
            <label for="image" class="col-md-4 col-form-label text-md-right">
                Imagen
            </label>
            <div class="col-md-6">
                <input id="image" type="file" class="form-control" :class="{'is-invalid' : errors.hasOwnProperty('image')}" @change="onChangeInpFile" required accept="image/*">
                <span class="invalid-feedback" role="alert" v-if="errors.hasOwnProperty('image')">
                    <strong>
                        {{ errors.image[0] }}
                    </strong>
                </span>
            </div>
        </div>

        <div class="form-group row mb-0">
            <div class="col-md-8 offset-md-4">
                <button type="submit" class="btn btn-primary">
                    Guardar
                </button>
            </div>
        </div>
    </form>
</template>
<script>
import {mapState} from 'vuex'
export default {
    props : ['post','onSubmit'],
    methods:{
        onChangeInpFile(e){
            let files = e.target.files || e.dataTransfer.files
            if(!files.length){
                return;
            }
            this.post.image = files[0]
        }
    },
    computed:{
        ...mapState('posts',['errors'])
    }
}
</script>
