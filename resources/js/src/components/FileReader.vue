<template>
  <label class="text-reader">
    <b-form-file v-model="csvFile" class="mt-3" accept=".csv" plain @change="loadTextFromFile"></b-form-file>
    <div class="mt-3">Selected csv file: {{ csvFile ? csvFile.name : '' }}</div>
    <b-button variant="primary" @click="uploadFileData">Upload</b-button>
  </label>
</template>

<script>
export default {
  props: {
   teamId: Number,
   hideFileUploadBox: Function
  },
  data(){
    return {
      csvFile: null,
      fileData: null
    }
  },
  methods: {
    loadTextFromFile(ev) {
      const self = this;
      const file = ev.target.files[0];
      const reader = new FileReader();

      reader.onload = e => self.fileData = e.target.result;
      reader.readAsText(file);
    },
    uploadFileData(teamId) {
      this.$store.dispatch("IMPORT_TEAM_PLAYER", {data: this.fileData, teamId: this.teamId});
      this.hideFileUploadBox();
    }
  }
}
</script>