import axios from 'axios'

const API_URL = process.env.VUE_APP_API_URL || 'http://localhost:8000/api'

const state = {
  tickets: [],
  currentTicket: null,
  loading: false,
}

const getters = {
  tickets: (state) => state.tickets,
  currentTicket: (state) => state.currentTicket,
  loading: (state) => state.loading,
}

const mutations = {
  SET_TICKETS(state, tickets) {
    state.tickets = tickets
  },
  SET_CURRENT_TICKET(state, ticket) {
    state.currentTicket = ticket
  },
  SET_LOADING(state, loading) {
    state.loading = loading
  },
}

const actions = {
  async fetchTickets({ commit }, perPage = 15) {
    commit('SET_LOADING', true)
    try {
      const response = await axios.get(`${API_URL}/tickets?per_page=${perPage}`)
      commit('SET_TICKETS', response.data.data)
    } catch (error) {
      throw error
    } finally {
      commit('SET_LOADING', false)
    }
  },
  async fetchTicketById({ commit }, id) {
    try {
      const response = await axios.get(`${API_URL}/tickets/${id}`)
      commit('SET_CURRENT_TICKET', response.data.data)
      return response.data.data
    } catch (error) {
      throw error
    }
  },
  async createTicket({ commit }, data) {
    try {
      const response = await axios.post(`${API_URL}/tickets`, data)
      return response.data.data
    } catch (error) {
      throw error
    }
  },
  async updateTicket({ commit }, { id, data }) {
    try {
      const response = await axios.put(`${API_URL}/tickets/${id}`, data)
      return response.data.data
    } catch (error) {
      throw error
    }
  },
  async deleteTicket({ commit }, id) {
    try {
      await axios.delete(`${API_URL}/tickets/${id}`)
    } catch (error) {
      throw error
    }
  },
  async fetchOpenTickets({ commit }) {
    try {
      const response = await axios.get(`${API_URL}/tickets/open/list`)
      commit('SET_TICKETS', response.data.data)
      return response.data.data
    } catch (error) {
      throw error
    }
  },
  async searchTickets({ commit }, query) {
    try {
      const response = await axios.get(`${API_URL}/tickets/search/query?q=${query}`)
      commit('SET_TICKETS', response.data.data)
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
