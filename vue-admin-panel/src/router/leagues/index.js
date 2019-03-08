import Index from '@/views/leagues/Index'
import Create from '@/views/leagues/Create'
import Edit from '@/views/leagues/Edit'

export default [
  {
    path: '/leagues',
    name: 'leagues.index',
    component: Index
  },
  {
    path: '/leagues/create',
    name: 'leagues.create',
    component: Create,
    meta: {
      title: 'Create league',
      breadcrumb: [
        {
          name: 'Leagues',
          route: {
            name: 'leagues.index'
          }
        },
        {
          name: 'Create'
        }
      ]
    }
  },
  {
    path: '/leagues/:uuid',
    name: 'leagues.edit',
    component: Edit,
    meta: {
      title: 'Edit league',
      breadcrumb: [
        {
          name: 'Leagues',
          route: {
            name: 'leagues.index'
          }
        },
        {
          name: 'Edit'
        }
      ]
    }
  }
]
