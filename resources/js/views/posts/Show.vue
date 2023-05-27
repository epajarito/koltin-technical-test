<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 my-2">
                <div class="card">
                    <div class="card-header border-0">
                        <h3 class="mb-0 float-left">{{ post.attributes.title }}</h3>
                        <div class="w-50 float-right text-right">
                            <button class="btn btn-sm btn-primary" @click="createConversation" v-if="user.id !== post.attributes.user_id">
                                INBOX
                            </button>
                            <button class="btn btn-sm btn-success" @click="seeInbox" v-else>
                                Ver INBOX
                            </button>
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
                        <div class="msg_history" id="messagesBox" @scroll="onScroll">
                            <div
                                v-for="message in items"
                                :class="message.attributes.self ? 'outgoing_msg' : 'incoming_msg' "
                            >
                                <div v-if="!message.attributes.self" class="received_msg">
                                    <div class="received_withd_msg">
                                        <p>
                                            <b>{{ message.relationships.sender.name }}</b>: {{ message.attributes.message }}
                                        </p>
                                        <attachment-component :attachment="message.relationships.attachment" />
                                        <span class="time_date">
                                            {{ message.attributes.created_at_raw }}    |    {{ message.attributes.created_at }}
                                        </span>
                                    </div>
                                </div>
                                <div class="sent_msg" v-else>
                                    <p>{{ message.attributes.message }}</p>
                                    <attachment-component :attachment="message.relationships.attachment" />
                                    <span class="time_date">
                                        {{ message.attributes.created_at_raw }}    |    {{ message.attributes.created_at }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="type_msg">
                            <div class="input-group">
                                <input type="text" v-model="content" class="form-control" placeholder="Escribe un mensaje" aria-label="" aria-describedby="button-addon4">
                                <div class="input-group-append" id="button-addon4">
                                    <label class="btn btn-outline-secondary" @click="onSubmit" type="button">
                                        Enviar
                                    </label>
                                    <input type="file" style="display: none;" id="attachment" @change="onChangeInpFile" accept="image/*, audio/mp3, audio/m4a">
                                    <label class="btn btn-outline-secondary" for="attachment">
                                        Adjunto
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="seeChats" tabindex="-1" aria-labelledby="seeChats" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="seeChatsLabel">Chats</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <ul>
                                <li v-for="chat in post.relationships.conversations.data">
                                    <a href="#" @click="goToConversation(chat.id)">
                                        {{ chat.relationships.user.name }}
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import {mapActions,mapGetters,mapState} from 'vuex'
import AttachmentComponent from "../../components/Attachment.vue";
export default {
    components: {
        'attachment-component': AttachmentComponent
    },
    data(){
        return{
            items: [],
            content: '',
            attachment: '',
        }
    },
    async mounted() {
        await this.show(this.$route.params.post);
        let url = `/messages?post_id=${this.post.id}`;
        await this.get(url)
        this.items = this.messages.reverse();
        this.scrollToElement()
    },
    methods:{
        ...mapActions({
            'show' : 'posts/show',
            'store': 'messages/store',
            'get' : 'messages/get',
            'storeConversation' : 'conversations/store'
        }),
        async onSubmit(){
            let formData = new FormData();
            formData.append('message',this.content)
            formData.append('user_id_sender',this.user.id)
            formData.append('post_id', this.post.id);
            formData.append('user_id_receiver', this.post.attributes.user_id)
            if (this.attachment) {
                formData.append('file', this.attachment)
            }
            await this.store(formData)
            if(this.created){
                this.items = [...this.items, this.message];
                this.content = "";
                this.attachment = '',
                this.scrollToElement();

            }
        },
        scrollToElement() {
            setTimeout(()=>{
                var container = this.$el.querySelector("#messagesBox");
                container.scrollTop = container.scrollHeight;
            },350)
        },
        async onScroll ({ target: { scrollTop, clientHeight, scrollHeight }}) {
            if (scrollTop === 0) {
                if(!this.pagination.next){
                    return;
                }
                await this.get(this.pagination.next)
                let tmp = this.items;
                this.items = [...this.messages, ...tmp].sort((a,b)=> a.attributes.timestamp - b.attributes.timestamp)
            }
        },
        async createConversation() {
            let formData = new FormData();
            formData.append('user_id_sender',this.user.id)
            formData.append('post_id', this.post.id);
            formData.append('user_id_receiver', this.post.attributes.user_id)
            await this.storeConversation(formData)
            this.$router.push({ name: 'conversation.show', params: { conversation: this.conversation.id } })
        },
        seeInbox(){
            $('#seeChats').modal('toggle')
        },
        goToConversation(conversationId){
            $('#seeChats').modal('toggle')
            this.$router.push({ name: 'conversation.show', params: { conversation: conversationId } })
        },
        onChangeInpFile(e){
            let files = e.target.files || e.dataTransfer.files
            if(!files.length){
                return;
            }
            this.attachment = files[0]
        }
    },
    computed:{
        ...mapGetters({
            'user' : 'auth/user',
            'post' : 'posts/post',
            'messages' : 'messages/messages',
            'message' : 'messages/message',
            'pagination' : 'messages/pagination',
            'conversation' : 'conversations/conversation',
        }),
        ...mapState(['created'])
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
