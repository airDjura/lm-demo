import Index from '@/views/clubs/Index'
import Create from '@/views/clubs/Create'
import Edit from '@/views/clubs/Edit'

export default [
  {
    path: '/clubs',
    name: 'clubs.index',
    component: Index
  },
  {
    path: '/clubs/create',
    name: 'clubs.create',
    component: Create,
    meta: {
      title: 'Create club',
      breadcrumb: [
        {
          name: 'Clubs',
          route: {
            name: 'clubs.index'
          }
        },
        {
          name: 'Create'
        }
      ]
    }
  },
  {
    path: '/clubs/:uuid',
    name: 'clubs.edit',
    component: Edit,
    meta: {
      title: 'Edit club',
      breadcrumb: [
        {
          name: 'Clubs',
          route: {
            name: 'clubs.index'
          }
        },
        {
          name: 'Edit'
        }
      ]
    }
  }
]
