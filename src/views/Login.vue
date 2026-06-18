<template>
  <div style="max-width: 400px; margin: 100px auto; padding: 20px; border: 1px solid #ccc; border-radius: 8px;">
    <h2 style="text-align: center;">Вход в систему</h2>
    <div style="margin-bottom: 15px;">
      <label>Email:</label>
      <input v-model="email" type="email" style="width: 100%; padding: 8px; margin-top: 5px; border: 1px solid #ccc; border-radius: 4px;">
    </div>
    <div style="margin-bottom: 15px;">
      <label>Пароль:</label>
      <input v-model="password" type="password" style="width: 100%; padding: 8px; margin-top: 5px; border: 1px solid #ccc; border-radius: 4px;">
    </div>
    <button @click="login" style="width: 100%; padding: 10px; background: #4CAF50; color: white; border: none; border-radius: 4px; cursor: pointer;">
      Войти
    </button>
    <div v-if="error" style="color: red; margin-top: 10px; text-align: center;">{{ error }}</div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      email: 'admin@admin.com',
      password: 'password',
      error: ''
    };
  },
  methods: {
    async login() {
      try {
const response = await axios.post('http://localhost/ci_oauth/public/index.php/api/login', {          email: this.email,
          password: this.password
        });
        if (response.data.access_token) {
          localStorage.setItem('access_token', response.data.access_token);
          this.$router.push('/');
        } else {
          this.error = 'Неверный логин или пароль';
        }
      } catch (e) {
        this.error = 'Ошибка входа. Проверьте данные.';
        console.error(e);
      }
    }
  }
};
</script>