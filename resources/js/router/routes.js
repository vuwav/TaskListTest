export default [
  ...applyRules(['guest'], [
    { path: '', component: require('$comp/auth/AuthWrapper').default, redirect: { name: 'login' }, children:
      [
        { path: '/login', name: 'login', component: require('$comp/auth/login/Login').default },
        { path: '/register', name: 'register', component: require('$comp/auth/register/Register').default },
      ]
    },
  ]),
  ...applyRules(['auth'], [
    { path: '', component: require('$comp/admin/AdminWrapper').default, children:
      [
        { path: '', name: 'index', redirect: { name: 'profile' } },
        { path: 'profile', component: require('$comp/admin/profile/ProfileWrapper').default, children:
                  [
                      { path: '', name: 'profile', component: require('$comp/admin/profile/Profile').default },
                      { path: 'edit', name: 'profile-edit', component: require('$comp/admin/profile/edit/ProfileEdit').default },
                  ]
        },
        { path: '', name: 'task.index', redirect: { name: 'task' } },
        { path: 'task', component: require('$comp/admin/task/TaskWrapper').default, children:
          [
            { path: '', name: 'task', component: require('$comp/admin/task/Task').default },
          ]
        }
      ]
    },
  ]),
  { path: '*', redirect: { name: 'index' } }
]

function applyRules(rules, routes) {
  for (let i in routes) {
    routes[i].meta = routes[i].meta || {}

    if (!routes[i].meta.rules) {
      routes[i].meta.rules = []
    }
    routes[i].meta.rules.unshift(...rules)

    if (routes[i].children) {
      routes[i].children = applyRules(rules, routes[i].children)
    }
  }

  return routes
}
