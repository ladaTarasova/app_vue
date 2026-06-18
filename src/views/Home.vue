<template>
  <div style="text-align: center; margin-top: 100px">
    <h2>Добро пожаловать!</h2>
    <p>Вы успешно вошли в систему</p>
    <router-link to="/ratings" style="display: inline-block; margin-top: 20px">
      Перейти к списку оценок
    </router-link>
    <button @click="logout">Выйти</button>
  </div>
</template>

<script>
export default {
  methods: {
    logout() {
      localStorage.removeItem('access_token')
      this.$router.push('/login')
    }
  }
}
</script>
