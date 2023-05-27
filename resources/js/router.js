import Vue from 'vue'
import Router from 'vue-router'
import store from './store'
Vue.use(Router);

import Login from './views/auth/Login.vue'
import Register from "./views/auth/Register.vue";
import Posts from './views/posts/Index.vue'
import CreatePost from './views/posts/Create.vue'
import ShowPost from './views/posts/Show.vue'
import ShowConversation from './views/conversations/Show.vue'
import NotFound from './views/pages/404.vue'

let router = new Router({
    mode : 'history',
    routes : [
        {
            path : '/login',
            name : 'login',
            component: Login
        },
        {
            path : '/register',
            name : 'register',
            component: Register
        },
        {
            path : '/',
            name : 'posts',
            component : Posts,
            meta : {requiresAuth : true}
        },
        {
            path : '/posts',
            name : 'posts',
            component: Posts,
            meta: {requiresAuth : false}
        },
        {
            path : '/posts/create',
            name : 'posts.create',
            component: CreatePost,
            meta: {requiresAuth : true}
        },
        {
            path : '/posts/chat/:post',
            name : 'posts.chat',
            component: ShowPost,
            meta: {requiresAuth : true}
        },
        {
            path : '/conversations/:conversation',
            name : 'conversation.show',
            component: ShowConversation,
            meta: {requiresAuth : true}
        },
        {
            path: '/404',
            component: NotFound,
            meta: {requiresAuth: true}
        },
        {
            path: '*',
            redirect: '/404',
            meta: {requiresAuth: true}
        },

    ],
    scrollBehavior(to,from,savedPosition){
        if (savedPosition) {
            return savedPosition
        } else {
            return { x: 0, y: 0 }
        }
    }
})

router.beforeEach((to,from,next)=>{
    const requiresAuth = to.matched.some(record => record.meta.requiresAuth);
    const isLogged = store.state.auth.is_logged;
    if(!requiresAuth && isLogged && (to.path === '/login' || to.path === '/register')){
        next('/')
    }
    if(requiresAuth && !isLogged){
        next('/login');
    }else{
        next()
    }
})

export default router;
