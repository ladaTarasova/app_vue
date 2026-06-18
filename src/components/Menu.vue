<template>
  <Menubar :model="items">
    <template #start>
      <a href="/">
        <img alt="Logo" src="../assets/logo.png" width="30" style="margin-right: 10px">
      </a>
      <span style="font-weight: bold; color: #2196F3">Мой проект</span>
    </template>
    <template #end>
      <span v-if="username" style="margin-right: 15px; color: #555">
        {{ username }}
      </span>
      <Button 
        v-if="isLoggedIn" 
        label="Выйти" 
        icon="pi pi-sign-out" 
        class="p-button-danger p-button-sm" 
        @click="logout"
      />
    </template>
  </Menubar>
</template>

<script>
import Menubar from 'primevue/menubar'
import Button from 'primevue/button'
import router from '../router'

export default {
  name: 'Menu',
  components: { Menubar, Button },
  data() {
    return {
      items: [
        {
          label: 'Главная',
          icon: 'pi pi-home',
          command: () => router.push('/')
        },
        {
          label: 'Рейтинг',
          icon: 'pi pi-chart-line',
          command: () => router.push('/rating')
        },
        {
          label: 'Создать рейтинг',
          icon: 'pi pi-plus',
          command: () => {
                this.$emit('open-create-dialog')
  }
}
      ]
    }
  },
  computed: {
    username() {
      const token = localStorage.getItem('access_token')
      if (token) {
        try {
          const payload = JSON.parse(atob(token.split('.')[1]))
          return payload.username || payload.email || 'Пользователь'
        } catch (e) {
          return 'Пользователь'
        }
      }
      return ''
    },
    isLoggedIn() {
      return !!localStorage.getItem('access_token')
    }
  },
  methods: {
    logout() {
      localStorage.removeItem('access_token')
      router.push('/login')
    }
  }
}
</script>