import Vue from 'vue'
import Vuex from 'vuex'
import VuexPersistence from "vuex-persist"
import {createStore} from 'vuex-extensions'
import router from './router'
Vue.use(Vuex)

import auth from './modules/auth'
import posts from './modules/posts'
import messages from  './modules/messages'
import conversations from "./modules/conversations";
import chats from "./modules/chats";

const vuexLocal = new VuexPersistence({
    key : process.env.MIX_VUE_APP,
    storage : window.localStorage
})

export default createStore(Vuex.Store,{
    state:{
        loading : false,
        updated : false,
        created : false,
        deleted : false
    },
    mutations : {
        setLoading(state,bool){
            state.loading = bool;
        },
        setUpdated(state,bool){
            state.updated = bool
        },
        setCreated(state,bool){
            state.created = bool
        },
        setDeleted(state,bool){
            state.deleted = bool
        },
        resetStore(){
            this.reset();
            setTimeout(()=>{
                router.push("/login");
            },75)
        },
        validateErrorResponse(state, {response}){
            if(response.status == 401 && (response.data.message == 'Unauthenticated.' || response.data.message == 'TOKEN_EXPIRED') ){
                this.commit('resetStore')
            }else if(response.status === 404){
                router.push('/404');
            }
        }
    },
    actions : {

    },
    modules : {
        auth,
        posts,
        messages,
        conversations,
        chats
    },
    plugins: [vuexLocal.plugin]
})
