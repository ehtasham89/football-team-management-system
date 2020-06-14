let getters = {
    newTeam: state => {
        return state.newTeam
    },
    teams: state => {
        return state.teams
    },
    toRemoveTeam: state => {
        return state.toRemoveTeam
    }
}

export default getters