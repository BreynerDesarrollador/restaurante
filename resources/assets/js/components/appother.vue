<template>

</template>

<script>
export default {
  props: ['op','idbebidasplato'],

  methods: {
    markAsRead () {
      this.$emit('read')
    }
  }
}
</script>