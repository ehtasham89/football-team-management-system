let actions = {
    ADD_TEAM({commit}, team) {
        axios.post('/teams/new', team).then(res => {
            res.data && commit("ADD_TEAM", {...team, id: res.data.team_id});

            alert(`New team (${team.name}) added successfully`);
        }).catch(err => {
            console.log(err)
        })
    },
    DELETE_TEAM({commit}, team) {
        axios.delete(`/api/teams/${team.id}`)
              .then(res => {
                  if (res.data === 'deleted')
                      console.log('deleted')
              }).catch(err => {
                  console.log(err)
              })
    },
    GET_TEAMS({commit}, callback = e => e) {
        axios.get('/teams')
              .then(res => {
                res.data && commit('GET_TEAMS', res.data.data);
                
                callback();
              }).catch(err => {
                callback();

                console.log(err)
              })
    },
    TEAM_STATUS_UPDATE({commit}, team) {
        axios.put(`/teams/${team.id}/status/${team.status}`).then(res => {
            commit("TEAM_STATUS_UPDATE", team);
        }).catch(err => {
          alert("error!");
            console.log(err)
        })
    }
  }

  export default actions