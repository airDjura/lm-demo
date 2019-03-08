import Vue from 'vue'
import Router from 'vue-router'
import Home from '@/views/Home.vue'
import Dashboard from '@/views/Dashboard.vue'
import Login from '@/views/auth/Login.vue'
import { TokenService } from '@/services/storage.service'
import PlayerRoutes from './players'
import ClubRoutes from './clubs'
import LeagueRoutes from './leagues'
import SeasonRoutes from './seasons'
import VenueRoutes from './venues'
import ScheduleRoutes from './schedules'
import store from '@/store'
import Default from '../layouts/Default'
import Auth from '../layouts/Auth'

Vue.use(Router)

const router = new Router({
  mode: 'history',
  base: process.env.BASE_URL,
  routes: [
    {
      path: '/',
      name: 'home',
      component: Home
    },
    {
      path: '/auth',
      name: 'auth',
      component: Auth,
      children: [
        {
          path: 'login',
          name: 'login',
          component: Login,
          meta: {
            public: true, // Allow access to even if not logged in
            onlyWhenLoggedOut: true
          }
        }
      ]
    },
    {
      path: '/',
      name: 'admin',
      component: Default,
      children: [
        {
          path: '/dashboard',
          name: 'dashboard',
          component: Dashboard
        },
        ...PlayerRoutes,
        ...ClubRoutes,
        ...LeagueRoutes,
        ...SeasonRoutes,
        ...VenueRoutes,
        ...ScheduleRoutes
      ]
    }
  ]
})

router.beforeEach((to, from, next) => {
  jQuery('.modal').modal('hide')
  store.commit('loading')
  const isPublic = to.matched.some(record => record.meta.public)
  const onlyWhenLoggedOut = to.matched.some(record => record.meta.onlyWhenLoggedOut)
  const loggedIn = !!TokenService.getToken()
  if (!isPublic && !loggedIn) {
    return next({
      name: 'login',
      query: { redirect: to.fullPath }
      // Store the full path to redirect the user to after login
    })
  }

  // Do not allow user to visit login page or register page if they are logged in
  if (loggedIn && onlyWhenLoggedOut) {
    return next('/')
  }

  next()
})

router.afterEach((to, from) => {
  store.commit('loaded')
})

export default router
