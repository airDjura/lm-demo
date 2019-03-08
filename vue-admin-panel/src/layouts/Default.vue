<template>
  <div id="page-container"
       class="sidebar-o enable-page-overlay sidebar-dark side-scroll page-header-fixed">
    <sidebar></sidebar>
    <!-- Sidebar -->
    <!--
        Sidebar Mini Mode - Display Helper classes

        Adding 'smini-hide' class to an element will make it invisible (opacity: 0) when the sidebar is in mini mode
        Adding 'smini-show' class to an element will make it visible (opacity: 1) when the sidebar is in mini mode
            If you would like to disable the transition animation, make sure to also add the 'no-transition' class to your element

        Adding 'smini-hidden' to an element will hide it when the sidebar is in mini mode
        Adding 'smini-visible' to an element will show it (display: inline-block) only when the sidebar is in mini mode
        Adding 'smini-visible-block' to an element will show it (display: block) only when the sidebar is in mini mode
    -->
    <navbar></navbar>
    <!-- END Sidebar -->

    <!-- Header -->
    <topbar></topbar>
    <!-- END Header -->

    <!-- Main Container -->
    <main id="main-container">
      <transition name="fade">
        <loader v-if="this.$store.state.loading"></loader>
      </transition>
      <router-view></router-view>
    </main>
    <!-- END Main Container -->
    <bottombar></bottombar>
    <!-- Apps Modal -->
    <!-- Opens from the modal toggle button in the header -->
    <div class="modal fade"
         id="one-modal-apps"
         tabindex="-1"
         role="dialog"
         aria-labelledby="one-modal-apps"
         aria-hidden="true">
      <div class="modal-dialog modal-dialog-top modal-sm" role="document">
        <div class="modal-content">
          <div class="block block-themed block-transparent mb-0">
            <div class="block-header bg-primary-dark">
              <h3 class="block-title">Apps</h3>
              <div class="block-options">
                <button type="button"
                        class="btn-block-option"
                        data-dismiss="modal"
                        aria-label="Close">
                  <i class="si si-close"></i>
                </button>
              </div>
            </div>
            <div class="block-content block-content-full">
              <div class="row gutters-tiny">
                <div class="col-6">
                  <!-- CRM -->
                  <a class="block block-rounded block-themed bg-default" href="javascript:void(0)">
                    <div class="block-content text-center">
                      <i class="si si-speedometer fa-2x text-white-75"></i>
                      <p class="font-w600 font-size-sm text-white mt-2 mb-3">
                        CRM
                      </p>
                    </div>
                  </a>
                  <!-- END CRM -->
                </div>
                <div class="col-6">
                  <!-- Products -->
                  <a class="block block-rounded block-themed bg-danger" href="javascript:void(0)">
                    <div class="block-content text-center">
                      <i class="si si-rocket fa-2x text-white-75"></i>
                      <p class="font-w600 font-size-sm text-white mt-2 mb-3">
                        Products
                      </p>
                    </div>
                  </a>
                  <!-- END Products -->
                </div>
                <div class="col-6">
                  <!-- Sales -->
                  <a class="block block-rounded block-themed bg-success mb-0"
                     href="javascript:void(0)">
                    <div class="block-content text-center">
                      <i class="si si-plane fa-2x text-white-75"></i>
                      <p class="font-w600 font-size-sm text-white mt-2 mb-3">
                        Sales
                      </p>
                    </div>
                  </a>
                  <!-- END Sales -->
                </div>
                <div class="col-6">
                  <!-- Payments -->
                  <a class="block block-rounded block-themed bg-warning mb-0"
                     href="javascript:void(0)">
                    <div class="block-content text-center">
                      <i class="si si-wallet fa-2x text-white-75"></i>
                      <p class="font-w600 font-size-sm text-white mt-2 mb-3">
                        Payments
                      </p>
                    </div>
                  </a>
                  <!-- END Payments -->
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- END Apps Modal -->
  </div>

</template>

<script>
import Topbar from '@/components/layout/Topbar'
import Navbar from '@/components/layout/Navbar'
import Sidebar from '@/components/layout/Sidebar'
import Bottombar from '@/components/layout/Bottombar'
import Loader from '@/components/layout/Loader'
import App from '../oneui/app'

export default {
  name: 'Default',
  components: {
    Topbar,
    Sidebar,
    Navbar,
    Bottombar,
    Loader
  },
  created () {
    jQuery(() => {
      // Create a new instance of App
      window.One = new App()
    })
  },
  methods: {
    makeRoute (route) {
      route.params = this.$route.params
      return route
    }
  }
}
</script>

<style lang="scss">
  .fade-leave-active {
    transition-property: opacity;
    transition-duration: .1s;
  }

  .fade-enter, .fade-leave-active {
    opacity: 0
  }

  #main-container {
    position: relative;
  }
</style>
