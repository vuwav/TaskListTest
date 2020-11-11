import axios from 'axios'
import {api} from '~/config'
import * as types from '../mutation-types'

/**
 * Initial state
 */
export const state = {
  user: null,
  token: window.localStorage.getItem('token')
}

/**
 * Mutations
 */
export const mutations = {
  [types.SET_USER](state, {user, workers}) {
    user.workers = workers;
    state.user = user
  },

  [types.LOGOUT](state) {
    state.user = null
    state.token = null
    window.localStorage.removeItem('token')
  },

  [types.FETCH_USER_FAILURE](state) {
    state.user = null
    window.localStorage.removeItem('token')
  },

  [types.SET_TOKEN](state, {user}) {
    let token = user.api_token
    state.token = token
    window.localStorage.setItem('token', token)
  }
}

/**
 * Actions
 */
export const actions = {
  saveToken({commit}, payload) {
    commit(types.SET_TOKEN, payload)
  },

  async fetchUser({commit}) {
    try {
      const {data} = await axios.get('/' + api.path('me'))
      console.log(data);
      commit(types.SET_USER, data)
    } catch (e) {
      commit(types.FETCH_USER_FAILURE)
    }
  },

  setUser({commit}, payload) {
    commit(types.SET_USER, payload)
  },

  async logout({commit}) {
    commit(types.LOGOUT)
  },

  destroy({commit}) {
    commit(types.LOGOUT)
  }
}

/**
 * Getters
 */
export const getters = {
  user: state => state.user,
  check: state => state.user !== null,
  token: state => state.token
}
