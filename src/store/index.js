import { createStore } from 'vuex'
import router from '../router'

const backendUrl = 'http://localhost/ci_oauth/public/index.php'

const store = createStore({
  state: {
    user: {},
    token: null,
    preLoading: false,
    dataPreLoading: true,
    loginError: false,
    loggedIn: false,
    rating: [],
    pager: {
      currentPage: 1,
      perPage: 5,
      total: 0
    }
  },
  mutations: {
    setToken(state, token) {
      state.token = token
    },
    setUser(state, user) {
      state.user = user
    },
    setPreloading(state, is_load) {
      state.preLoading = is_load
    },
    setDataPreloading(state, is_load) {
      state.dataPreLoading = is_load
    },
    setLoginError(state, is_error) {
      state.loginError = is_error
    },
    setLoggedIn(state, is_logged) {
      state.loggedIn = is_logged
    },
    setRating(state, data) {
      state.rating = data
    },
    setPager(state, data) {
      state.pager = { ...state.pager, ...data }
    },
    setPage(state, page) {
      state.pager.currentPage = page
    }
  },
  actions: {
    async auth({ commit }, { login, password }) {
      try {
        const response = await fetch(`${backendUrl}/api/login`, {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ email: login, password: password })
        })
        const data = await response.json()
        
        if (data.access_token) {
          commit('setToken', data.access_token)
          commit('setLoggedIn', true)
          commit('setLoginError', false)
          localStorage.setItem('access_token', data.access_token)
          router.push('/')
        } else {
          commit('setLoginError', true)
        }
      } catch (error) {
        console.error('Ошибка входа:', error)
        commit('setLoginError', true)
      }
    },
    
    async getRating({ commit, state }) {
      commit('setDataPreloading', true)
      try {
        const token = localStorage.getItem('access_token')
        const response = await fetch(
          `${backendUrl}/api/ratings?page=${state.pager.currentPage}`,
          {
            headers: { 'Authorization': `Bearer ${token}` }
          }
        )
        const data = await response.json()
        
        if (data && data.data) {
          commit('setRating', data.data)
          commit('setPager', {
            currentPage: data.pagination?.current_page || 1,
            lastPage: data.pagination?.last_page || 1,
            perPage: data.pagination?.per_page || 5,
            total: data.pagination?.total || 0
          })
        }
      } catch (error) {
        console.error('Ошибка загрузки:', error)
      } finally {
        commit('setDataPreloading', false)
      }
    },
    
    logout({ commit }) {
      localStorage.removeItem('access_token')
      commit('setToke', null)
      commit('setLoggedIn', false)
      router.push('/login')
    }
  }
})

export default store