import { createRouter, createWebHistory } from 'vue-router'
import Home from '../views/Home.vue'
import Rating from '../views/Rating.vue'
import LoginDialog from '../components/LoginDialog.vue'

const routes = [
  { path: '/', component: Home },
  { path: '/ratings', component: Rating },
  { path: '/login', component: LoginDialog }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

export default router