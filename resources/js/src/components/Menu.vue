<template>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <router-link :to="{name: 'dashboard'}" class="navbar-brand">Football Team Management System</router-link>
    <div class="header-title" v-if="$auth.check() && user && user.name"> | Admin: {{user.name}}</div>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ml-auto" v-if="!$auth.check()">
          <li class="nav-item" v-for="(route, key) in routes.unlogged" v-bind:key="route.path">
            <router-link :to="{ name : route.path }" :key="key" class="nav-link">{{route.name}}</router-link>
          </li>
      </ul>
      <ul class="navbar-nav ml-auto" v-if="$auth.check()">
        <li class="nav-item" v-for="(route, key) in routes.user" v-bind:key="route.path">
            <router-link :to="{ name : route.path }" :key="key" class="nav-link">{{route.name}}</router-link>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#" @click.prevent="$auth.logout()">Logout</a>
        </li>
      </ul>
    </div>
  </nav>
</template>
<script>
  import { mapGetters } from "vuex";

  export default {
    data() {
      return {
        routes: {
          // UNLOGGED
          unlogged: [
            { name: 'Register', path: 'register' },
            { name: 'Login', path: 'login'}
          ],
          // LOGGED ADMIN
          user: [
            { name: 'Teams', path: 'dashboard' },
            { name: 'Players', path: 'players' }
          ]
        }
      }
    },
    mounted() {
        //reload page prevent user state empty
        this.$auth.check() && this.$store.dispatch("GET_USER");
    },
    computed: {
      ...mapGetters(["user"]),
    }
  }
</script>
<style>
.navbar {
  margin-bottom: 30px;
}
.header-title {
  size: 12px;
  color: #fff;
  margin-top: 5px;
}
</style>