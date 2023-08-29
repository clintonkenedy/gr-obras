
const routes = [
  {
    path: '/',
    component: () => import('layouts/AdminLayout.vue'),
    meta: { requiresAuth: true },
    children: [
      { path: '', name: 'Dash', component: () => import('pages/Admin/HomeAdmin.vue') },


      {
        path: "permisos",
        name: "Permisos",
        component: () => import("src/pages/Admin/persmisos/PermisosList.vue"),
      },
      {
        path: "roles",
        name: "Roles",
        component: () => import("src/pages/Admin/roles/RolesList.vue"),
      },
      {
        path: "usuarios",
        name: "Usuarios",
        component: () => import("src/pages/Admin/usuarios/UsuariosList.vue"),
      },

      { path: '/profesiones', name: 'Profesiones', component: () => import('pages/profesiones/ProfesionesLista.vue') },
      { path: '/cargos', name: 'Cargos', component: () => import('pages/Cargos/CargosLista.vue') }
    ]
  },
  {
    path: '/',
    component: () => import('layouts/AuthLayout.vue'),
    children: [
      {
        path: 'login',
        name: 'Login',
        component: () => import('pages/Auth/LoginPage.vue'),

      },
    ]
  },
  // {
  //   path:'/',
  //   component: () => import('layouts/AdminLayout.vue'),
  //   children: [
  //     {path: '',component:()=>import('pages/Admin/HomeAdmin.vue')},
  //     {path: 'permisos', name:'Permisos',component:()=>import('pages/Admin/permisos/PermisosIndex.vue')}
  //   ]

  // },

  // Always leave this as last one,
  // but you can also remove it
  {
    path: '/:catchAll(.*)*',
    component: () => import('pages/ErrorNotFound.vue')
  }
]

export default routes
