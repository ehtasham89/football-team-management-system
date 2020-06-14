import auth from './../src/auth/store/state';
import players from './../src/players/store/state';
import teams from './../src/teams/store/state';

//combine all states
let states = { ...auth, ...players, ...teams};

export default states;