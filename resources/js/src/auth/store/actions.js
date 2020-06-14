let actions = {
    ADD_USER({commit}, user) {
        axios.get('/auth/user', user).then(res => {
            res && res.data && commit('ADD_USER', res.data.data); //store auth user to store
        }).catch(err => {
            console.log(err)
        });
    },

    GET_USER({commit}) {
        commit('GET_USER'); //store auth user to store
    }
}

export default actions