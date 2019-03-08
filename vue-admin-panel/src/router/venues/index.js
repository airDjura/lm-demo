import Index from '@/views/venues/Index'
import Create from '@/views/venues/Create'
import Edit from '@/views/venues/Edit'

export default [
  {
    path: '/venues',
    name: 'venues.index',
    component: Index
  },
  {
    path: '/venues/create',
    name: 'venues.create',
    component: Create,
    meta: {
      title: 'Create venue',
      breadcrumb: [
        {
          name: 'Venues',
          route: {
            name: 'venues.index'
          }
        },
        {
          name: 'Create'
        }
      ]
    }
  },
  {
    path: '/venues/:uuid',
    name: 'venues.edit',
    component: Edit,
    meta: {
      title: 'Edit venue',
      breadcrumb: [
        {
          name: 'Venues',
          route: {
            name: 'venues.index'
          }
        },
        {
          name: 'Edit'
        }
      ]
    }
  }
]
