import auth from './../src/auth/store/mutations';
import players from './../src/players/store/mutations';
import teams from './../src/teams/store/mutations';

//combine all mutations
let mutations = { ...auth, ...players, ...teams};

export default mutations;