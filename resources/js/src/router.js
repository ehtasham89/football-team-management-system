import VueRouter from 'vue-router'
// Components
import Register from './auth/Register'
import Login from './auth/Login'
import NotFound from './components/NotFound'
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
    //component: Dashboard,
    meta: {
      auth: true
    }
  },
]

const router = new VueRouter({
  history: true,
  mode: 'history',
  routes,
})

export default router