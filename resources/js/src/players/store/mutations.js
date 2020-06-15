let mutations = {
    ADD_PLAYER(state, player) {
        state.players = [player, ...state.players]
    },
    CACHE_REMOVED(state, player) {
      state.toRemovePlayer = player;
    },
    GET_PLAYERS(state, players) {
        state.players = players
    },
    DELETE_PLAYER(state, player) {
        state.players.splice(state.players.indexOf(player), 1)
        state.toRemove = null;
    },
    PLAYER_STATUS_UPDATE(state, player) {
        for (var i in state.players) {
            if (state.players[i].id == player.id) {
                state.players[i].status = player.status;
                break; //Stop this loop, we found it!
            }
        }
    },
    PLAYER_TEAM_UPDATE(state, player) {
        for (var i in state.players) {
            if (state.players[i].id == player.id) {
                state.players[i].type = player.type;
                state.players[i].team_id = player.team_id;
                break; //Stop this loop, we found it!
            }
        }
    }
}

export default mutations