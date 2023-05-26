import Vue from 'vue'
export async function get({commit},url = '/posts') {
    try{
        commit('setLoading',true,{root : true})
        let {data} = await Vue.axios({
            method : 'GET',
            url
        });
        commit('posts',data)
    }catch (error) {
        if(error.response){
            commit('validateErrorResponse',error,{root : true})
        }
    }finally {
        commit('setLoading',false,{root : true})
    }
}


export async function show({commit},id) {
    try{
        commit('setLoading',true,{root : true})
        let {data} = await Vue.axios({
            method : 'get',
            url : `/posts/${id}`
        })
        commit('post',data)
    }catch (error) {
        if(error.response){
            commit('validateErrorResponse',error,{root : true})
        }
    }finally {
        commit('setLoading',false,{root : true})
    }
}

export async function store({commit},form) {
    try{
        commit('setCreated',false,{root:true})
        commit('setLoading',true,{root : true})
        commit('errors', {data : {errors : {}}})
        await Vue.axios({
            method : 'post',
            data : form,
            url : '/posts',
            headers : {
                'content-type': 'multipart/form-data'
            }
        });
        commit('setCreated',true,{root:true})
    }catch (error) {
        if(error.response){
            commit('validateErrorResponse',error,{root : true})
            if(error.response.status === 422) {
                if (error.response.hasOwnProperty("data")) {
                    commit('errors', {data: error.response.data})
                }
            }
        }
    }finally {
        commit('setLoading',false,{root : true})
    }
}

export async function storeMessage({commit},form) {
    try{
        commit('setCreated',false,{root:true})
        commit('setLoading',true,{root : true})
        commit('errors', {data : {errors : {}}})
        await Vue.axios({
            method : 'post',
            data : form,
            url : '/messages',
            headers : {
                'content-type': 'multipart/form-data'
            }
        });
        commit('setCreated',true,{root:true})
    }catch (error) {
        if(error.response){
            commit('validateErrorResponse',error,{root : true})
            if(error.response.status === 422) {
                if (error.response.hasOwnProperty("data")) {
                    commit('errors', {data: error.response.data})
                }
            }
        }
    }finally {
        commit('setLoading',false,{root : true})
    }
}

export async function update({commit}, {form,id}) {
    try{
        commit('setUpdated',false,{root:true})
        commit('setLoading',true,{root : true})
        commit('errors', {data : {errors : {}}})
        await Vue.axios({
            method : 'post',
            url : `/posts/${id}`,
            data : form,
            headers : {
                'content-type': 'multipart/form-data'
            }
        })
        commit('setUpdated',true,{root : true})
    }catch(error){
        if(error.response){
            commit('validateErrorResponse', error, {root: true})
            if(error.response.status === 422){
                if(error.response.hasOwnProperty("data")){
                    commit('errors', {data : error.response.data})
                }
            }
        }
    }finally {
        commit('setLoading',false,{root : true})
    }
}

export async function destroy({commit},id) {
    try {
        commit('setLoading',true,{root : true})
        await Vue.axios({
            method : 'delete',
            url : `/posts/${id}`
        })
        commit('setDeleted',true,{root:true})
    }catch(error){
        if(error.response){
            commit('validateErrorResponse',error,{root : true})
        }
    }finally {
        commit('setLoading',false,{root : true})
    }
}
