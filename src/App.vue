<template>
  <div id="app">
    <Menu v-if="isLoggedIn" />
    <router-view :key="$route.fullPath" />
  </div>
</template>

<script>
import Menu from './components/Menu.vue'

export default {
  name: 'App',
  components: {
    Menu
  },
  computed: {
    isLoggedIn() {
      return !!localStorage.getItem('access_token')
    }
  }
}
</script>

<style>
body {
  margin: 0;
  font-family: Arial, sans-serif;
}
</style>