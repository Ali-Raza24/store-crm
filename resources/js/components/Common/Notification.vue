<template>
  <div class="dropdown dropdown-notify">
    <button
      class="notification-page mobile-hide dropdown-toggle"
      type="button"
      id="dropNotify"
      data-toggle="dropdown"
      aria-haspopup="true"
      aria-expanded="false"
    >
      <img
        alt=""
        :src="base_url + '/business_assets/images/notification.png'"
      />
      <span class="bege bg-dark-pink text-white">{{
        unreadNotifications.length
      }}</span>
    </button>
    <div
      class="dropdown-menu dropdown-menu-right scroll-bar-thin"
      aria-labelledby="dropNotify"
      x-placement="bottom-end"
      style="position: absolute; transform: translate3d(-275px, 31px, 0px); top: 0px; left: 0px; will-change: transform;"
    >
      <div
        class="unreadable"
        v-for="(notify, index) in unreadNotifications"
        :key="notify.id"
      >
        <div class="nitify-list">
          <div class="notify-txt">
            <button
              type="button"
              class="dismiss-list"
              @click="removeNotification(notify.id)"
            >
              <img
                alt=""
                :src="base_url + '/business_assets/images/close-black.png'"
              />
            </button>
          </div>
          <p
            class="darkcolor dark-one cursor-pointer"
            style="font-size: 13px"
            @click="notifyRedirect(notify.data.link, notify.id)"
          >
            {{ notify.data.message }}
          </p>
          <div class="d-flex justify-content-between">
            <span class="notify-message" style="font-size:10px">
              {{ notify.data.user }}
            </span>
            <span class="notify-time" style="font-size:10px">{{
              formatDate(notify.created_at)
            }}</span>
          </div>
        </div>
      </div>
      <div
        class="nitify-list"
        v-for="(notify, index) in readNotifications"
        :key="notify.id"
      >
        <div class="notify-txt">
          <button
            type="button"
            class="dismiss-list"
            @click="removeNotification(notify.id)"
          >
            <img
              alt=""
              :src="base_url + '/business_assets/images/close-black.png'"
            />
          </button>
        </div>
        <p
          class="darkcolor dark-one cursor-pointer"
          style="font-size: 13px"
          @click="notifyRedirect(notify.data.link, notify.id)"
        >
          {{ notify.data.message }}
        </p>
        <div class="d-flex justify-content-between">
          <span class="notify-message" style="font-size:10px">
            {{ notify.data.user }}
          </span>
          <span class="notify-time" style="font-size:10px">{{
            formatDate(notify.created_at)
          }}</span>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      base_url: this.$parent.$data.base_url,
      notifications: [],
      allNotifications: []
    }
  },
  created() {
    Notification.requestPermission()
    this.listenForChanges()
    this.fetch()
  },
  computed: {
    unreadNotifications: function() {
      return this.notifications.filter((notify) => {
        if (empty(notify.read_at)) {
          return notify.data
        }
      })
    },
    readNotifications: function() {
      return this.notifications.filter((notify) => {
        if (!empty(notify.read_at)) {
          return notify.data
        }
      })
    }
  },
  methods: {
    formatDate(date) {
      return moment(date).fromNow()
    },
    notifyRedirect(url, id) {
      axios.put(this.base_url + '/notification/read/' + id).then((response) => {
        this.fetch()
      })
      setTimeout(function() {
        window.location.href = url
      }, 1000)
    },
    listenForChanges() {
      Echo.channel('business')
        .listen('AccountInfoUpdated', () => {
          this.fetch()
        })
        .listen('Complaint', () => {
          this.fetch()
        })
        .listen('InvitationAccepted', () => {
          this.fetch()
        })
        .listen('InvoiceGenerated', () => {
          this.fetch()
        })
        .listen('NewRoleCreated', () => {
          this.fetch()
        })
        .listen('NewSignIn', () => {
          this.fetch()
        })
        .listen('NewUserCreated', () => {
          this.fetch()
        })
        .listen('OogoPayIntegration', () => {
          this.fetch()
        })
        .listen('OrderCancel', () => {
          this.fetch()
        })
        .listen('OrderDelivered', () => {
          this.fetch()
        })
        .listen('OrderPlaced', () => {
          this.fetch()
        })
        .listen('OrderRefund', () => {
          this.fetch()
        })
        .listen('PaymentError', () => {
          this.fetch()
        })
        .listen('PaymentRefund', () => {
          this.fetch()
        })
        .listen('PaymentSuccess', () => {
          this.fetch()
        })
        .listen('ReportExported', () => {
          this.fetch()
        })
        .listen('RoleUpdated', () => {
          this.fetch()
        })
        .listen('StoreInfoUpdated', () => {
          this.fetch()
        })
        .listen('Subscription', () => {
          this.fetch()
        })
        .listen('UserUpdated', () => {
          this.fetch()
        })
        .listen('Welcome', () => {
          this.fetch()
        })
    },
    fetch() {
      axios.get('/notifications').then((response) => {
        this.notifications = response.data.data
        this.allNotifications = this.notifications
      })
    },
    removeNotification(id) {
      axios
        .delete(this.base_url + '/notification/delete/' + id)
        .then((response) => {
          this.fetch()
        })
    }
  }
}
</script>

<style>
@import './../../../../public/plugins/fontawesome/css/all.css';

#notification ul {
  max-height: 500px !important;
  overflow-y: scroll;
}
.message {
  display: table;
  position: relative;
  width: 350px;
  /*background-color: #0074d9;*/
  /*color: #fff;*/
  transition: all 0.2s ease;
}

.message--orange {
  background-color: #f39c12;
}

.message--red {
  background-color: #ff4136;
}

.message--green {
  background-color: #2ecc40;
}

.message-icon {
  display: table-cell;
  vertical-align: middle;
  width: 10px;
  padding: 10px;
  text-align: center;
  background-color: rgba(0, 0, 0, 0.25);
}
.message-icon > i {
  width: 20px;
  font-size: 20px;
}

.message-body {
  display: table-cell;
  vertical-align: middle;
  padding: 5px 5px 5px 5px;
}
.message-body > p {
  line-height: 18px;
  margin-top: 6px;
}

.message-close {
  position: absolute;
  background-color: #ffffff;
  color: #000000;
  border: none;
  outline: none;
  font-size: 20px;
  right: 5px;
  top: 7px;
  /*opacity: 0;*/
  cursor: pointer;
}
.message:hover .Message-close {
  opacity: 1;
}
.message-close:hover {
  /*background-color: rgba(0, 0, 0, 0.5);*/
}
</style>
