import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import axios from 'axios'

import PrimeVue from 'primevue/config'
import 'primevue/resources/themes/bootstrap4-light-blue/theme.css'
import 'primevue/resources/primevue.min.css'
import 'primeicons/primeicons.css'

axios.defaults.baseURL = 'http://localhost/ci_oauth/public/index.php'

const app = createApp(App)
app.use(router)
app.use(store)
app.use(PrimeVue)
app.mount('#app')

