import Vue from 'vue'
import Vuex from 'vuex'
import actions from './actions'
import mutations from './mutations'
import getters from './getters'
import state from "./states";

Vue.use(Vuex);

// all combine stores
export default new Vuex.Store({
    state,
    mutations,
    getters,
    actions
})