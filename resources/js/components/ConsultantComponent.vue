<template>
    <div class="full-chat-section d-flex">
        <div class="chat-left d-flex flex-column">
            <h2>My Customers</h2>
            <div :class="[customer.id == current_customer.id ? 'chat-model d-flex active' : 'chat-model d-flex']" v-for="customer in customers" :key="customer.id">
                <div class="chat-icon">
                    <img :src="customer.prof_image" v-if="customer.prof_image != '' && customer.prof_image != undefined" alt="no-image"/>
                    <b v-else>{{customer.user.first_name[0]}}{{customer.user.last_name[0]}}</b>
                </div>
                <div :class="[customer.user.status == 'Available' ? 'chat-details d-flex flex-column' : customer.user.status == 'Offline' ? 'chat-details d-flex flex-column offline' : 'chat-details d-flex flex-column in-call']">
                    <b>{{customer.user.first_name}} {{customer.user.last_name}} <span>{{customer.user.status}}</span></b>
                    <legend>{{customer.industry_expertise}}</legend>
                    <p>Lorem Ipsum er rett og slett dummy</p>
                    <p>tekst fra og for trykkeindustrien..</p>
                </div>
            </div>
        </div>
        <div :class="[!is_chat?'select-box' : 'select-box none']">
            <div class="step">
                <img src="/images/chat.png" alt="no-image"/>
                <p><b>No customers selected.</b></p>
                <p class="text">Select a customer you would like to chat, voice or video call with.</p>
            </div>
        </div>
        <div :class="[is_chat?'chat-room' : 'chat-room none']">
            <div class="chat-right d-flex flex-column">
                <div class="chat-profile d-flex flex-wrap">
                    <div class="end-chat-right d-flex">
                        <button class="btn">End Session</button>
                    </div>
                </div>
                <div class="chat-history d-flex flex-column" id="scroll-view">
                    <div class="chat-list" v-for="(message, index) in messages" v-bind:key="message.index">
                        <div class="date-separate" v-if="(messages[index + 1] && messages[index + 1].timestamp.toDateString() != message.timestamp.toDateString() && messages[0].timestamp.toDateString() != message.timestamp.toDateString())|| index == 0">
                            <legend><span>{{ message.timestamp.toDateString() == today ? 'Today': message.timestamp.toDateString() }}</span></legend>
                        </div>
                        <div class="self" v-if="message.author === authUser.email">
                            <label>{{ message.timestamp.toLocaleTimeString() }}</label>
                            <div class="identity">
                                <p>{{ message.body }} </p>
                                <img :src="authConsultant.prof_image" v-if="authConsultant.prof_image != ''" alt="no-image"/>
                                <b v-else>{{authUser.first_name[0]}}{{authUser.last_name[0]}}</b>
                            </div>
                        </div>
                        <div class="other" v-if="message.author != authUser.email">
                            <label>{{ message.timestamp.toLocaleTimeString() }}</label>
                            <div class="identity">
                                <img :src="current_customer.prof_image" v-if="current_customer.prof_image != ''" alt="no-image"/>
                                <b v-else>{{current_customer.user.first_name[0]}}{{current_customer.user.last_name[0]}}</b>
                                <p>{{ message.body }} </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="write-text d-flex flex-column">
                    <span><input type="text" placeholder="Write message here...." v-model="newMessage" @keyup.enter="sendMessage"/></span>
                    <div class="send-msg d-flex">
                        <button class="btn" v-on:click="sendMessage()">Send</button>
                        <input type="checkbox" id="fruit1" name="fruit-1" value="Apple"/>
                        <label id="sms" for="fruit1">SMS</label>
                        <input type="checkbox" id="fruit4" name="fruit-4" value="Strawberry">
                        <label id="inapp" for="fruit4">In App</label>
                    </div>
                </div>
            </div>
        </div>
        <div id="call-dialog" v-show="is_modal" class="v-modal">
            <div class="modal-wrapper">
                <div class="modal-container">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <img :src="incoming_user.prof_image" v-if="incoming_user.prof_image != '' && incoming_user.prof_image != undefined" alt="no-image"/>
                        <img src="/images/home/person.png" v-else />
                        <p>Incoming call from {{incoming_user.name}}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" ref="accept_btn"><img src="/images/home/ph.png"/></button>
                        <button type="button" ref="hangup_btn"><img src="/images/home/ph-e.png"/></button>
                    </div>
                </div>
            </div>
        </div>
        <div id="video-request-dialog" v-show="is_video_request_modal" class="v-modal">
            <div class="modal-wrapper">
                <div class="modal-container">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <img :src="incoming_user.prof_image" v-if="incoming_user.prof_image != '' && incoming_user.prof_image != undefined" alt="no-image"/>
                        <img src="/images/home/person.png" v-else />
                        <p>Incoming video call from {{incoming_user.name}}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" ref="accept_btn"><img src="/images/home/video.png"/></button>
                        <button type="button" ref="hangup_btn"><img src="/images/home/video-e.png"/></button>
                    </div>
                </div>
            </div>
        </div>
        <div id="video-dialog" v-show="is_video_modal" class="v-modal video">
            <div class="modal-wrapper">
                <div class="modal-container">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div ref="video_tag" class="main"></div>
                        <div ref="self_video_tag" class="self"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" ref="video_hangup_btn"><img src="/images/home/video-e.png"/></button>
                    </div>
                </div>
            </div>
        </div>
        <div id="chat-dialog" v-show="is_chat_request_modal" class="v-modal" role='dialog'>
            <div class="modal-wrapper">
                <div class="modal-container">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <img :src="incoming_user.prof_image" v-if="incoming_user.prof_image != '' && incoming_user.prof_image != undefined" alt="no-image"/>
                        <img src="/images/home/person.png" v-else />
                        <p>Incoming chat request from {{incoming_user.name}}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" v-on:click="chatAccept()" ><img src="/images/home/msg.png"/></button>
                        <button type="button" v-on:click="chatReject()"><img src="/images/home/msg-e.png"/></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from '../Http';
    import { Device } from 'twilio-client';
    const Video = require('twilio-video');
    const { connect, createLocalTracks, createLocalVideoTrack } = require('twilio-video');
    export default {
        name:"consultant-component",
        props: {
            authUser: {
                type: Object,
                required: true
            },
            _customers: {
                type: Array,
                required: true
            },
            authConsultant: {
                type: Object,
                required: true
            }
        },
        data() {
            return {
                customers: [],
                messages: [],
                newMessage: '',
                channel: '',
                device: new Device(),
                activeRoom: null,
                incoming_user: {
                    id: '',
                    name: '',
                    request_min: '',
                    prof_image: '',
                    min: ''
                },
                current_customer: {
                    user: {}
                },
                is_chat: false,
                is_modal: false,
                is_video_request_modal: false,
                is_video_modal: false,
                is_chat_request_modal: false,
                is_chat_session: false
            };
        },
        mounted() {
            console.log("consultant chat service started!");
            var today = new Date();
            this.today = today.toString().split(' ')[0] + " " + today.toString().split(' ')[1] + " " + today.toString().split(' ')[2] + " " + today.toString().split(' ')[3];
            this.customers = this._customers;
            axios.post('/api/manage_status', { id: this.authUser.id, status: "Available" });
            
            let self = this;

            // set Twilio Call Client with own name token
            this.initializeCallClient();

            this.$socket.onopen = () => {
                this.$socket.onmessage = (data) => {
                    var msg = JSON.parse(data.data);
                    if (msg.type == 'token') {
                        self.voice_token_name = msg.token;
                    } else if (msg.type == 'request') {
                        self.incoming_user.id = msg.id;
                        self.incoming_user.name = msg.name;
                        self.incoming_user.min = msg.min;
                        self.incoming_user.image = msg.image;
                        if (msg.sub_type == 'chat_pause') {
                            self.is_chat_session = false;
                        } else if (msg.sub_type == 'chat_continue') {
                            self.is_chat_session = true;
                        } else if (msg.sub_type == 'chat_start') {
                            self.is_chat_request_modal = true;
                            self.customers.forEach((customer) => {
                                if (customer.user.id == msg.id) {
                                    self.current_customer = customer;
                                }
                            });
                        } else if (msg.sub_type == 'chat_end') {
                            self.incoming_user = {};
                            self.current_customer = {};
                            self.is_chat = false;
                            self.$socket.sendObj({ command: "message",  id: self.authUser.id, type: 'status', msg: 'Available' });
                        }
                    } else {
                        this.customers.forEach((customer) => {
                            if (customer.user.id == msg.id) {
                                customer.user.status = msg.status;
                                this.current_customer = customer;
                            }
                        });
                        axios.post('/api/manage_status', { id: msg.id, status: msg.status });
                    }
                };
                this.$socket.sendObj({ command: "subscribe",  channel: this.authUser.id });
            }
            
            // get call incoming event
            this.device.incoming(async function(connection) {
                var type = connection.customParameters.get('type');
                var roomName = connection.customParameters.get('roomName');
                if (type == 'voice') {
                    self.is_modal = true;
                    self.$refs.accept_btn.addEventListener('click', () => {
                        connection.accept();
                    });
                } else {
                    self.is_video_modal = true;
                    connection.reject();
                    
                    if (self.$refs.self_video_tag.children.length == 0) {
                        createLocalVideoTrack({audio: true, video: { width: 150 }}).then(track => {
                            self.$refs.self_video_tag.appendChild(track.attach());
                        });
                    }

                    const { data } = await axios.post("/api/video_token", { "userName": self.authUser.first_name + self.authUser.last_name, "roomName": roomName});
                    Video.connect(data.token, {"name": roomName, 'logLevel': 'debug'}).then((room) => {
                        console.log('Successfully joined a Room: ', room);
                        self.activeRoom = room;

                        axios.post('/api/manage_status', { id: self.authUser.id, status: "In a video call" });
                        self.$socket.sendObj({ command: "message",  id: self.authUser.id, type: 'status', msg: 'In a video call' });

                        room.participants.forEach(self.participantConnected);

                        room.on('participantConnected', self.participantConnected);
                        
                        room.on('participantDisconnected', self.participantDisconnected);

                        room.once('disconnected', error => room.participants.forEach(self.participantDisconnected));
                    }, (err) => {
                        console.error('Unable to connect to Room: ' +  err.message);
                    });
                }
            });
            // get call disconnect event
            this.device.disconnect(function(connection) {
                self.is_modal = false;
            });
            this.$refs.hangup_btn.addEventListener('click', () => {
                self.is_modal = false;
                self.device.disconnectAll();
                axios.post('/api/manage_status', { id: self.authUser.id, status: "Available" });
            });
            this.$refs.video_hangup_btn.addEventListener('click', () => {
                self.is_video_modal = false;
                if (self.activeRoom) {
                    self.activeRoom.localParticipant.tracks.forEach(function(track) { 
                        track.stop();
                    });
                    self.activeRoom.disconnect();
                    axios.post('/api/manage_status', { id: self.authUser.id, status: "Available" });
                }
            });
            this.device.connect(function(connection) {
                axios.post('/api/manage_status', { id: self.authUser.id, status: "In a call" });
                self.$socket.sendObj({ command: "message",  id: self.authUser.id, type: 'status', msg: 'In a call' });
                
                setTimeout(function() {
                    self.is_modal = false;
                    self.device.disconnectAll();
                    axios.post('/api/manage_balance', { id: self.incoming_user.id, cost: Number(self.authUser.hourly_rate) * Number(self.incoming_user.min) }).then((res)=>{
                        console.log('managing balance is completed.');
                    });
                }, self.incoming_user.min * 60 * 1000);
            });
            this.device.ready(function (device) {
                console.log("Ready");
            });
            this.device.error(function (error) {
                console.error("ERROR: " + error.message);
                if (error.code == '31205') {
                    self.initializeCallClient();
                }
            });
        },
        methods: {
            // chat module
            scrollToEnd() {
                var container = this.$el.querySelector("#scroll-view");
                container.scrollTop = container.scrollHeight;
            },
            async chatAccept() {
                this.$socket.sendObj({ command: "message",  id: this.current_customer.user.id, customer_id: '', customer_name: 'accepted', type: 'request', msg: '' });
                this.is_chat_request_modal = false;
                this.is_chat = true;
                this.is_chat_session = true;
                axios.post('/api/chat_channel', { customer_email: this.current_customer.user.email, customer_id: this.current_customer.user.id, consultant_id: this.authUser.id, consultant_email: this.authUser.email })
                .then((response) => {
                    console.log('chat channel fetched!');
                });
                const chat_token = await this.fetchChatToken();
                await this.initializeChatClient(chat_token, this.current_customer.user.id);
                await this.fetchMessages();
                this.scrollToEnd();
            },
            chatReject() {
                this.$socket.sendObj({ command: "message",  id: this.current_customer.user.id, customer_id: '', customer_name: 'rejected', type: 'request', msg: '' });
                this.is_chat_request_modal = false;
            },
            async fetchChatToken() {
                const { data } = await axios.post("/api/chat_token", { email: this.authUser.email });
                return data.token;
            },
            async initializeChatClient(token, id) {
                const client = await Twilio.Chat.Client.create(token);
                client.on("tokenAboutToExpire", async () => {
                    const token = await this.fetchChatToken();
                    client.updateToken(token);
                });
                this.channel = await client.getChannelByUniqueName(`private-${this.authUser.id}-${id}`);
                this.channel.on("messageAdded", message => {
                    if (this.messages[this.messages.length-1].state.index != message.state.index) {
                        this.messages.push(message);
                        let self = this;
                        setTimeout(function() {
                            self.scrollToEnd();
                        }, 100);
                    }
                });
            },
            async fetchMessages() {
                this.$socket.sendObj({ command: "message",  id: this.authUser.id, type: 'status', msg: 'In a chat' });
                this.messages = (await this.channel.getMessages()).items;
            },
            sendMessage() {
                if (this.is_chat_session && this.current_customer.user.status != 'Offline') {
                    this.channel.sendMessage(this.newMessage);
                    this.newMessage = "";
                }
            },
            // call module
            async initializeCallClient() {
                axios.post("/api/new_token", { "name": this.authUser.first_name + this.authUser.last_name } ).then((res) => {
                    this.device.setup(res.data.token, { debug: true });
                });
            },
            // video module
            participantConnected(participant) {
                console.log('Participant "%s" connected', participant.identity);
                
                const div = document.createElement('div');
                div.ref = participant.sid;
                div.innerText = participant.identity;
                
                participant.on('trackSubscribed', track => this.trackSubscribed(div, track));
                participant.tracks.forEach(track => this.trackSubscribed(div, track));
                participant.on('trackUnsubscribed', this.trackUnsubscribed);
                
                this.$refs.video_tag.appendChild(div);
            },
            participantDisconnected(participant) {
                console.log('Participant "%s" disconnected', participant.identity);
                participant.tracks.forEach(this.trackUnsubscribed);
                var ref = participant.sid;
                this.$refs.ref.remove();
            },
            trackSubscribed(div, track) {
                if (div) {
                    div.appendChild(track.attach());
                }
            },
            trackUnsubscribed(track) {
                track.detach().forEach(element => element.remove());
            }
        }
    }
</script>
