<template>
  <div class="container">
    <div class="text-center" v-if="loading">
      <b-spinner variant="primary" label="Text Centered"></b-spinner>
    </div>

    <b-card class="text-center" v-if="params.team_id">
        <b>Players List For Team: {{params.name}} (Total Player: {{players.filter(e => e.team_id === params.team_id).length}})</b>
    </b-card>
    
    <b-button id="show-file-btn" class="btn-add" @click="showFileUploadBox" v-if="params.team_id">Import Players</b-button>

    <b-table striped hover :fields="fields" v-if="params.team_id" :items="players.filter(e => e.team_id === params.team_id)" responsive="sm">
      <!-- A custom formatted column -->
      <template v-slot:cell(name)="data">
        <b class="text-info">{{ data.item.name.toUpperCase() }}</b>
      </template>
      <template v-slot:cell(type)="data">
        <b class="text-info">{{data.item.type.toUpperCase()}}</b>
      </template>
      <!-- A virtual composite column -->
      <template v-slot:cell(status)="data">  
        <button id="btn-active" v-if="data.item.status" class="btn btn-outline-primary" @click="deactivate(data.item.id)">Active</button>
        <button id="btn-deactive" v-if="!data.item.status" class="btn btn-outline-secondary" @click="activate(data.item.id)">Deactive</button>
      </template>
      <template v-slot:cell()="data">  
        <button id="btn-active" class="btn btn-outline-primary" @click="unAssign(data.item.id)">Un-Assign</button>
      </template>
    </b-table>

    <b-card class="text-center">
        <b v-if="params.team_id">Available Player For Assignment ({{players.filter(e => e.team_id === 0).length}})</b>
        <b v-if="!params.team_id">Manage Players</b>
    </b-card>

    <b-button id="show-btn" class="btn-add" @click="showModal">Add New Player</b-button>

    <!-- Un Assigned player list -->
    <b-table striped hover :fields="fields" style="margin-bottom: 50px" :items="players.filter(e => e.team_id === 0)" responsive="sm">
      <!-- A custom formatted column -->
      <template v-slot:cell(name)="data">
        <b class="text-info">{{ data.item.name.toUpperCase() }}</b>
      </template>
      <template v-slot:cell(type)="data">
        <b class="text-info">{{data.item.type.toUpperCase()}}</b>
      </template>
      <!-- A virtual composite column -->
      <template v-slot:cell(status)="data">  
        <button id="btn-active" v-if="data.item.status === 1" class="btn btn-outline-primary" @click="deactivate(data.item.id)">Active</button>
        <button id="btn-deactive" v-if="data.item.status === 0" class="btn btn-outline-secondary" @click="activate(data.item.id)">Deactive</button>
      </template>
      <template v-slot:cell()="data">  
        <button id="btn-active" class="btn btn-outline-primary" @click="assign(data.item.id)">Assign Player To Team</button>
      </template>
    </b-table>

    <b-modal ref="my-modal" hide-footer title="Add New Player">
      <b-container class="d-block text-center">
        <b-form @submit="onSubmit">
            <b-row>
                <b-col cols="10">
                    <label class="sr-only" for="inline-form-input-name">Name</label>
                    <b-input
                        id="inline-form-input-name"
                        required
                        placeholder="John"
                        v-model="form.name"
                    ></b-input>
                </b-col>
                
                <b-col cols="2">
                    <b-button type="submit" variant="primary">Save</b-button>
                </b-col>
                <b-col cols="12" style="text-align: left">
                    <b-form-checkbox
                        id="checkbox-1"
                        v-if="params.team_id"
                        v-model="form.type"
                        name="type"
                        value="substitute"
                        unchecked-value="player"
                    >
                        Is Substitute Player
                    </b-form-checkbox>
                </b-col>
            </b-row>
        </b-form>
      </b-container>
    </b-modal>

    <b-modal ref="select-player-type" hide-footer title="Select Player Typer" v-if="params.team_id">
      <b-container class="d-block text-center">
          <b-button variant="primary" @click="assignToTeam('player')">As a player</b-button>
          <b-button variant="primary" @click="assignToTeam('substitute')">As a substitute player</b-button>
      </b-container>
    </b-modal>

    <b-modal ref="fileUploadBox" hide-footer title="Select CSV File For This Team" v-if="params.team_id">
      <FileReader :team-id="params.team_id" :hide-file-upload-box="hideFileUploadBox"></FileReader>
    </b-modal>

  </div>
</template>

<script>
  import { mapGetters, m } from "vuex";
  import FileReader from "./../components/FileReader";
  
  export default {
    methods: {
        showModal() {
            this.$refs['my-modal'].show()
        },
        hideModal() {
            this.$refs['my-modal'].hide()
        },
        activate(id) {
          this.$store.dispatch("PLAYER_STATUS_UPDATE", {id, status: 1});
        },
        deactivate(id) {
          this.$store.dispatch("PLAYER_STATUS_UPDATE", {id, status: 0});
        },
        assign(id) {
            this.selectedId = id;
            this.$refs['select-player-type'].show();
        },
        unAssign(id) {
          this.$store.dispatch("PLAYER_TEAM_UPDATE", {id, team_id: 0, type: "player"});
        },
        onSubmit(evt) {
          evt.preventDefault();
          this.hideModal();
          this.$store.dispatch("ADD_PLAYER", this.form);
        },
        assignToTeam(type) {
            this.$refs['select-player-type'].hide();

            this.$store.dispatch("PLAYER_TEAM_UPDATE", {id: this.selectedId, team_id: this.params.team_id, type});
        },
        showFileUploadBox() {
            this.$refs['fileUploadBox'].show();
        },
        hideFileUploadBox() {
            this.$refs['fileUploadBox'].hide();
        }
    },
    mounted() {
      this.$store.dispatch("GET_PLAYERS", e => this.loading = false);
    },
    computed: {
      ...mapGetters({players: "players"}),
    },
    data() {
        const _teamId = this.$router.currentRoute.params.team_id;
        const action = _teamId ? ['action']:[];

        return {
            selectedId: undefined,
            loading: true,
            params: this.$router.currentRoute.params,
            form: {
                name: "",
                type: "player",
                team_id: _teamId || 0,
                status: 1
            },
            fields: ['name', 'type', 'status', ...action]
        }
    },
    components: {
        FileReader
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