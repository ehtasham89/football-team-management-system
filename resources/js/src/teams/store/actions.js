let actions = {
    ADD_TEAM({commit}, team) {
        axios.post('/api/teams', team).then(res => {
              if (res.data === "added")
                  console.log('ok')
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
    GET_TEAMS({commit}) {
        axios.get('/api/teams')
              .then(res => {
                  {  console.log(res.data)
                      commit('GET_TEAMS', res.data)
                  }
              }).catch(err => {
                  console.log(err)
              })
    }
  }

  export default actions