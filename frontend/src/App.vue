<template>
  <div id="app">
    <nav-bar v-if="isAuthenticated" />
    <router-view />
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import NavBar from './components/NavBar.vue'

export default {
  name: 'App',
  components: {
    NavBar,
  },
  computed: {
    ...mapGetters('auth', ['isAuthenticated']),
  },
}
</script>

<style>
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
  background-color: #f5f7fa;
}
</style>
