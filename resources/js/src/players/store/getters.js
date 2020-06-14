let getters = {
    newPlayer: state => {
        return state.newPlayer
    },
    players: state => {
        return state.players
    },
    toRemovePlayer: state => {
        return state.toRemovePlayer
    }
}

export default getters