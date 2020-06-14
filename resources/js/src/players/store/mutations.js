let mutations = {
    ADD_PLAYER(state, player) {
        state.todos.unshift(player)
    },
    CACHE_REMOVED(state, player) {
      state.toRemovePlayer = player;
    },
    GET_PLAYERS(state, players) {
        state.todos = players
    },
    DELETE_PLAYER(state, player) {
        state.players.splice(state.players.indexOf(player), 1)
        state.toRemove = null;
    }
}

export default mutations