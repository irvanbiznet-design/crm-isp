import { createStore } from 'vuex'
import auth from './modules/auth'
import customer from './modules/customer'
import invoice from './modules/invoice'
import ticket from './modules/ticket'

export default createStore({
  modules: {
    auth,
    customer,
    invoice,
    ticket,
  },
})
