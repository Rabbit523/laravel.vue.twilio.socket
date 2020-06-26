<template>
  <div class="full-chat-section d-flex">
    <div :class="[is_selected && is_mobile ? 'chat-left none' : 'chat-left']">
      <h2>{{ $t('member.my-sessions') }}</h2>
      <div
        :class="[consultant.id == current_consultant.id ? 'chat-model d-flex active' : 'chat-model d-flex']"
        v-for="consultant in consultants"
        :key="consultant.id"
        v-on:click="selectChannel(consultant)"
      >
        <div class="chat-icon">
          <img
            :src="consultant.profile.avatar"
            v-if="consultant.profile && consultant.profile.avatar != ''"
            alt="no-image"
          />
          <label v-else>{{consultant.user.first_name[0]}}{{consultant.user.last_name[0]}}</label>
        </div>
        <div
          :class="[consultant.user.status == 'Available' ? 'chat-details d-flex flex-column' : consultant.user.status == 'Offline' ? 'chat-details d-flex flex-column offline' : 'chat-details d-flex flex-column in-call']"
        >
          <label>
            {{consultant.user.first_name}} {{consultant.user.last_name}}
            <span>{{consultant.user.status}}</span>
          </label>
          <legend
            v-if="consultant.profile && consultant.profile.profession"
          >{{consultant.profile.profession}}</legend>
          <p>Lorem Ipsum er rett og slett dummy</p>
          <p>tekst fra og for trykkeindustrien..</p>
        </div>
      </div>
    </div>
    <div
      :class="[is_mobile && is_selected && !is_chat? 'select-box' : !is_chat && !is_mobile ? 'select-box' : 'select-box none']"
    >
      <div class="step" v-if="!is_selected && step == 'step0'">
        <img src="/images/chat.png" alt="no-image" />
        <label>
          {{ $t('member.no-consultants')}}
        </label>
        <p class="text">{{ $t('member.no-consultants-des')}}</p>
      </div>
      <div class="step" v-if="is_selected && step == 'step1'">
        <div class="desktop-session" v-if="!is_mobile">
          <img src="/images/like.png" alt="no-image" />
          <label>{{ $t('member.selected')}} {{current_consultant.user.first_name}}.</label>
          <p>{{ $t('member.selected-des')}}</p>
          <div class="button-group">
            <button class="btn" :disabled="current_consultant.user.status != 'Available'">
              <img
                :src="[current_consultant.user.status == 'Available' ? '/images/home/ph.png' : current_consultant.user.status == 'In a call' ? '/images/home/ph-y.png': '/images/home/ph-g.png']"
                alt="no-img"
                v-on:click="Step2('voice')"
              />
            </button>
            <button class="btn btn-mid" :disabled="current_consultant.user.status != 'Available'">
              <img
                :src="[current_consultant.user.status == 'Available' ? '/images/home/video.png' : current_consultant.user.status == 'In a call' ? '/images/home/video-y.png': '/images/home/video-g.png']"
                alt="no-img"
                v-on:click="Step2('video')"
              />
            </button>
            <button class="btn" :disabled="current_consultant.user.status != 'Available'">
              <img
                :src="[current_consultant.user.status == 'Available' ? '/images/home/msg.png' : current_consultant.user.status == 'In a call' ? '/images/home/msg-y.png': '/images/home/msg-g.png']"
                alt="no-img"
                v-on:click="Step2('chat')"
              />
            </button>
          </div>
        </div>
        <div class="mobile-session" v-else>
          <h2>{{ $t('member.start-session')}}</h2>
          <div
            :class="[current_consultant.user.status == 'Available' ? 'rate-session chat-setting' : current_consultant.user.status == 'Offline' ? 'rate-session offline' : 'rate-session in-call']"
          >
            <img
              :src="current_consultant.profile.avatar"
              v-if="current_consultant.profile && current_consultant.profile.avatar != ''"
              alt="no-image"
              class="avatar"
            />
            <b
              v-else
            >{{current_consultant.user.first_name[0]}}{{current_consultant.user.last_name[0]}}</b>
            <button class="mobile-prev-step" v-on:click="mobilePrevStep()">
              <i class="fa fa-chevron-left" aria-hidden="true"></i>
            </button>
            <span :class="[current_consultant.user.status == 'Available' ? 'absol-span Available' : current_consultant.user.status == 'Offline' ? 'absol-span Offline' : 'absol-span in-call']">&#8226;</span>
            <p
              v-if="current_consultant.profile && current_consultant.profile.profession"
            >{{current_consultant.profile.profession}}</p>
            <label>{{current_consultant.user.first_name}} {{current_consultant.user.last_name}}</label>
            <small>{{current_consultant.hourly_rate}} kr p/m</small>
            <div class="rate-stars" v-if="current_consultant.rate >= 4.5">
              <img src="/images/home/star-dg.png" alt="no-image" />
              <img src="/images/home/star-dg.png" alt="no-image" />
              <img src="/images/home/star-dg.png" alt="no-image" />
              <img src="/images/home/star-dg.png" alt="no-image" />
              <img src="/images/home/star-dg.png" alt="no-image" />
            </div>
            <div
              class="rate-stars"
              v-if="current_consultant.rate >= 3.5 && current_consultant.rate < 4.5"
            >
              <img src="/images/home/star-g.png" alt="no-image" />
              <img src="/images/home/star-g.png" alt="no-image" />
              <img src="/images/home/star-g.png" alt="no-image" />
              <img src="/images/home/star-g.png" alt="no-image" />
              <img src="/images/home/star-w.png" alt="no-image" />
            </div>
            <div
              class="rate-stars"
              v-if="current_consultant.rate >= 2.5 && current_consultant.rate < 3.5"
            >
              <img src="/images/home/star-y.png" alt="no-image" />
              <img src="/images/home/star-y.png" alt="no-image" />
              <img src="/images/home/star-y.png" alt="no-image" />
              <img src="/images/home/star-w.png" alt="no-image" />
              <img src="/images/home/star-w.png" alt="no-image" />
            </div>
            <div
              class="rate-stars"
              v-if="current_consultant.rate >= 1.5 && current_consultant.rate < 2.5"
            >
              <img src="/images/home/star-o.png" alt="no-image" />
              <img src="/images/home/star-o.png" alt="no-image" />
              <img src="/images/home/star-w.png" alt="no-image" />
              <img src="/images/home/star-w.png" alt="no-image" />
              <img src="/images/home/star-w.png" alt="no-image" />
            </div>
            <div
              class="rate-stars"
              v-if="current_consultant.rate >= 0.5 && current_consultant.rate < 1.5"
            >
              <img src="/images/home/star-r.png" alt="no-image" />
              <img src="/images/home/star-w.png" alt="no-image" />
              <img src="/images/home/star-w.png" alt="no-image" />
              <img src="/images/home/star-w.png" alt="no-image" />
              <img src="/images/home/star-w.png" alt="no-image" />
            </div>
            <div class="rate-stars" v-if="current_consultant.rate < 0.5">
              <img src="/images/home/star-w.png" alt="no-image" />
              <img src="/images/home/star-w.png" alt="no-image" />
              <img src="/images/home/star-w.png" alt="no-image" />
              <img src="/images/home/star-w.png" alt="no-image" />
              <img src="/images/home/star-w.png" alt="no-image" />
            </div>
            <div class="button-group">
              <button class="btn" :disabled="current_consultant.user.status != 'Available'">
                <img
                  :src="[current_consultant.user.status == 'Available' ? '/images/home/ph.png' : current_consultant.user.status == 'In a call' ? '/images/home/ph-y.png': '/images/home/ph-g.png']"
                  alt="no-img"
                  v-on:click="Step2('voice')"
                />
              </button>
              <button class="btn btn-mid" :disabled="current_consultant.user.status != 'Available'">
                <img
                  :src="[current_consultant.user.status == 'Available' ? '/images/home/video.png' : current_consultant.user.status == 'In a call' ? '/images/home/video-y.png': '/images/home/video-g.png']"
                  alt="no-img"
                  v-on:click="Step2('video')"
                />
              </button>
              <button class="btn" :disabled="current_consultant.user.status != 'Available'">
                <img
                  :src="[current_consultant.user.status == 'Available' ? '/images/home/msg.png' : current_consultant.user.status == 'In a call' ? '/images/home/msg-y.png': '/images/home/msg-g.png']"
                  alt="no-img"
                  v-on:click="Step2('chat')"
                />
              </button>
            </div>
          </div>
          <div class="chat-records">
            <div class="records-left">
              <label>{{current_consultant.completed_sessions > 0 ? current_consultant.completed_sessions : 0}}</label>
              <span>{{ $t('member.sessions') }}</span>
            </div>
            <div class="records-right">
              <label>30 min</label>
              <span>{{ $t('member.last-online') }}</span>
            </div>
          </div>
          <div class="chat-drop">
            <select id="selected-details" name="details">
              <option disabled selected>{{ $t('member.details') }}</option>
              <option value="link1">Link 1</option>
              <option value="link2">Link 2</option>
              <option value="link3">Link 3</option>
            </select>
            <select id="selected-ratings" name="ratings">
              <option disabled selected>{{ $t('member.ratings') }}</option>
              <option value="link1">Link 1</option>
              <option value="link2">Link 2</option>
              <option value="link3">Link 3</option>
            </select>
          </div>
        </div>
      </div>
      <div class="step" v-if="is_selected && step == 'step2'">
        <img src="/images/credit-card.png" alt="no-image" />
        <p>
          <b>{{ $t('member.account-balance')}} {{authCustomer.user.balance}} kr.</b>
        </p>
        <p>{{ $t('member.balance-charge-question')}}</p>
        <div :class="[$v.form.$error ? 'hasError input-box': 'input-box']">
          <input type="text" v-model="form.minute" v-on:change="minuteChange" />
          <label>min</label>
        </div>
        <p>
          {{ $t('member.total-cost')}}:
          <b>{{cost}} kr</b>
        </p>
        <div class="button-group column">
          <button
            class="btn btn-green-gradient"
            v-on:click="startMethod()"
            :disabled="authCustomer.user.balance == 0"
          >{{ selected_type=='voice'? $t('member.start-call') :selected_type=='video'? $t('member.start-video-call') : $t('member.start-conversation') }}</button>
          <button class="btn btn-grey" v-on:click="goBack()">{{$t('member.btn-go-back')}}</button>
        </div>
      </div>
    </div>
    <div :class="[is_chat?'chat-room' : 'chat-room none']">
      <div class="chat-right">
        <div class="chat-profile d-flex flex-wrap">
          <div class="end-chat-right d-flex">
            <div class="mr-3 d-flex">
              <img src="/images/timer.svg" />
              <p class="m-0 pl-1">
                <b>{{toHHMMSS(time_clock)}}</b>
              </p>
            </div>
            <button class="btn" v-on:click="endSession()">{{ $t('member.end_session') }}</button>
            <img src="/images/settings-icon.svg" v-on:click="showSetting()" v-if="!is_setting && !is_mobile" />
          </div>
        </div>
        <div class="chat-history" id="scroll-view">
          <div class="chat-list" v-for="(message, index) in messages" v-bind:key="message.index">
            <div class="date-separate" v-if="index == 0">
              <legend>
                <span>{{ message.timestamp.toDateString() == today ? 'Today': message.timestamp.toDateString() }}</span>
              </legend>
            </div>
            <div
              class="date-separate"
              v-else-if="index > 0 && messages[index-1].timestamp.toDateString() !== message.timestamp.toDateString()"
            >
              <legend>
                <span>{{ message.timestamp.toDateString() == today ? 'Today': message.timestamp.toDateString() }}</span>
              </legend>
            </div>
            <div class="self" v-if="message.author === authCustomer.user.email">
              <label>{{ message.timestamp.toLocaleTimeString() }}</label>
              <div class="identity">
                <p>{{ message.body }}</p>
                <img
                  :src="authCustomer.profile.avatar"
                  v-if="authCustomer.profile && authCustomer.profile.avatar != ''"
                  alt="no-image"
                />
                <b v-else>{{authCustomer.user.first_name[0]}}{{authCustomer.user.last_name[0]}}</b>
              </div>
            </div>
            <div class="other" v-if="message.author != authCustomer.user.email">
              <label>{{ message.timestamp.toLocaleTimeString() }}</label>
              <div class="identity">
                <img
                  :src="current_consultant.profile.avatar"
                  v-if="current_consultant.profile && current_consultant.profile.avatar != ''"
                  alt="no-image"
                />
                <b
                  v-else
                >{{current_consultant.user.first_name[0]}}{{current_consultant.user.last_name[0]}}</b>
                <p>{{ message.body }}</p>
              </div>
            </div>
          </div>
          <div class="rate-session">
            <div class="date-separate" v-if="time_clock <= 15 && time_clock > 0">
              <legend>
                <span>{{ $t('member.session-end-alert') }}</span>
              </legend>
            </div>
            <div class="date-separate" v-if="time_clock == 0">
              <legend>
                <span>{{ $t('member.chat-end') }}</span>
              </legend>
            </div>
            <div class="end-session" v-if="time_clock == 0">
              <img
                class="avatar"
                :src="current_consultant.profile.avatar"
                v-if="current_consultant.profile && current_consultant.profile.avatar != ''"
                alt="no-image"
              />
              <div class="btn-group" v-if="!isCheckReview && !isCheckContinue">
                <button
                  class="btn btn-review"
                  v-on:click="goToReview()"
                >{{ $t('member.write-review') }}</button>
                <button
                  class="btn btn-session"
                  v-on:click="goToContinue()"
                >{{ $t('member.continue-session') }}</button>
              </div>
              <div class="review-sec" v-if="isCheckReview && !isCheckContinue">
                <h2>{{ $t('member.rate-session') }}</h2>
                <vue-start-rate v-model="rate" font-size="30px" type="star1" />
                <textarea v-model="review_des" :placeholder="$t('member.write-review-msg')"></textarea>
                <div class="btn-group">
                  <button
                    class="btn btn-session"
                    v-on:click="goToContinue()"
                  >{{ $t('member.continue-session') }}</button>
                  <button
                    class="btn btn-review"
                    v-on:click="submitReview()"
                  >{{ $t('member.submit-review') }}</button>
                </div>
              </div>
              <div class="continue-sec" v-if="isCheckContinue && !isCheckReview">
                <h2>{{ $t('member.continue-session') }}</h2>
                <div class="button-group">
                  <div :class="[$v.form.$error ? 'hasError input-box' :'input-box']">
                    <input type="text" v-model="form.minute" v-on:change="minuteChange" />
                    <label>min</label>
                  </div>
                  <p>
                    {{ $t('member.total-cost')}}:
                    <b>{{cost}} kr</b>
                  </p>
                  <button
                    class="btn btn-review"
                    v-on:click="goToReview()"
                  >{{ $t('member.write-review') }}</button>
                  <button
                    class="btn btn-session"
                    v-on:click="continueChat()"
                    :disabled="authCustomer.user.balance == 0"
                  >{{ $t('member.continue-session') }}</button>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="write-text d-flex flex-column">
          <span>
            <input
              type="text"
              :placeholder="$t('member.write-message')"
              v-model="newMessage"
              @keyup.enter="sendMessage"
            />
          </span>
          <div class="send-msg d-flex">
            <button class="btn" v-on:click="sendMessage()">{{ $t('member.send') }}</button>
            <input type="checkbox" id="fruit1" name="fruit-1" value="Apple" />
            <label id="sms" for="fruit1">{{ $t('member.sms') }}</label>
            <input type="checkbox" id="fruit4" name="fruit-4" value="Strawberry" />
            <label id="inapp" for="fruit4">{{ $t('member.in_app') }}</label>
          </div>
        </div>
      </div>
    </div>
    <div :class="[(!is_mobile && is_selected) || is_setting ? 'chatter-pro' :'chatter-pro none']">
      <div class="chatter-setting d-flex">
        <button type="button" class="close" aria-label="Close" v-on:click="closeSettings()">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div
        :class="[current_consultant.user.status == 'Available' ? 'rate-session chat-setting d-flex flex-column' : current_consultant.user.status == 'Offline' ? 'rate-session d-flex flex-column offline' : 'rate-session d-flex flex-column in-call']"
      >
        <img
          :src="current_consultant.profile.avatar"
          v-if="current_consultant.profile && current_consultant.profile.avatar != ''"
          alt="no-image"
          class="avatar"
        />
        <b v-else>{{current_consultant.user.first_name[0]}}{{current_consultant.user.last_name[0]}}</b>
        <span :class="[current_consultant.user.status == 'Available' ? 'absol-span Available' : current_consultant.user.status == 'Offline' ? 'absol-span Offline' : 'absol-span in-call']">&#8226;</span>
        <p
          v-if="current_consultant.profile && current_consultant.profile.profession"
        >{{current_consultant.profile.profession}}</p>
        <h2>{{current_consultant.user.first_name}} {{current_consultant.user.last_name}}</h2>
        <small>{{current_consultant.hourly_rate}} kr p/m</small>
        <div class="rate-stars" v-if="current_consultant.rate >= 4.5">
          <img src="/images/home/star-dg.png" alt="no-image" />
          <img src="/images/home/star-dg.png" alt="no-image" />
          <img src="/images/home/star-dg.png" alt="no-image" />
          <img src="/images/home/star-dg.png" alt="no-image" />
          <img src="/images/home/star-dg.png" alt="no-image" />
        </div>
        <div
          class="rate-stars"
          v-if="current_consultant.rate >= 3.5 && current_consultant.rate < 4.5"
        >
          <img src="/images/home/star-g.png" alt="no-image" />
          <img src="/images/home/star-g.png" alt="no-image" />
          <img src="/images/home/star-g.png" alt="no-image" />
          <img src="/images/home/star-g.png" alt="no-image" />
          <img src="/images/home/star-w.png" alt="no-image" />
        </div>
        <div
          class="rate-stars"
          v-if="current_consultant.rate >= 2.5 && current_consultant.rate < 3.5"
        >
          <img src="/images/home/star-y.png" alt="no-image" />
          <img src="/images/home/star-y.png" alt="no-image" />
          <img src="/images/home/star-y.png" alt="no-image" />
          <img src="/images/home/star-w.png" alt="no-image" />
          <img src="/images/home/star-w.png" alt="no-image" />
        </div>
        <div
          class="rate-stars"
          v-if="current_consultant.rate >= 1.5 && current_consultant.rate < 2.5"
        >
          <img src="/images/home/star-o.png" alt="no-image" />
          <img src="/images/home/star-o.png" alt="no-image" />
          <img src="/images/home/star-w.png" alt="no-image" />
          <img src="/images/home/star-w.png" alt="no-image" />
          <img src="/images/home/star-w.png" alt="no-image" />
        </div>
        <div
          class="rate-stars"
          v-if="current_consultant.rate >= 0.5 && current_consultant.rate < 1.5"
        >
          <img src="/images/home/star-r.png" alt="no-image" />
          <img src="/images/home/star-w.png" alt="no-image" />
          <img src="/images/home/star-w.png" alt="no-image" />
          <img src="/images/home/star-w.png" alt="no-image" />
          <img src="/images/home/star-w.png" alt="no-image" />
        </div>
        <div class="rate-stars" v-if="current_consultant.rate < 0.5">
          <img src="/images/home/star-w.png" alt="no-image" />
          <img src="/images/home/star-w.png" alt="no-image" />
          <img src="/images/home/star-w.png" alt="no-image" />
          <img src="/images/home/star-w.png" alt="no-image" />
          <img src="/images/home/star-w.png" alt="no-image" />
        </div>
      </div>
      <div class="chat-records">
        <div class="records-left">
          <label>{{current_consultant.completed_sessions > 0 ? current_consultant.completed_sessions : 0}}</label>
          <span>{{ $t('member.sessions') }}</span>
        </div>
        <div class="records-right">
          <label>30 min</label>
          <span>{{ $t('member.last-online') }}</span>
        </div>
      </div>
      <div class="chat-drop">
        <select id="selected-details" name="details">
          <option disabled selected>{{ $t('member.details') }}</option>
          <option value="link1">Link 1</option>
          <option value="link2">Link 2</option>
          <option value="link3">Link 3</option>
        </select>
        <select id="selected-ratings" name="ratings">
          <option disabled selected>{{ $t('member.ratings') }}</option>
          <option value="link1">Link 1</option>
          <option value="link2">Link 2</option>
          <option value="link3">Link 3</option>
        </select>
      </div>
    </div>
    <div id="call-dialog" v-show="is_modal" class="v-modal">
      <div class="modal-wrapper">
        <div class="modal-container">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body">
            <img
              :src="current_consultant.profile.avatar"
              v-if="current_consultant.profile && current_consultant.profile.avatar != '' && current_consultant.profile.avatar != undefined"
              alt="no-image"
            />
            <img src="/images/user.svg" v-else />
          </div>
          <div class="modal-footer">
            <button type="button" ref="accept_btn">
              <img src="/images/home/ph.png" />
            </button>
            <button type="button" ref="hangup_btn">
              <img src="/images/home/ph-e.png" />
            </button>
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
            <button type="button" v-on:click="hangupVideoCall()">
              <img src="/images/home/video-e.png" />
            </button>
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
            <img src="/images/session-ended-icon.svg" alt="no-image" />
            <h2>{{ $t('member.session-continue') }}</h2>
            <p>{{ $t('member.minutes-question') }}</p>
            <div :class="[$v.form.$error ? 'hasError input-box': 'input-box']">
              <input type="text" v-model="form.minute" v-on:change="minuteChange" />
              <label>min</label>
            </div>
            <p>
              {{ $t('member.total-cost') }}:
              <b>{{cost}} kr</b>
            </p>
            <div class="button-group">
              <button
                class="btn btn-review"
                v-on:click="viewSession()"
                v-if="selected_type=='chat'"
              >{{ $t('member.btn-view-session') }}</button>
              <button
                class="btn btn-continue"
                v-on:click="restartMethod()"
              >{{ selected_type=='voice'? $t('member.btn-continue-call'):selected_type=='video'? $t('member.btn-continue-video-call') : $t('member.btn-continue-session') }}</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "../Http";
