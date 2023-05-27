import Vue from 'vue'
export async function get({commit},url = '/chats') {
    try{
        commit('setLoading',true,{root : true})
        let {data} = await Vue.axios({
            method : 'GET',
            url
        });
        commit('chats',data)
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
        let {data} = await Vue.axios({
            method : 'POST',
            data : form,
            url : '/chats',
            headers : {
                'content-type': 'multipart/form-data'
            }
        });
        commit('setCreated',true,{root:true})
        commit('chat', data)
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
