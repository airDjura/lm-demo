import Index from '@/views/schedules/Index'
import Show from '@/views/schedules/Show'
import CreateTeam from '../../views/schedules/teams/Create'
import EditTeam from '../../views/schedules/teams/Edit'
import EditGame from '../../views/schedules/games/Edit'

export default [
  {
    path: '/schedules',
    name: 'schedules.index',
    component: Index
  },
  {
    path: '/schedules/:uuid',
    name: 'schedules.show',
    component: Show,
    meta: {
      title: 'Schedule'
    }
  },
  {
    path: '/schedules/:uuid/team/create',
    name: 'schedules.teams.create',
    component: CreateTeam,
    meta: {
      title: 'Add team'
    }
  },
  {
    path: '/schedules/:uuid/team/:team',
    name: 'schedules.teams.show',
    component: EditTeam,
    meta: {
      title: 'Edit team'
    }
  },
  {
    path: '/schedules/:uuid/game/:game',
    name: 'schedules.games.show',
    component: EditGame,
    meta: {
      title: 'Edit game'
    }
  }
]