import { Device } from "twilio-client";
import StarRate from "vue-cute-rate";
import { required, minValue } from "vuelidate/lib/validators";
import { isMobile } from "detect-touch-device";

const Video = require("twilio-video");
const {
  connect,
  createLocalTracks,
  createLocalVideoTrack
} = require("twilio-video");

export default {
  name: "customer-component",
  components: {
    "vue-start-rate": StarRate
  },
  props: {
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
      form: {
        minute: 0
      },
      time_clock: 0,
      cost: "",
      today: "",
      balance: 0,
      rate: 0,
      review_des: "",
      is_mobile: false,
      is_chat: false,
      is_selected: false,
      is_setting: false,
      is_modal: false,
      is_video_modal: false,
      is_session_modal: false,
      is_channel: false,
      isCheckReview: false,
      isCheckContinue: false,
      chat_accepted: false,
      chat_session: false,
      current_consultant: {
        user: {},
        profile: {}
      },
      device: new Device(),
      activeRoom: null
    };
  },
  validations: {
    form: {
      minute: { required, min: minValue(1) }
    }
  },
  mounted() {
    console.log("customer chat service started!");
    var today = new Date();
    this.today =
      today.toString().split(" ")[0] +
      " " +
      today.toString().split(" ")[1] +
      " " +
      today.toString().split(" ")[2] +
      " " +
      today.toString().split(" ")[3];
    this.consultants = this._consultants;
    this.step = "step0";
    this.form.minute = "0";
    this.cost = "0";
    this.setStatus("Available");
    let self = this;
    this.is_mobile = isMobile ? true : false;
    this.$socket.onopen = () => {
      this.$socket.onmessage = data => {
        var msg = JSON.parse(data.data);
        if (msg.type == "token") {
          self.voice_token_name = msg.token;
        }
        if (msg.type == "request") {
          if (msg.name == "accepted") {
            self.chat_accepted = true;
            self.startChat();
          } else {
            self.chat_accepted = false;
            self.is_chat = false;
            self.step = "step1";
            self.cost = "";
            self.form.minute = "";
          }
        } else {
          self.consultants.forEach(consultant => {
            if (consultant.user.id == msg.id) {
              consultant.user.status = msg.status;
              self.current_consultant = consultant;
            }
          });
          axios.post("/api/manage_status", { id: msg.id, status: msg.status });
        }
      };
      this.$socket.sendObj({
        command: "subscribe",
        channel: this.authCustomer.user.id
      });
    };

    this.device.incoming(async function(connection) {
      var type = connection.customParameters.get("type");
      var roomName = connection.customParameters.get("roomName");
      if (type == "voice") {
        self.is_modal = true;
        self.$refs.accept_btn.addEventListener("click", () => {
          connection.accept();
        });
      } else {
        self.is_video_modal = true;
        connection.reject();

        if (self.$refs.self_video_tag.children.length == 0) {
          createLocalVideoTrack({ audio: true, video: { width: 150 } }).then(
            track => {
              self.$refs.self_video_tag.appendChild(track.attach());
            }
          );
        }

        const { data } = await axios.post("/api/video_token", {
          userName:
            self.authCustomer.user.first_name +
            self.authCustomer.user.last_name,
          roomName: roomName
        });
        Video.connect(data.token, { name: roomName }).then(
          room => {
            console.log("Successfully joined a Room: ", room);
            self.activeRoom = room;

            self.setStatus("In a Video call");
            self.sendStatusSocket("In a Video call");
            setTimeout(function() {
              self.is_modal = false;
              self.step = "step1";
              self.activeRoom.localParticipant.tracks.forEach(function(track) {
                track.stop();
              });
              self.activeRoom.disconnect();
              self.cost = "0";
              self.form.minute = "0";
            }, self.form.minute * 60 * 1000);

            room.participants.forEach(self.participantConnected);

            room.on("participantConnected", self.participantConnected);

            room.on("participantDisconnected", self.participantDisconnected);

            room.once("disconnected", error =>
              room.participants.forEach(self.participantDisconnected)
            );
          },
          err => {
            console.error("Unable to connect to Room: " + err.message);
          }
        );
      }
    });
    this.$refs.hangup_btn.addEventListener("click", () => {
      self.is_modal = false;
      self.form.minute = "0";
      self.step = "1";
      self.device.disconnectAll();
      self.setStatus("Available");
      self.sendStatusSocket("Available");
      // re-calulate the minute and the cost
    });
    this.device.disconnect(function(connection) {
      self.is_modal = false;
    });
    this.device.connect(function(connection) {
      console.log(connection);
    });
    this.device.error(function(error) {
      console.error("ERROR: " + error.message);
      if (error.code == 31205) {
        self.initializeCallClient();
      }
    });
  },
  methods: {
    selectChannel(data) {
      if (!this.is_channel) {
        this.step = "step1";
        this.current_consultant = data;
        this.is_selected = true;
        if (!isMobile) {
          this.is_setting = true;
        }
        this.is_chat = false;
      }
    },
    // socket processing functions
    sendRequestSocket(type) {
      this.$socket.sendObj({
        command: "message",
        type: "request",
        sub_type: type,
        id: this.current_consultant.user.id,
        customer_id: this.authCustomer.user.id,
        customer_name:
          this.authCustomer.user.first_name +
          " " +
          this.authCustomer.user.last_name,
        min: this.form.minute,
        img: this.authCustomer.profile.avatar
      });
    },
    sendStatusSocket(msg) {
      this.$socket.sendObj({
        command: "message",
        id: this.authCustomer.user.id,
        type: "status",
        msg: msg
      });
    },
    setStatus(status) {
      axios.post("/api/manage_status", {
        id: this.authCustomer.user.id,
        status: status
      });
    },
    // chat module
    async startChat() {
      if (this.chat_accepted) {
        this.setStatus("In a chat");
        this.current_consultant.user.status = "In a call";
        this.is_chat = true;
        this.chat_session = true;
        axios
          .post("/api/chat_channel", {
            consultant_email: this.current_consultant.user.email,
            consultant_id: this.current_consultant.user.id,
            customer_email: this.authCustomer.user.email,
            customer_id: this.authCustomer.user.id
          })
          .then(response => {
            console.log("channel fetched!");
          });
        const chat_token = await this.fetchChatToken();
        await this.initializeChatClient(
          chat_token,
          this.current_consultant.user.id
        );
        await this.fetchMessages();
        this.scrollToEnd();
        let self = this;
        var interval = setInterval(function() {
          if (self.time_clock > 0) {
            self.time_clock--;
          } else {
            clearInterval(interval);
            self.sendRequestSocket("chat_pause");
            self.form.minute = "0";
            self.cost = "0";
            self.chat_session = false;
            self.is_session_modal = true;
          }
        }, 1000);
      }
    },
    continueChat() {
      this.sendRequestSocket("chat_continue");
      this.chat_session = true;
      let self = this;
      var interval = setInterval(function() {
        if (self.time_clock > 0) {
          self.time_clock--;
        } else {
          clearInterval(interval);
          self.sendRequestSocket("chat_pause");
          self.form.minute = "0";
          self.cost = "0";
          self.chat_session = false;
          self.is_session_modal = true;
        }
      }, 1000);
    },
    async fetchChatToken() {
      const { data } = await axios.post("/api/chat_token", {
        email: this.authCustomer.user.email
      });
      return data.token;
    },
    async initializeChatClient(token, id) {
      const client = await Twilio.Chat.Client.create(token);
      client.on("tokenAboutToExpire", async () => {
        const token = await this.fetchChatToken();
        client.updateToken(token);
      });
      this.channel = await client.getChannelByUniqueName(
        `private-${id}-${this.authCustomer.user.id}`
      );
      this.channel.on("messageAdded", message => {
        if (
          this.messages[this.messages.length - 1].state.index !=
          message.state.index
        ) {
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
      this.sendStatusSocket("In a chat");
    },
    sendMessage() {
      if (
        this.chat_session &&
        this.current_consultant.user.status != "Offline"
      ) {
        this.channel.sendMessage(this.newMessage);
        this.newMessage = "";
      }
    },
    // voice call module
    startCall() {
      this.sendRequestSocket("voice_call");
      var params = {
        phone: this.current_consultant.user.phone,
        callerId: this.authCustomer.user.phone,
        name:
          this.current_consultant.user.first_name +
          this.current_consultant.user.last_name,
        type: "voice",
        roomName: ""
      };
      this.device.connect(params);
      this.is_modal = true;
    },
    async initializeCallClient() {
      axios
        .post("/api/new_token", {
          name:
            this.current_consultant.user.first_name +
            this.current_consultant.user.last_name
        })
        .then(res => {
          this.device.setup(res.data.token, { debug: true });
        });
    },
    // video call module
    async initializeVideoClient() {
      await axios
        .post("/api/create_room", {
          name: `videoRoom-${this.current_consultant.user.id}-${this.authCustomer.user.id}`
        })
        .then(res => {
          console.log(res);
        });
    },
    async fetchVideoToken() {
      const { data } = await axios.post("/api/video_token", {
        userName:
          this.authCustomer.user.first_name + this.authCustomer.user.last_name,
        roomName: `videoRoom-${this.current_consultant.user.id}-${this.authCustomer.user.id}`
      });
      return data.token;
    },
    async startVideo() {
      this.sendRequestSocket("video_call");
      this.is_video_modal = true;
      let self = this;

      if (self.$refs.self_video_tag.children.length == 0) {
        createLocalVideoTrack({ audio: true, video: { width: 150 } }).then(
          track => {
            self.$refs.self_video_tag.appendChild(track.attach());
          }
        );
      }

      var params = {
        phone: this.current_consultant.user.phone,
        callerId: this.authCustomer.user.phone,
        name:
          this.current_consultant.user.first_name +
          this.current_consultant.user.last_name,
        type: "video",
        roomName: `videoRoom-${this.current_consultant.user.id}-${this.authCustomer.user.id}`
      };
      this.device.connect(params);

      const token = await this.fetchVideoToken();
      Video.connect(token, {
        name: `videoRoom-${this.current_consultant.user.id}-${this.authCustomer.user.id}`
      }).then(
        room => {
          console.log("Successfully joined a Room: ", room);
          self.activeRoom = room;
          // room.participants.forEach(self.participantConnected);

          room.on("participantConnected", self.participantConnected);

          room.on("participantDisconnected", self.participantDisconnected);

          room.once("disconnected", error =>
            room.participants.forEach(self.participantDisconnected)
          );
        },
        err => {
          console.error("Unable to connect to Room: " + err.message);
        }
      );
    },
    hangupVideoCall() {
      this.is_video_modal = false;
      this.form.minute = "0";
      this.step = "1";
      if (this.activeRoom) {
        this.activeRoom.localParticipant.tracks.forEach(function(track) {
          track.stop();
        });
        this.activeRoom.disconnect();
        this.setStatus("Available");
        this.sendStatusSocket("Available");
      }
      // re-calulate the minute and the cost
    },
    participantConnected(participant) {
      console.log('Participant "%s" connected', participant.identity);

      const div = document.createElement("div");
      div.ref = participant.sid;
      div.innerText = participant.identity;

      participant.on("trackSubscribed", track =>
        this.trackSubscribed(div, track)
      );
      participant.tracks.forEach(track => this.trackSubscribed(div, track));
      participant.on("trackUnsubscribed", this.trackUnsubscribed);

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
      if (this.current_consultant.user.status == "Available") {
        this.step = "step2";
        this.selected_type = type;
      }
    },
    goBack() {
      this.sendRequestSocket("chat_end");
      this.sendStatusSocket("Available");
      this.is_chat = false;
      this.is_channel = false;
      this.is_session_modal = false;
      this.step = "step1";
      this.cost = "";
      this.form.minute = "";
      this.isCheckReview = false;
      this.isCheckContinue = false;
    },
    mobilePrevStep() {
      this.is_selected = false;
    },
    async startMethod() {
      this.$v.form.$touch();
      if (this.$v.form.$error) return;
      this.is_channel = true;
      if (
        Number(this.authCustomer.user.balance) >
        Number(this.form.minute) * Number(this.current_consultant.hourly_rate)
      ) {
        await axios.post("/api/manage_transaction", {
          id: this.authCustomer.user.id,
          cost: this.cost,
          time: this.form.minute,
          consultant_id: this.current_consultant.id
        });
        switch (this.selected_type) {
          case "voice":
            // use consultant's name to generate token
            await this.initializeCallClient();
            this.startCall();
            break;
          case "video":
            // use consultant's name to generate token
            await this.initializeVideoClient();
            this.startVideo();
            break;
          case "chat":
            this.sendRequestSocket("chat_start");
            break;
        }
      }
    },
    restartMethod() {
      this.$v.form.$touch();
      if (this.$v.form.$error) return;
      this.is_session_modal = false;
      if (
        Number(this.authCustomer.user.balance) >
        Number(this.form.minute) * Number(this.current_consultant.hourly_rate)
      ) {
        switch (this.selected_type) {
          case "voice":
            this.startCall();
            break;
          case "video":
            this.startVideo();
            break;
          case "chat":
            this.continueChat();
            break;
        }
      } else {
        console.log("balance not enough");
      }
    },
    minuteChange() {
      this.cost =
        Number(this.form.minute) * Number(this.current_consultant.hourly_rate);
      this.time_clock = Number(this.form.minute) * 60;
    },
    submitReview() {
      axios
        .post("/api/submit_review", {
          sender_id: this.authCustomer.id,
          receiver_id: this.current_consultant.id,
          rate: this.rate,
          description: this.review_des,
          type: "CUSTOCON"
        })
        .then(res => {
          this.goBack();
        });
    },
    endSession() {
      this.sendRequestSocket("chat_end");
      this.sendStatusSocket("Available");
      let new_cost =
        ((this.form.minute * 60 - this.time_clock) / 60) *
        this.current_consultant.hourly_rate;
      this.time_clock = 0;
      this.form.minute = "0";
      this.cost = "0";
      this.chat_session = false;
      this.is_session_modal = true;
    },
    viewSession() {
      this.is_session_modal = false;
      this.time_clock = 0;
    },
    toHHMMSS(sec_num) {
      var hours = Math.floor(sec_num / 3600);
      var minutes = Math.floor((sec_num - hours * 3600) / 60);
      var seconds = sec_num - hours * 3600 - minutes * 60;

      if (hours < 10) {
        hours = "0" + hours;
      }
      if (minutes < 10) {
        minutes = "0" + minutes;
      }
      if (seconds < 10) {
        seconds = "0" + seconds;
      }
      return hours + ":" + minutes + ":" + seconds;
    },
    goToReview() {
      this.isCheckReview = true;
      this.isCheckContinue = false;
    },
    goToContinue() {
      this.isCheckContinue = true;
      this.isCheckReview = false;
    },
    scrollToEnd() {
      var container = this.$el.querySelector("#scroll-view");
      container.scrollTop = container.scrollHeight;
    },
    showSetting() {
      this.is_setting = true;
    }
  }
};
</script>
