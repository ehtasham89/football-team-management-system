<template>
  <div class="container">
    <div class="text-center" v-if="loading">
      <b-spinner variant="primary" label="Text Centered"></b-spinner>
    </div>

    <b-card class="text-center">Manage Teams</b-card>

    <b-button id="show-btn" class="btn-add" @click="showModal">Add New Team</b-button>

    <b-table striped hover :fields="fields" :items="teams" responsive="sm">
      <!-- A custom formatted column -->
      <template v-slot:cell(name)="data">
        <b class="text-info">{{ data.item.name.toUpperCase() }}</b>
      </template>
      <!-- A virtual column -->
      <template v-slot:cell()="data">
        <!-- named route -->
        <router-link class="btn btn-outline-info" :to="{ name: 'players', params: { team_id: data.item.id, name: data.item.name }}">Player List</router-link>
      </template>
      <!-- A virtual composite column -->
      <template v-slot:cell(status)="data">  
        <button id="btn-active" v-if="data.item.status === 1" class="btn btn-outline-primary" @click="deactivate(data.item.id)">Active</button>
        <button id="btn-deactive" v-if="data.item.status === 0" class="btn btn-outline-secondary" @click="activate(data.item.id)">Deactive</button>
      </template>
    </b-table>

    <b-modal ref="my-modal" hide-footer title="Add New Team">
      <b-container class="d-block text-center">
        <b-form @submit="onSubmit">
            <b-row>
                <b-col cols="10">
                    <label class="sr-only" for="inline-form-input-name">Name</label>
                    <b-input
                        id="inline-form-input-name"
                        required
                        placeholder="Royel CC"
                        v-model="form.name"
                    ></b-input>
                </b-col>
                <b-col cols="2">
                    <b-button type="submit" variant="primary">Save</b-button>
                </b-col>
            </b-row>
        </b-form>
      </b-container>
    </b-modal>

  </div>
</template>

<script>
  import { mapGetters, m } from "vuex";
  
  export default {
    methods: {
        showModal() {
            this.$refs['my-modal'].show()
        },
        hideModal() {
            this.$refs['my-modal'].hide()
        },
        activate(id) {
          this.$store.dispatch("TEAM_STATUS_UPDATE", {id, status: 1});
        },
        deactivate(id) {
          this.$store.dispatch("TEAM_STATUS_UPDATE", {id, status: 0});
        },
        onSubmit(evt) {
          evt.preventDefault();
          this.hideModal();
          this.$store.dispatch("ADD_TEAM", this.form);
        }
    },
    mounted() {
      this.$store.dispatch("GET_TEAMS", e => this.loading = false);
    },
    computed: {
      ...mapGetters({teams: "teams"}),
    },
    data() {
      return {
        loading: true,
        form: {
          name: "",
          status: 1
        },
        fields: ['name', 'Assinged Player', 'status']
      }
    }
  }
</script>
<style scoped>
.btn-add{
    margin-top: 15px;
    margin-bottom: 5px;
    border-color: lightblue;
    background-color: deepskyblue;
}
</style>>