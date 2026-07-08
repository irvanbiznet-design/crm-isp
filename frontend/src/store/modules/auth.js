import axios from 'axios'

const API_URL = process.env.VUE_APP_API_URL || 'http://localhost:8000/api'

const state = {
  token: localStorage.getItem('token') || null,
  user: JSON.parse(localStorage.getItem('user')) || null,
}

const getters = {
  isAuthenticated: (state) => !!state.token,
  user: (state) => state.user,
}

const mutations = {
  SET_TOKEN(state, token) {
    state.token = token
    localStorage.setItem('token', token)
    axios.defaults.headers.common['Authorization'] = `Bearer ${token}`
  },
  SET_USER(state, user) {
    state.user = user
    localStorage.setItem('user', JSON.stringify(user))
  },
  CLEAR_AUTH(state) {
    state.token = null
    state.user = null
    localStorage.removeItem('token')
    localStorage.removeItem('user')
    delete axios.defaults.headers.common['Authorization']
  },
}

const actions = {
  async login({ commit }, credentials) {
    try {
      const response = await axios.post(`${API_URL}/login`, credentials)
      commit('SET_TOKEN', response.data.access_token)
      commit('SET_USER', response.data.user)
      return response.data
    } catch (error) {
      throw error.response.data
    }
  },
  async register({ commit }, data) {
    try {
      const response = await axios.post(`${API_URL}/register`, data)
      return response.data
    } catch (error) {
      throw error.response.data
    }
  },
  async logout({ commit }) {
    try {
      await axios.post(`${API_URL}/logout`)
      commit('CLEAR_AUTH')
    } catch (error) {
      commit('CLEAR_AUTH')
      throw error
    }
  },
  async getUser({ commit }) {
    try {
      const response = await axios.get(`${API_URL}/me`)
      commit('SET_USER', response.data.user)
      return response.data.user
    } catch (error) {
      throw error.response.data
    }
  },
}

export default {
  namespaced: true,
  state,
  getters,
  mutations,
  actions,
}
