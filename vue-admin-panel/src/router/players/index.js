import Index from '@/views/players/Index'
import Create from '@/views/players/Create'
import Edit from '@/views/players/Edit'

export default [
  {
    path: '/players',
    name: 'players.index',
    component: Index
  },
  {
    path: '/players/create',
    name: 'players.create',
    component: Create,
    meta: {
      title: 'Create player',
      breadcrumb: [
        {
          name: 'Players',
          route: {
            name: 'players.index'
          }
        },
        {
          name: 'Create'
        }
      ]
    }
  },
  {
    path: '/players/:uuid',
    name: 'players.edit',
    component: Edit,
    meta: {
      title: 'Edit player',
      breadcrumb: [
        {
          name: 'Players',
          route: {
            name: 'players.index'
          }
        },
        {
          name: 'Edit'
        }
      ]
    }
  }
]
