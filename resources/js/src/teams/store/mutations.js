let mutations = {
    ADD_TEAM(state, team) {
        state.teams = [team, ...state.teams]
    },
    CACHE_REMOVED(state, team) {
      state.toRemoveTeam = team;
    },
    GET_TEAMS(state, teams) {
        state.teams = teams
    },
    DELETE_TEAM(state, player) {
        state.teams.splice(state.teams.indexOf(player), 1)
        state.toRemove = null;
    },
    TEAM_STATUS_UPDATE(state, team) {
        for (var i in state.teams) {
            if (state.teams[i].id == team.id) {
                state.teams[i].status = team.status;
               break; //Stop this loop, we found it!
            }
        }
    }
}

export default mutations