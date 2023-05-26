<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 my-2">
                <div class="card">
                    <div class="card-header border-0">
                        <h3 class="mb-0 float-left">{{ post.attributes.title }}</h3>
                        <div class="w-50 float-right text-right">
                            <router-link class="btn btn-sm btn-primary" to="/posts">
                                Ver publicaciones
                            </router-link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="messaging">
                    <div class="mesgs">
                        <div class="msg_history">
                            <div class="" v-for="message in post.relationships.messages" :class="message.attributes.self ? 'outgoing_msg' : 'incoming_msg' ">
                                <div v-if="!message.attributes.self" class="received_msg">
                                    <div class="received_withd_msg">
                                        <p>
                                            {{ message.relationships.sender.name }}: {{ message.attributes.message }}
                                        </p>
                                        <span class="time_date">
                                            {{ message.attributes.created_at_raw }}    |    {{ message.attributes.created_at }}
                                        </span>
                                    </div>
                                </div>
                                <div class="sent_msg" v-else>
                                    <p>{{ message.attributes.message }}</p>
                                    <span class="time_date">
                                        {{ message.attributes.created_at_raw }}    |    {{ message.attributes.created_at }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="type_msg">
                            <div class="input_msg_write">
                                <input v-model="form.message" type="text" class="form-control-sm" placeholder="Escribe un mensaje" />
                                <button class="msg_send_btn" type="button" @click="onSubmit">
                                    <i class="fa fa-paper-plane" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import {mapActions,mapGetters,mapState} from 'vuex'
export default {
    data(){
        return{
            form:{
                message: '',
                user_id: this.user.id,
                post_id: this.post.id
            }
        }
    },
    async mounted() {
        await this.show(this.$route.params.post);
        console.log(this.post.relationships.messages)
    },
    methods:{
        ...mapActions({
            'show' : 'posts/show',
            'storeMessage': 'posts/storeMessage'
        }),
        async onSubmit(){
            let formData = new FormData();
            for(let i in this.form){
                formData.append(i,this.form[i])
            }
            await this.storeMessage(formData)
            // if(this.created){
            //     await this.get();
            //     this.$router.push('/posts')
            // }
        }
    },
    computed:{
        ...mapGetters({
            'user' : 'auth/user',
            'post' : 'posts/post',
        }),
        ...mapState(['updated'])
    }
}
</script>
<style scoped>
.recent_heading h4 {
    color: #0465ac;
    font-size: 16px;
    margin: auto;
    line-height: 29px;
}

.srch_bar input {
    outline: none;
    border: 1px solid #cdcdcd;
    border-width: 0 0 1px 0;
    width: 100%;
    padding: 2px 0 4px 6px;
    background: none;
}

.srch_bar .input-group-addon button {
    background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
    border: medium none;
    padding: 0;
    color: #707070;
    font-size: 18px;
}

.srch_bar .input-group-addon {
    margin: 0 0 0 -27px;
}

.chat_ib h5 {
    font-size: 15px;
    color: #464646;
    margin: 0 0 8px 0;
}

.chat_ib h5 span {
    font-size: 13px;
    float: right;
}

.chat_ib p {
    font-size: 12px;
    color: #989898;
    margin: auto;
    display: inline-block;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.chat_img {
    float: left;
    width: 11%;
}

.chat_img img {
    width: 100%
}

.chat_ib {
    float: left;
    padding: 0 0 0 15px;
    width: 88%;
}

.chat_people {
    overflow: hidden;
    clear: both;
}

.chat_list {
    border-bottom: 1px solid #ddd;
    margin: 0;
    padding: 18px 16px 10px;
}

.inbox_chat {
    height: 550px;
    overflow-y: scroll;
}

.active_chat {
    background: #e8f6ff;
}

.incoming_msg_img {
    display: inline-block;
    width: 6%;
}

.incoming_msg_img img {
    width: 100%;
}

.received_msg {
    display: inline-block;
    padding: 0 0 0 10px;
    vertical-align: top;
    width: 92%;
}

.received_withd_msg p {
    background: #ebebeb none repeat scroll 0 0;
    border-radius: 0 15px 15px 15px;
    color: #646464;
    font-size: 14px;
    margin: 0;
    padding: 5px 10px 5px 12px;
    width: 100%;
}

.time_date {
    color: #747474;
    display: block;
    font-size: 12px;
    margin: 8px 0 0;
}

.received_withd_msg {
    width: 57%;
}

.mesgs{
    padding: 30px 15px 0 25px;
}

.sent_msg p {
    background:#0465ac;
    border-radius: 12px 15px 15px 0;
    font-size: 14px;
    margin: 0;
    color: #fff;
    padding: 5px 10px 5px 12px;
    width: 100%;
}

.outgoing_msg {
    overflow: hidden;
    margin: 26px 0 26px;
}

.sent_msg {
    float: right;
    width: 46%;
}

.input_msg_write input {
    background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
    color: #4c4c4c;
    font-size: 15px;
    min-height: 48px;
    width: 100%;
    outline:none;
}

.type_msg {
    border-top: 1px solid #c4c4c4;
    position: relative;
}

.msg_send_btn {
    background: #05728f none repeat scroll 0 0;
    border:none;
    border-radius: 50%;
    color: #fff;
    cursor: pointer;
    font-size: 15px;
    height: 33px;
    position: absolute;
    right: 0;
    top: 11px;
    width: 33px;
}

.messaging {
    padding: 0 0 50px 0;
}

.msg_history {
    height: 516px;
    overflow-y: auto;
}
</style>
