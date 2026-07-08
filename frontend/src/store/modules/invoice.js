import axios from 'axios'

const API_URL = process.env.VUE_APP_API_URL || 'http://localhost:8000/api'

const state = {
  invoices: [],
  currentInvoice: null,
  loading: false,
}

const getters = {
  invoices: (state) => state.invoices,
  currentInvoice: (state) => state.currentInvoice,
  loading: (state) => state.loading,
}

const mutations = {
  SET_INVOICES(state, invoices) {
    state.invoices = invoices
  },
  SET_CURRENT_INVOICE(state, invoice) {
    state.currentInvoice = invoice
  },
  SET_LOADING(state, loading) {
    state.loading = loading
  },
}

const actions = {
  async fetchInvoices({ commit }, perPage = 15) {
    commit('SET_LOADING', true)
    try {
      const response = await axios.get(`${API_URL}/invoices?per_page=${perPage}`)
      commit('SET_INVOICES', response.data.data)
    } catch (error) {
      throw error
    } finally {
      commit('SET_LOADING', false)
    }
  },
  async fetchInvoiceById({ commit }, id) {
    try {
      const response = await axios.get(`${API_URL}/invoices/${id}`)
      commit('SET_CURRENT_INVOICE', response.data.data)
      return response.data.data
    } catch (error) {
      throw error
    }
  },
  async createInvoice({ commit }, data) {
    try {
      const response = await axios.post(`${API_URL}/invoices`, data)
      return response.data.data
    } catch (error) {
      throw error
    }
  },
  async updateInvoice({ commit }, { id, data }) {
    try {
      const response = await axios.put(`${API_URL}/invoices/${id}`, data)
      return response.data.data
    } catch (error) {
      throw error
    }
  },
  async deleteInvoice({ commit }, id) {
    try {
      await axios.delete(`${API_URL}/invoices/${id}`)
    } catch (error) {
      throw error
    }
  },
  async fetchUnpaidInvoices({ commit }) {
    try {
      const response = await axios.get(`${API_URL}/invoices/unpaid/list`)
      commit('SET_INVOICES', response.data.data)
      return response.data.data
    } catch (error) {
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
