<template>
        <li class="grey-text dropdown dropdown-notifications">
            <a href="#notifications-panel" class="dropdown-toggle" data-toggle="dropdown">
                <i :data-count="total" class="ion-ios-bell-outline iconos notification-icon"></i>
            </a>

            <div class="dropdown-container dropdown-position-bottomright">

                <div class="dropdown-toolbar">
                    <div v-show="hasUnread" class="dropdown-toolbar-actions">
                        <a href="#" @click.prevent="markAllRead">Marcar todas como leidas</a>
                    </div>

                    <h3 class="dropdown-toolbar-title">Notifications ({{ total }})</h3>
                </div>

                <ul class="dropdown-menu">

                    <notification v-for="notification in notifications"
                                  :key="notification.id"
                                  :notification="notification"
                                  v-on:read="markAsRead(notification)"
                    ></notification>
                    <li v-if="!hasUnread" class="notification">
                        No tiene notifiaciones pendientes.
                    </li>
                </ul>

                <div v-if="hasUnread" class="dropdown-footer text-center">
                    <a href="#" @click.prevent="fetchAll(null)">Ver todas</a>
                </div>

            </div><!-- /dropdown-container -->
        </li><!-- /dropdown -->
        </li>
</template>

<script>
import $ from 'jquery'
import axios from 'axios'
import Notification from './Notification.vue'

export default {
  components: { Notification },

  data: () => ({
    total: 0,
    notifications: []
  }),

  mounted () {
    this.fetch()

    if (window.Echo) {
      this.listen()
    }

    this.initDropdown()
  },

  computed: {
    hasUnread () {
      return this.total > 0
    }
  },

  methods: {
    /**
     * Fetch notifications.
     *
     * @param {Number} limit
     */
    fetch (limit = 20) {
      axios.get('/notifications', { params: { limit }})
        .then(({ data: { total, notifications }}) => {
          this.total = total
          this.notifications = notifications.map(({ id, data, created }) => {
            return {
              id: id,
              titulo: data.titulo,
              mensaje: data.mensaje,
              creada: data.creada,
              url: data.url
            }
          })
        })
    },

    /**
     * Mark the given notification as read.
     *
     * @param {Object} notification
     */
    markAsRead ({ id }) {
      const index = this.notifications.findIndex(n => n.id === id)

      if (index > -1) {
        this.total--
        this.notifications.splice(index, 1)
        axios.patch(`/notifications/${id}/read`)
      }
    },

    /**
     * Mark all notifications as read.
     */
    markAllRead () {
      this.total = 0
      this.notifications = []

      axios.post('/notifications/mark-all-read')
    },

    /**
     * Listen for Echo push notifications.
     */
    listen () {
      window.Echo.private(`App.User.${window.Laravel.user.id}`)
        .notification(notification => {
          this.total++
          this.notifications.unshift(notification)
        })
        .listen('NotificationRead', ({ notificationId }) => {
          this.total--

          const index = this.notifications.findIndex(n => n.id === notificationId)
          if (index > -1) {
            this.notifications.splice(index, 1)
          }
        })
        .listen('NotificationReadAll', () => {
          this.total = 0
          this.notifications = []
        })
    },

    /**
     * Initialize the notifications dropdown.
     */
    initDropdown () {
      const dropdown = $(this.$refs.dropdown)

      $(document).on('click', (e) => {
        if (!dropdown.is(e.target) && dropdown.has(e.target).length === 0 &&
          !$(e.target).parent().hasClass('notification-mark-read')) {
          dropdown.removeClass('open')
        }
      })
    },

    /**
     * Toggle the notifications dropdown.
     */
    toggleDropdown () {
      $(this.$refs.dropdown).toggleClass('open')
    }
  }
}
</script>
