let mutations = {
    ADD_TEAM(state, team) {
        state.teams.unshift(team)
    },
    CACHE_REMOVED(state, team) {
      state.toRemoveTeam = team;
    },
    GET_TEAMS(state, teams) {
        state.teams = teams
    },
    DELETE_TEAM(state, player) {
        state.players.splice(state.teams.indexOf(player), 1)
        state.toRemove = null;
    }
}

export default mutations