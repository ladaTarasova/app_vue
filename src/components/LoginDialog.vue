<template>
  <Dialog 
    v-model:visible="visible" 
    header="Вход в систему" 
    :modal="true" 
    :closable="false"
    :style="{ width: '400px' }"
  >
    <div style="display: flex; flex-direction: column; gap: 15px; padding: 10px 0">
      <div>
        <label style="display: block; margin-bottom: 5px; font-weight: 500">Email</label>
        <InputText 
          v-model="email" 
          placeholder="Введите email" 
          style="width: 100%" 
          @keyup.enter="login"
        />
      </div>
      <div>
        <label style="display: block; margin-bottom: 5px; font-weight: 500">Пароль</label>
        <InputText 
          v-model="password" 
          type="password" 
          placeholder="Введите пароль" 
          style="width: 100%" 
          @keyup.enter="login"
        />
      </div>
      <div v-if="errorMessage" style="color: #e74c3c; font-size: 14px">
        {{ errorMessage }}
      </div>
    </div>
    <template #footer>
      <Button 
        label="Войти" 
        icon="pi pi-check" 
        class="p-button-primary" 
        @click="login" 
        :loading="loading"
      />
    </template>
  </Dialog>
</template>

<script>
import Dialog from 'primevue/dialog'
import InputText from 'primevue/inputtext'
import Button from 'primevue/button'
import axios from 'axios'

export default {
  name: 'LoginDialog',
  components: { Dialog, InputText, Button },
  data() {
    return {
      visible: true,
      email: '',
      password: '',
      loading: false,
      errorMessage: ''
    }
  },
  methods: {
    async login() {
      if (!this.email || !this.password) {
        this.errorMessage = 'Введите email и пароль'
        return
      }
      
      this.loading = true
      this.errorMessage = ''
      
      try {
const response = await axios.post('http://localhost/ci_oauth/public/index.php/api/login', {
  email: this.email,
  password: this.password
});
        
        if (response.data && response.data.access_token) {
          localStorage.setItem('access_token', response.data.access_token)
          this.visible = false
          this.$emit('login-success')
          window.location.href = '/'
        } else {
          this.errorMessage = 'Неверный ответ сервера'
        }
      } catch (error) {
        console.error('Ошибка входа:', error)
        this.errorMessage = error.response?.data?.message || 'Ошибка входа. Проверьте данные.'
      } finally {
        this.loading = false
      }
    }
  }
}
</script>