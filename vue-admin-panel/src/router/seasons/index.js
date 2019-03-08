import Index from '@/views/seasons/Index'
import Create from '@/views/seasons/Create'
import Edit from '@/views/seasons/Edit'

export default [
  {
    path: '/seasons',
    name: 'seasons.index',
    component: Index
  },
  {
    path: '/seasons/create',
    name: 'seasons.create',
    component: Create,
    meta: {
      title: 'Create season',
      breadcrumb: [
        {
          name: 'Seasons',
          route: {
            name: 'seasons.index'
          }
        },
        {
          name: 'Create'
        }
      ]
    }
  },
  {
    path: '/seasons/:uuid',
    name: 'seasons.edit',
    component: Edit,
    meta: {
      title: 'Edit season',
      breadcrumb: [
        {
          name: 'Seasons',
          route: {
            name: 'seasons.index'
          }
        },
        {
          name: 'Edit'
        }
      ]
    }
  }
]
