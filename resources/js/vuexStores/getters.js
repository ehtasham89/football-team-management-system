import auth from './../src/auth/store/getters';
import players from './../src/players/store/getters';
import teams from './../src/teams/store/getters';

//combine all getters
let getters = { ...auth, ...players, ...teams};

export default getters;