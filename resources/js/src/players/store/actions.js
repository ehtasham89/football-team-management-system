let actions = {
    ADD_PLAYER({commit}, player) {
          axios.post('/api/players', player).then(res => {
              if (res.data === "added")
                  console.log('ok')
          }).catch(err => {
              console.log(err)
          })
    },
    DELETE_PLAYER({commit}, player) {
          axios.delete(`/api/players/${player.id}`)
              .then(res => {
                  if (res.data === 'deleted')
                      console.log('deleted')
              }).catch(err => {
                  console.log(err)
              })
    },
    GET_PLAYERS({commit}) {
          axios.get('/api/players')
              .then(res => {
                  {  console.log(res.data)
                      commit('GET_PLAYERS', res.data)
                  }
              }).catch(err => {
                  console.log(err)
              })
    }
  }

  export default actions