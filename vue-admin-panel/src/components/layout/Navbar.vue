<template>
  <nav id="sidebar" aria-label="Main Navigation">
      <!-- Side Header -->
      <div class="content-header bg-white-5">
          <!-- Logo -->
          <a class="font-w600 text-dual" href="index.html">
              nexTome
          </a>
          <!-- END Logo -->

          <!-- Options -->
          <div>
              <!-- Close Sidebar, Visible only on mobile screens -->
              <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
              <a class="d-lg-none text-dual ml-3" data-toggle="layout" data-action="sidebar_close" href="javascript:void(0)">
                  <i class="fa fa-times"></i>
              </a>
              <!-- END Close Sidebar -->
          </div>
          <!-- END Options -->
      </div>
      <!-- END Side Header -->

      <!-- Side Navigation -->
      <div class="content-side content-side-full">
          <ul class="nav-main">
              <li class="nav-main-item">
                  <router-link class="nav-main-link" :to="{name:'dashboard'}">
                    <i class="nav-main-link-icon si si-cursor"></i>
                    <span class="nav-main-link-name">{{$t('navbar.dashboard')}}</span>
                  </router-link>
              </li>
              <li class="nav-main-heading">{{$t('navbar.main')}}</li>
              <li v-for="(link, n) in mainLinks" :key="link.route.name + n" class="nav-main-item">
                  <router-link class="nav-main-link" :to="link.route">
                      <i v-if="link.icon" :class="link.icon" class="nav-main-link-icon"></i>
                      <span class="nav-main-link-name">{{$tc(link.title, 2)}}</span>
                  </router-link>
              </li>
              <!--<li class="nav-main-item">-->
                  <!--<a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="true" href="#">-->
                      <!--<i class="nav-main-link-icon si si-bulb"></i>-->
                      <!--<span class="nav-main-link-name">Examples</span>-->
                  <!--</a>-->
                  <!--<ul class="nav-main-submenu">-->
                  <!--</ul>-->
              <!--</li>-->
              <li class="nav-main-heading">{{$t('navbar.current_season')}}</li>
            <li v-for="(link, n) in currentSeasonLinks" :key="link.route.name + n" class="nav-main-item">
              <router-link class="nav-main-link" :to="link.route">
                <i v-if="link.icon" :class="link.icon" class="nav-main-link-icon"></i>
                <span class="nav-main-link-name">{{$tc(link.title, 2)}}</span>
              </router-link>
            </li>
          </ul>
      </div>
      <!-- END Side Navigation -->
  </nav>
</template>

<script>
export default {
  data () {
    return {
      mainLinks: [
        {
          title: 'player.name',
          icon: 'fa fa-child',
          route: { name: 'players.index' }
        },
        {
          title: 'club.name',
          icon: 'fa fa-city',
          route: { name: 'clubs.index' }
        },
        {
          title: 'league.name',
          icon: 'fa fa-clipboard-list',
          route: { name: 'leagues.index' }
        },
        {
          title: 'season.name',
          icon: 'si si-trophy',
          route: { name: 'seasons.index' }
        },
        {
          title: 'venue.name',
          icon: 'fa fa-map-marker-alt',
          route: { name: 'venues.index' }
        }
      ],
      currentSeasonLinks: [
        {
          title: 'schedule.name',
          icon: 'fa fa-tasks',
          route: { name: 'schedules.index' }
        }
      ]
    }
  }
}
</script>
