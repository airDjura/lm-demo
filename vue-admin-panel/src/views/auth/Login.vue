<template>
  <!-- Sign In Block -->
  <div class="block block-themed block-fx-shadow mb-0">
    <div class="block-header">
      <h3 class="block-title">Sign In</h3>
      <div class="block-options">
        <!--<a class="btn-block-option font-size-sm" href="op_auth_reminder.html">Forgot Password?</a>-->
        <!--<a class="btn-block-option" href="op_auth_signup.html" data-toggle="tooltip" data-placement="left" title="New Account">-->
          <!--<i class="fa fa-user-plus"></i>-->
        <!--</a>-->
      </div>
    </div>
    <div class="block-content">
      <div class="p-sm-3 px-lg-4 py-lg-5">
        <h1 class="mb-2">League Manager</h1>
        <p>Welcome, please login.</p>

        <!-- Sign In Form -->
        <!-- jQuery Validation (.js-validation-signin class is initialized in js/pages/op_auth_signin.min.js which was auto compiled from _es6/pages/op_auth_signin.js) -->
        <!-- For more info and examples you can check out https://github.com/jzaefferer/jquery-validation -->
        <form @submit.prevent="handleSubmit">
          <formly-form :form="form" :model="model" :fields="fields"></formly-form>
          <button type="submit" class="btn btn-block btn-primary">
            <i class="fa fa-fw fa-sign-in-alt mr-1"></i> Sign In
          </button>
        </form>
        <!-- END Sign In Form -->
      </div>
    </div>
  </div>
  <!-- END Sign In Block -->
</template>

<script>
import { mapGetters, mapActions } from 'vuex'
export default {
  name: 'login',
  data () {
    return {
      model: {
        email: 'admin@admin.com',
        password: 'adminadmin'
      },
      form: {},
      fields: [
        {
          key: 'email',
          type: 'input',
          templateOptions: {
            inputType: 'email'
          },
          required: true
        },
        {
          key: 'password',
          type: 'input',
          templateOptions: {
            inputType: 'password'
          },
          required: true
        }
      ]
    }
  },
  computed: {
    ...mapGetters('auth', [
      'authenticating',
      'authenticationError',
      'authenticationErrorCode'
    ])
  },
  methods: {
    ...mapActions('auth', [
      'login'
    ]),
    handleSubmit () {
      // Perform a simple validation that email and password have been typed in
      if (this.model.email !== '' && this.model.password !== '') {
        this.login({ email: this.model.email, password: this.model.password })
        this.model.password = ''
      }
    }
  }
}
</script>
