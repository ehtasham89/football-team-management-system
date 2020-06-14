let actions = {
    GET_USER({commit}) {
        axios.get('/auth/user').then(res => {
            res && res.data && commit('GET_USER', res.data.data); //store auth user to store
        }).catch(err => {
            console.log(err)
        });
    }
}

export default actions