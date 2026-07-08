import axios from 'axios'

const API_URL = process.env.VUE_APP_API_URL || 'http://localhost:8000/api'

const state = {
  customers: [],
  currentCustomer: null,
  loading: false,
  error: null,
}

const getters = {
  customers: (state) => state.customers,
  currentCustomer: (state) => state.currentCustomer,
  loading: (state) => state.loading,
}

const mutations = {
  SET_CUSTOMERS(state, customers) {
    state.customers = customers
  },
  SET_CURRENT_CUSTOMER(state, customer) {
    state.currentCustomer = customer
  },
  SET_LOADING(state, loading) {
    state.loading = loading
  },
  SET_ERROR(state, error) {
    state.error = error
  },
}

const actions = {
  async fetchCustomers({ commit }, perPage = 15) {
    commit('SET_LOADING', true)
    try {
      const response = await axios.get(`${API_URL}/customers?per_page=${perPage}`)
      commit('SET_CUSTOMERS', response.data.data)
    } catch (error) {
      commit('SET_ERROR', error.message)
      throw error
    } finally {
      commit('SET_LOADING', false)
    }
  },
  async fetchCustomerById({ commit }, id) {
    commit('SET_LOADING', true)
    try {
      const response = await axios.get(`${API_URL}/customers/${id}`)
      commit('SET_CURRENT_CUSTOMER', response.data.data)
      return response.data.data
    } catch (error) {
      commit('SET_ERROR', error.message)
      throw error
    } finally {
      commit('SET_LOADING', false)
    }
  },
  async createCustomer({ commit }, data) {
    try {
      const response = await axios.post(`${API_URL}/customers`, data)
      return response.data.data
    } catch (error) {
      commit('SET_ERROR', error.message)
      throw error
    }
  },
  async updateCustomer({ commit }, { id, data }) {
    try {
      const response = await axios.put(`${API_URL}/customers/${id}`, data)
      commit('SET_CURRENT_CUSTOMER', response.data.data)
      return response.data.data
    } catch (error) {
      commit('SET_ERROR', error.message)
      throw error
    }
  },
  async deleteCustomer({ commit }, id) {
    try {
      await axios.delete(`${API_URL}/customers/${id}`)
    } catch (error) {
      commit('SET_ERROR', error.message)
      throw error
    }
  },
  async searchCustomers({ commit }, query) {
    try {
      const response = await axios.get(`${API_URL}/customers/search/query?q=${query}`)
      commit('SET_CUSTOMERS', response.data.data)
      return response.data.data
    } catch (error) {
      commit('SET_ERROR', error.message)
      throw error
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
