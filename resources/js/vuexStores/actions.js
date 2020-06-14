import auth from './../src/auth/store/actions';
import players from './../src/players/store/actions';
import teams from './../src/teams/store/actions';

//combine all actions
let actions = { ...auth, ...players, ...teams};

export default actions;