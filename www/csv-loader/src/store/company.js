import axios from 'axios'
import { createStore } from 'vuex'

const api = import.meta.env.VITE_API_PATH

const store = createStore({
  state: {
    employees: []
  },
  mutations: {
    setEmployees(state, employees) {
      state.employees = employees
    }
  },
  actions: {
    async GET_EMPLOYEES({ commit }) {
      return new Promise((resolve, fail) => {
        axios.get(`${api}/employees`).then(
          (response) => {
            const { data } = response
            if (data.result) {
              commit('setEmployees', data.result)
            }
          },
          (error) => {
            fail(error.response.data)
          }
        )
      })
    },
    async UPLOAD_CSV(file) {
      console.log('CORS Uploading?')
      return new Promise((resolve, fail) => {
        axios.post(`${api}/upload`, file).then(
          (res) => {},
          (error) => {
            fail(error.response.data)
          }
        )
      })
    }
  }
})

export default store
