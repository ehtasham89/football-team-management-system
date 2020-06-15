let actions = {
    ADD_PLAYER({commit}, player) {
        axios.post('/players/new', player).then(res => {
        res.data && commit("ADD_PLAYER", {...player, id: res.data.player_id});

        alert(`New player (${player.name}) added successfully`);
        }).catch(err => {
            console.log(err)
        })
    },
    DELETE_PLAYER({commit}, player) {
        axios.delete(`/players/${player.id}`)
            .then(res => {
                if (res.data === 'deleted')
                    console.log('deleted')
            }).catch(err => {
                console.log(err)
            })
    },
    GET_PLAYERS({commit}, callback = e => e) {
        axios.get('/players')
            .then(res => {
                res.data && commit('GET_PLAYERS', res.data.data);
                
                callback();
            }).catch(err => {
                callback();

                console.log(err)
            })
    },
    PLAYER_STATUS_UPDATE({commit}, player) {
        axios.put(`/players/${player.id}/status/${player.status}`).then(res => {
            commit("PLAYER_STATUS_UPDATE", player);
        }).catch(err => {
          alert("error!");
            console.log(err)
        })
    },
    PLAYER_TEAM_UPDATE({commit}, player) {
        axios.put(`/players/${player.id}/with/${player.team_id}/type/${player.type}`).then(res => {
            commit("PLAYER_TEAM_UPDATE", player);
        }).catch(err => {
          alert("error!");
            console.log(err)
        })
    }
  }

  export default actions