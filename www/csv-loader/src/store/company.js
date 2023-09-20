import axios from 'axios'
import { createStore } from 'vuex'

const api = import.meta.env.VITE_API_PATH

const companyStore = createStore({
  state: {
    companies: [],
    employees: [],
    employee: {
      id: null,
      company: null,
      name: null,
      email: null,
      salary: null
    }
  },
  mutations: {
    setEmployees(state, employees) {
      state.employees = employees
    },
    setEmployee(state, employee) {
      state.employee = employee
    },
    updateEmployee(state, employee) {
      state.employees = state.employees.map((_employee) => {
        if (_employee.id === employee.id) {
          return employee
        } else {
          return _employee
        }
      })
    },
    setCompanies(state, companies) {
      state.companies = companies
    }
  },
  actions: {
    async GET_COMPANIES_AVG({ commit }) {
      return new Promise((resolve, fail) => {
        axios.get(`${api}/companies/average-salary`).then(
          (response) => {
            const { data } = response
            if (data.result) {
              commit('setCompanies', data.result)
            }
          },
          (error) => {
            fail(error.response.data)
          }
        )
      })
    },
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
    async UPLOAD_CSV({ dispatch }, request) {
      return new Promise((resolve, fail) => {
        axios.post(`${api}/upload`, request).then(
          (res) => {
            dispatch('GET_EMPLOYEES')
            const { message } = res.data
            resolve(message)
          },
          (error) => {
            const { data } = error.response
            fail(data)
          }
        )
      })
    },
    EDIT_EMPLOYEE({ commit }, employee) {
      commit('setEmployee', employee)
    },
    SAVE_EMPLOYEE({ commit, dispatch }, employee) {
      return new Promise((resolve, fail) => {
        axios.put(`${api}/employee/${employee.id}`, { ...employee }).then(
          (res) => {
            dispatch('GET_COMPANIES_AVG')
            commit('updateEmployee', employee)
            const { message } = res.data
            resolve(message)
          },
          (error) => {
            const { data } = error.response
            fail(data)
          }
        )
      })
    }
  }
})

export default companyStore
