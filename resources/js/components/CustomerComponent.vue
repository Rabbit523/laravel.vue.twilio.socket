<template>
    <div class="full-chat-section d-flex">
        <div class="chat-left d-flex flex-column">
            <h2>My Consultants</h2>
            <div :class="[consultant.id == current_consultant.id ? 'chat-model d-flex active' : 'chat-model d-flex']" v-for="consultant in consultants" :key="consultant.id" v-on:click="selectChannel(consultant)">
                <div class="chat-icon">
                    <img :src="consultant.prof_image" v-if="consultant.prof_image != ''" alt="no-image"/>
                    <b v-else>{{consultant.user.first_name[0]}}{{consultant.user.last_name[0]}}</b>
                </div>
                <div :class="[consultant.user.status == 'Available' ? 'chat-details d-flex flex-column' : consultant.user.status == 'Offline' ? 'chat-details d-flex flex-column offline' : 'chat-details d-flex flex-column in-call']">
                    <b>{{consultant.user.first_name}} {{consultant.user.last_name}} <span>{{consultant.user.status}}</span></b>
                    <legend>{{consultant.industry_expertise}}</legend>
                    <p>Lorem Ipsum er rett og slett dummy</p>
                    <p>tekst fra og for trykkeindustrien..</p>
                </div>
            </div>
        </div>
        <div :class="[!is_chat?'select-box' : 'select-box none']">
            <div class="step" v-if="!is_selected && step == 'step0'">
                <img src="/images/chat.png" alt="no-image"/>
                <p><b>No consultants selected.</b></p>
                <p class="text">Select a consultant you would like to chat, voice or video call with.</p>
            </div>
            <div class="step" v-if="is_selected && step == 'step1'">
                <img src="/images/like.png" alt="no-image"/>
                <p><b>You have selected {{current_consultant.user.first_name}}.</b></p>
                <p>Let's get started with chat, voice or video call.</p>
                <div class="button-group">
                    <button class="btn" :disabled="current_consultant.user.status != 'Available'"><img :src="[current_consultant.user.status == 'Available' ? '/images/home/ph.png' : current_consultant.user.status == 'In a call' ? '/images/home/ph-y.png': '/images/home/ph-g.png']" alt="no-img" v-on:click="Step2('voice')"/></button>
                    <button class="btn btn-mid" :disabled="current_consultant.user.status != 'Available'"><img :src="[current_consultant.user.status == 'Available' ? '/images/home/video.png' : current_consultant.user.status == 'In a call' ? '/images/home/video-y.png': '/images/home/video-g.png']" alt="no-img" v-on:click="Step2('video')"/></button>
                    <button class="btn" :disabled="current_consultant.user.status != 'Available'"><img :src="[current_consultant.user.status == 'Available' ? '/images/home/msg.png' : current_consultant.user.status == 'In a call' ? '/images/home/msg-y.png': '/images/home/msg-g.png']" alt="no-img" v-on:click="Step2('chat')"/></button>
                </div>
            </div>
            <div class="step" v-if="is_selected && step == 'step2'">
                <img src="/images/credit-card.png" alt="no-image"/>
                <p><b>Your account balance is {{authUser.balance}} kr.</b></p>
                <p>How many minutes do you want to use?</p>
                <div class="input-box">
                    <input type='text' v-model="minute" v-on:change="minuteChange">
                    <label>min</label>
                </div>
                <p>Total cost: <b>{{cost}} kr</b></p>
                <div class="button-group column">
                    <button class="btn btn-green-gradient" v-on:click="startMethod()" :disabled="authUser.balance == 0">{{ selected_type=='voice'?'Start Call':selected_type=='video'?'Start Video Call':'Start Conversation' }}</button>
                    <button class="btn btn-grey" v-on:click="goBack()">Go Back</button>
                </div>
            </div>
        </div>
        <div :class="[is_chat?'chat-room' : 'chat-room none']">
            <div class="chat-right d-flex flex-column">
                <div class="chat-profile d-flex flex-wrap">
                    <div class="end-chat-right d-flex">
                        <button class="btn" v-on:click="endSession()">End Session</button>
                        <img src="/images/setting-icon.png" v-on:click="showSetting()" v-if="!is_setting"/>
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
                                <img :src="authCustomer.prof_image" v-if="authCustomer.prof_image != ''" alt="no-image"/>
                                <b v-else>{{authUser.first_name[0]}}{{authUser.last_name[0]}}</b>
                            </div>
                        </div>
                        <div class="other" v-if="message.author != authUser.email">
                            <label>{{ message.timestamp.toLocaleTimeString() }}</label>
                            <div class="identity">
                                <img :src="current_consultant.prof_image" v-if="current_consultant.prof_image != ''" alt="no-image"/>
                                <b v-else>{{current_consultant.user.first_name[0]}}{{current_consultant.user.last_name[0]}}</b>
                                <p>{{ message.body }} </p>
                            </div>
                        </div>
                    </div>
                    <div class="rate-session">
                        <div class="date-separate" v-if="left_sec <= 15 && left_sec > 0">
                            <legend><span>Your session ends in 15 seconds</span></legend>
                        </div>
                        <div class="date-separate"  v-if="left_sec == 0">
                            <legend><span>Your chat has ended </span></legend>
                        </div>
                        <div class="end-session" v-if="left_sec == 0">
                            <img class="avatar" :src="current_consultant.prof_image" v-if="current_consultant.prof_image != ''" alt="no-image"/>
                            <h2>Rate this session</h2>
                            <vue-start-rate v-model="rate" font-size="30px" type="star1"/>
                            <h2>Continue?</h2>
                            <p>How many minutes do you want to use?</p>
                            <div class="button-group">
                                <div class="input-box">
                                    <input type='text' v-model="minute" v-on:change="minuteChange">
                                    <label>min</label>
                                </div>
                                <button class="btn btn-green-gradient" v-on:click="continueChat()" :disabled="authUser.balance == 0">Continue</button>
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
        <div :class="[is_selected ? 'chatter-pro flex-column d-flex' : is_setting ? 'chatter-pro flex-column d-flex' :'chatter-pro none']">
            <div class="chatter-setting d-flex">
                <button type="button" class="close" aria-label="Close" v-on:click="closeSettings()">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div :class="[current_consultant.user.status == 'Available' ? 'rate-session d-flex flex-column' : current_consultant.user.status == 'In a call' ? 'rate-session d-flex flex-column in-call' : 'rate-session d-flex flex-column offline']">
                <img :src="current_consultant.prof_image" v-if="current_consultant.prof_image != ''" alt="no-image" class="avatar"/>
                <b v-else>{{current_consultant.user.first_name[0]}}{{current_consultant.user.last_name[0]}}</b>
                <span class="absol-span">&#8226;</span>
                <p>{{current_consultant.industry_expertise}}</p>
                <h2>{{current_consultant.user.first_name}} {{current_consultant.user.last_name}}</h2>
                <small>{{current_consultant.user.hourly_rate}} kr p/m</small>
                <div class="rate-stars d-flex" v-if="current_consultant.user.rate >= 4.5">
                    <img src="/images/home/star-dg.png" alt="no-image"/>
                    <img src="/images/home/star-dg.png" alt="no-image"/>
                    <img src="/images/home/star-dg.png" alt="no-image"/>
                    <img src="/images/home/star-dg.png" alt="no-image"/>
                    <img src="/images/home/star-dg.png" alt="no-image"/>
                </div>
                <div class="rate-stars d-flex" v-if="current_consultant.user.rate >= 3.5 && current_consultant.user.rate < 4.5">
                    <img src="/images/home/star-g.png" alt="no-image"/>
                    <img src="/images/home/star-g.png" alt="no-image"/>
                    <img src="/images/home/star-g.png" alt="no-image"/>
                    <img src="/images/home/star-g.png" alt="no-image"/>
                    <img src="/images/home/star-w.png" alt="no-image"/>
                </div>
                <div class="rate-stars d-flex" v-if="current_consultant.user.rate >= 2.5 && current_consultant.user.rate < 3.5">
                    <img src="/images/home/star-y.png" alt="no-image"/>
                    <img src="/images/home/star-y.png" alt="no-image"/>
                    <img src="/images/home/star-y.png" alt="no-image"/>
                    <img src="/images/home/star-w.png" alt="no-image"/>
                    <img src="/images/home/star-w.png" alt="no-image"/>
                </div>
                <div class="rate-stars d-flex" v-if="current_consultant.user.rate >= 1.5 && current_consultant.user.rate < 2.5">
                    <img src="/images/home/star-0.png" alt="no-image"/>
                    <img src="/images/home/star-0.png" alt="no-image"/>
                    <img src="/images/home/star-w.png" alt="no-image"/>
                    <img src="/images/home/star-w.png" alt="no-image"/>
                    <img src="/images/home/star-w.png" alt="no-image"/>
                </div>
                <div class="rate-stars d-flex" v-if="current_consultant.user.rate >= 0.5 && current_consultant.user.rate < 1.5">
                    <img src="/images/home/star-r.png" alt="no-image"/>
                    <img src="/images/home/star-w.png" alt="no-image"/>
                    <img src="/images/home/star-w.png" alt="no-image"/>
                    <img src="/images/home/star-w.png" alt="no-image"/>
                    <img src="/images/home/star-w.png" alt="no-image"/>
                </div>
                <div class="rate-stars d-flex" v-if="current_consultant.user.rate < 0.5">
                    <img src="/images/home/star-w.png" alt="no-image"/>
                    <img src="/images/home/star-w.png" alt="no-image"/>
                    <img src="/images/home/star-w.png" alt="no-image"/>
                    <img src="/images/home/star-w.png" alt="no-image"/>
                    <img src="/images/home/star-w.png" alt="no-image"/>
                </div>
            </div>
            <div class="chat-records d-flex">
                <div class="records-left flex-column">
                    <h2>43</h2>
                    <span>Completed Chats</span>
                </div>
                <div class="records-right flex-column">
                    <h2>30 min</h2>
                    <span>Last Online</span>
                </div>
            </div>
            <div class="chat-drop d-flex flex-column">
                <div class="dropdown">
                    <button type="button" class="btn btn-primary dropdown-toggle btn-user" data-toggle="dropdown">Details</button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="#">Link 1</a>
                        <a class="dropdown-item" href="#">Link 2</a>
                        <a class="dropdown-item" href="#">Link 3</a>
                    </div>
                </div>
                <div class="dropdown">
                    <button type="button" class="btn btn-primary dropdown-toggle btn-user" data-toggle="dropdown">Ratings</button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="#">Link 1</a>
                        <a class="dropdown-item" href="#">Link 2</a>
                        <a class="dropdown-item" href="#">Link 3</a>
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
                        <img :src="current_consultant.prof_image" v-if="current_consultant.prof_image != '' && current_consultant.prof_image != undefined" alt="no-image"/>
                        <img src="/images/home/person.png" v-else />
                    </div>
                    <div class="modal-footer">
                        <button type="button" ref="accept_btn"><img src="/images/home/ph.png"/></button>
                        <button type="button" ref="hangup_btn"><img src="/images/home/ph-e.png"/></button>
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
                        <button type="button" ref="video_hangup_btn"></button>
                        <button type="button" v-on:click="hangupVideoCall()"><img src="/images/home/video-e.png"/></button>
                    </div>
                </div>
            </div>
        </div>
        <div id="session-dialog" v-show="is_session_modal" class="v-modal session">
            <div class="modal-wrapper">
                <div class="modal-container">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <img src="/images/credit-card.png" alt="no-image"/>
                        <h2>Your session has ended. Continue?</h2>
                        <p>How many minutes do you want to use?</p>
                        <div class="input-box">
                            <input type='text' v-model="minute" v-on:change="minuteChange">
                            <label>min</label>
                        </div>
                        <p>Total cost: <b>{{cost}} kr</b></p>
                        <div class="button-group">
                            <button class="btn btn-green-gradient" v-on:click="restartMethod()">{{ selected_type=='voice'?'Continue Call':selected_type=='video'?'Continue Video Call':'Continue Conversation' }}</button>
                            <button class="btn btn-review" v-on:click="viewConversation()" v-if="selected_type=='chat'">View Conversation</button>
                            <button class="btn btn-back" v-on:click="goBack()" v-if="selected_type !='chat'">Go Back</button>
                        </div>
                        <button class="btn btn-back" v-on:click="goBack()" v-if="selected_type=='chat'">Go Back</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from '../Http';
    import { Device } from 'twilio-client';
    import StarRate  from 'vue-cute-rate';
    const Video = require('twilio-video');
    const { connect, createLocalTracks, createLocalVideoTrack } = require('twilio-video');
    export default {
        name:"customer-component",
        components: {
            'vue-start-rate' : StarRate
        },
        props: {
            _authUser: {
                type: Object,
                required: true
            },
            _consultants: {
                type: Array,
                required: true
            },
            authCustomer: {
                type: Object,
                required: true
            }
        },
        data() {
            return {
                messages: [],
                consultants: [],
                newMessage: "",
                channel: "",
                step: "",
                selected_type: "",
                minute: "",
                cost: "",
                today: "",
                balance: 0,
                rate: 0,
                left_sec: 50,
                is_chat: false,
                is_selected: false,
                is_setting: false,
                is_modal: false,
                is_video_modal: false,
                is_session_modal: false,
                is_channel: true,
                chat_accepted: false,
                chat_session: false,
                current_consultant: {
                    user: {}
                },
                device: new Device(),
                activeRoom: null
            };
        },
        mounted() {
            console.log("customer chat service started!");
            var today = new Date();
            this.today = today.toString().split(' ')[0] + " " + today.toString().split(' ')[1] + " " + today.toString().split(' ')[2] + " " + today.toString().split(' ')[3];
            this.consultants = this._consultants;
            this.authUser = this._authUser;
            this.step = "step0";
            this.minute = "0";
            this.cost = "0";
            this.setStatus('Available');            
            let self = this;
            
            this.$socket.onopen = () => {
                this.$socket.onmessage = (data) => {
                    var msg = JSON.parse(data.data);
                    if (msg.type == 'token') {
                        self.voice_token_name = msg.token;
                    } if (msg.type == 'request') {
                        if (msg.name == 'accepted') {
                            self.chat_accepted = true;
                            self.startChat();
                        } else {
                            self.chat_accepted = false;
                        }
                    } else {
                        self.consultants.forEach((consultant) => {
                            if (consultant.user.id == msg.id) {
                                consultant.user.status = msg.status;
                                self.current_consultant = consultant;
                            }
                        });
                        axios.post('/api/manage_status', { id: msg.id, status: msg.status });
                    }
                };
                this.$socket.sendObj({ command: "subscribe",  channel: this.authUser.id });
            }

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
                    Video.connect(data.token, {"name": roomName}).then((room) => {
                        console.log('Successfully joined a Room: ', room);
                        self.activeRoom = room;
                                                
                        self.setStatus('In a Video call');
                        self.sendStatusSocket('In a Video call');
                        setTimeout(function() {
                            self.is_modal = false;
                            self.minute = '0';
                            self.step = 'step1';
                            self.activeRoom.localParticipant.tracks.forEach(function(track) { 
                                track.stop();
                            });
                            self.activeRoom.disconnect();
                            axios.post('/api/manage_balance', { id: self.authUser.id, cost: self.cost }).then((res)=>{
                                self.authUser = res.data;
                            });
                            self.cost = '0';
                        }, self.minute * 60 * 1000);

                        room.participants.forEach(self.participantConnected);

                        room.on('participantConnected', self.participantConnected);
                        
                        room.on('participantDisconnected', self.participantDisconnected);

                        room.once('disconnected', error => room.participants.forEach(self.participantDisconnected));
                    }, (err) => {
                        console.error('Unable to connect to Room: ' +  err.message);
                    });
                }
            });
            this.$refs.hangup_btn.addEventListener('click', () => {
                self.is_modal = false;
                self.minute = '0';
                self.step = '1';
                self.device.disconnectAll();
                self.setStatus('Available');
                self.sendStatusSocket('Available');
                // re-calulate the minute and the cost
            });
            this.device.disconnect(function(connection) {
                self.is_modal = false;
            });
            this.device.connect(function(connection) {
                console.log(connection);
            });
            this.device.error(function (error) {
                console.error("ERROR: " + error.message);
                if (error.code == 31205) {
                    self.initializeCallClient();
                }
            });
        },
        methods: {
            // initialize tokens and twilio client
            async selectChannel(data) {
                if (this.is_channel) {
                    this.step = "step1";
                    this.current_consultant = data;
                    this.is_selected = true;
                    this.is_setting = true;
                    this.is_chat = false;
                    this.is_channel = false;
                    
                    // use consultant's name to generate token
                    await this.initializeCallClient();
                    await this.initializeVideoClient();
                }
            },
            sendRequestSocket(type) {
                this.$socket.sendObj({ 
                    command: "message",
                    type: 'request',
                    sub_type: type,
                    id: this.current_consultant.user.id,
                    customer_id: this.authUser.id,
                    customer_name: this.authUser.first_name + " " + this.authUser.last_name,
                    min: this.minute,
                    img: authCustomer.prof_image
                });
            },
            sendStatusSocket(msg) {
                this.$socket.sendObj({
                    command: "message", 
                    id: this.authUser.id, 
                    type: 'status',
                    msg: msg
                });
            },
            setStatus(status) {
                axios.post('/api/manage_status', { id: this.authUser.id, status: status });
            },
            // chat module
            async startChat() {
                if (this.chat_accepted) {
                    this.is_chat = true;
                    this.chat_session = true;
                    axios.post('/api/chat_channel', { consultant_email: this.current_consultant.user.email, consultant_id: this.current_consultant.user.id, customer_email: this.authUser.email, customer_id: this.authUser.id })
                    .then((response) => {
                        console.log('channel fetched!');
                    });
                    const chat_token = await this.fetchChatToken();
                    await this.initializeChatClient(chat_token, this.current_consultant.user.id);
                    await this.fetchMessages();
                    this.scrollToEnd();
                }
            },
            continueChat() {
                if (this.minute > 0) {
                    this.sendRequestSocket('chat_continue')
                    this.left_sec = 50;
                    this.startChat();
                }
            },
            viewConversation() {
                this.is_session_modal = false;
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
                this.channel = await client.getChannelByUniqueName(`private-${id}-${this.authUser.id}`);
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
                this.messages = (await this.channel.getMessages()).items;
                this. sendStatusSocket('In a chat');
                let self = this;
                
                setTimeout(function(t) {
                    self.left_sec = 15;
                    setTimeout(function() {
                        self.sendRequestSocket('chat_pause');
                        axios.post('/api/manage_balance', { id: self.authUser.id, cost: self.cost }).then((res)=>{
                            self.authUser = res.data;
                        });
                        self.minute = '0';
                        self.cost = '0';
                        self.left_sec = 0;
                        self.chat_session = false;
                    }, 15 * 1000);
                }.bind('timeCounting', 15 * 1000), self.minute * 60 * 1000);
            },
            sendMessage() {
                if (this.chat_session && this.current_consultant.user.status != 'Offline') {
                    this.channel.sendMessage(this.newMessage);
                    this.newMessage = "";
                }
            },
            // voice call module
            startCall() {
                this.sendRequestSocket('voice_call');
                var params = {
                    "phone": this.current_consultant.user.phone,
                    "callerId": this.authUser.phone,
                    "name": this.current_consultant.user.first_name + this.current_consultant.user.last_name,
                    "type": "voice",
                    "roomName":""
                };
                this.device.connect(params);
                this.is_modal = true;
            },
            async initializeCallClient() {
                axios.post("/api/new_token", { "name": this.current_consultant.user.first_name + this.current_consultant.user.last_name } ).then((res) => {
                    this.device.setup(res.data.token, { debug: true });
                });
            },
            // video call module
            async initializeVideoClient() {
                await axios.post('/api/create_room', { "name": `videoRoom-${this.current_consultant.user.id}-${this.authUser.id}`}).then((res) => {
                    console.log(res);
                });
            },
            async fetchVideoToken() {
                const { data } = await axios.post("/api/video_token", { "userName": this.authUser.first_name + this.authUser.last_name, "roomName": `videoRoom-${this.current_consultant.user.id}-${this.authUser.id}`});
                return data.token;
            },
            async startVideo() {
                this.sendRequestSocket('video_call');
                this.is_video_modal = true;
                let self = this;

                if (self.$refs.self_video_tag.children.length == 0) {
                    createLocalVideoTrack({audio: true, video: { width: 150 }}).then(track => {
                        self.$refs.self_video_tag.appendChild(track.attach());
                    });
                }

                var params = {
                    "phone": this.current_consultant.user.phone,
                    "callerId": this.authUser.phone,
                    "name": this.current_consultant.user.first_name + this.current_consultant.user.last_name,
                    "type": "video",
                    "roomName": `videoRoom-${this.current_consultant.user.id}-${this.authUser.id}`
                };
                this.device.connect(params);
                
                const token = await this.fetchVideoToken();
                Video.connect(token, {"name": `videoRoom-${this.current_consultant.user.id}-${this.authUser.id}`}).then((room) => {
                    console.log('Successfully joined a Room: ', room);
                    self.activeRoom = room;
                    // room.participants.forEach(self.participantConnected);

                    room.on('participantConnected', self.participantConnected);
                    
                    room.on('participantDisconnected', self.participantDisconnected);

                    room.once('disconnected', error => room.participants.forEach(self.participantDisconnected));
                }, (err) => {
                    console.error('Unable to connect to Room: ' +  err.message);
                });
            },
            hangupVideoCall() {
                this.is_video_modal = false;
                this.minute = '0';
                this.step = '1';
                if (this.activeRoom) {
                    this.activeRoom.localParticipant.tracks.forEach(function(track) { 
                        track.stop();
                    });
                    this.activeRoom.disconnect();
                    this.setStatus('Available');
                    this.sendStatusSocket('Available');
                }
                // re-calulate the minute and the cost
            },
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
            },
            // close setting
            closeSettings() {
                this.is_selected = false;
                this.is_setting = false;
            },
            // step 2
            Step2(type) {
                if (this.current_consultant.user.status == 'Available') {
                    this.step = 'step2';
                    this.selected_type = type;
                }
            },
            goBack() {
                this.sendRequestSocket('chat_end');
                this.sendStatusSocket('Available');
                axios.post('/api/manage_rate', { id: this.current_consultant.user.id, rate: this.rate }).then((res)=>{
                    this.current_consultant.user.rate = res.data.user.rate;
                });
                this.is_channel = true;
                this.is_chat = false;
                this.is_session_modal = false;
                this.step = 'step1';
            },
            startMethod() {
                if (Number(this.authUser.balance) > Number(this.minute) * Number(this.current_consultant.user.hourly_rate)) {
                    switch(this.selected_type) {
                        case 'voice':
                            this.startCall();
                            break;
                        case 'video':
                            this.startVideo();
                            break;
                        case 'chat':
                            this.sendRequestSocket('chat_start');
                            break;
                    }
                }
            },
            restartMethod() {
                this.is_session_modal = false;
                if (Number(this.authUser.balance) > Number(this.minute) * Number(this.current_consultant.user.hourly_rate)) {
                    switch(this.selected_type) {
                        case 'voice':
                            this.startCall();
                            break;
                        case 'video':
                            this.startVideo();
                            break;
                        case 'chat':
                            this.continueChat();
                            break;
                    }
                }
            },
            minuteChange() {
                this.cost = Number(this.minute) * Number(this.current_consultant.user.hourly_rate);
            },
            scrollToEnd() {
                var container = this.$el.querySelector("#scroll-view");
                container.scrollTop = container.scrollHeight;
            },
            showSetting() {
                this.is_setting = true;
            },
            endSession() {
                if (this.rate > 0) {
                    this.is_session_modal = true;
                    this.minute = '0';
                    this.cost = '0';
                }
            }
        }
    }
</script>
