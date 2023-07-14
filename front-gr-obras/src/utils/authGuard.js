import { Cookies } from 'quasar'

const authGuard = (to) => {
  if (to.matched.some((record) => record.meta.requiresAuth)) {
    if (Cookies.get('token') === null && to.path !== '/login') {
      return {path: '/login', query: {redirectTo: to.fullPath}};
    }
  }
}

export default authGuard;
