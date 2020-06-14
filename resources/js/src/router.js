import VueRouter from 'vue-router'
// Components
import Register from './auth/Register'
import Login from './auth/Login'
import NotFound from './components/NotFound'
import DefaultView from './components/DefaultView'
import Teams from './teams/Index';
import Players from './players/Index';

// Routes
const routes = [
  {
    path: '/register',
    name: 'register',
    component: Register,
    meta: {
      auth: false
    }
  },
  {
    path: '/login',
    name: 'login',
    component: Login,
    meta: {
      auth: false
    }
  },
  {
    path: '/404',
    name: 'not-found',
    component: NotFound,
    meta: {
      auth: undefined
    }
  },
  // USER ROUTES
  {
    path: '/dashboard',
    name: 'dashboard',
    component: Teams,
    meta: {
      auth: true,
      title: 'Football Team Management System'
    }
  },
  {
    path: '/players',
    name: 'players',
    component: Players,
    meta: {
      auth: true,
      title: 'Players'
    }
  },
  {
    path: '/',
    //redirect: '/defaultview',
    name: 'home',
    meta: {
      auth: false
    },
    component: DefaultView
  },
  {
    path: '*',
    redirect: '/404',
    name: 'unknown',
    meta: {
      auth: undefined
    }
    //component: NotFound
  }
]

const router = new VueRouter({
  history: true,
  mode: 'history',
  routes,
})

export default router