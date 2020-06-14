let mutations = {
    USER_CACHE_REMOVED(state, user) {
      state.toRemoveUser = user;
    },
    ADD_USER(state, user) {
        state.user = user
    },
    GET_USER(state, user) {
        state.user = user
    }
}

export default mutations