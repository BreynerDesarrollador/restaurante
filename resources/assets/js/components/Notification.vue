<template>
<li class="notification">
        <div class="media">
            <div class="media-left">
                <div class="media-object">
                    <img width="50" height="50" alt="waiter notificaciones"
                         src="/img/WAITER50.png">
                </div>
            </div>
            <div class="media-body">
                <strong class="notification-title truncate">
                    <a :href="notification.url" style="width:300px">{{ notification.titulo }}</a>
                </strong>

                <p class="notification-desc">{{ notification.mensaje }}</p>

                <div class="notification-meta">
                    <small class="timestamp">
                        <timeago :since="notification.creada" :auto-update="30"></timeago>
                    </small>
                </div>

            </div>
        </div>
    </li>
</template>

<script>
export default {
  props: ['notification'],

  methods: {
    markAsRead () {
      this.$emit('read')
    }
  }
}
</script>
