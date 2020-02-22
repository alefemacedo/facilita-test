<template>
  <div class="height--problem container">
    <div class="height--problem_title">
      <h1 class="display-4">
        Juca ultrapassa João
      </h1>
    </div>

    <div class="height--problem_form">
      <div class="form-group">
        <label for="joao_height">Altura de João (cm)</label>
        <input v-model="joao_height" class="form-control" type="text" id="joao_height">
      </div>

      <div class="form-group">
        <label for="juca_height">Altura de Juca (cm)</label>
        <input v-model="juca_height" class="form-control" type="text" id="juca_height">
      </div>

      <div class="form-group">
        <label for="years">Anos Necessários</label>
        <input :value="yearsComputed" disabled class="form-control" type="text" id="years">
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      joao_height: 150,
      juca_height: 110
    }
  },
  computed: {
    yearsComputed: {
      get() {
        let years = 0
        let joaoHeight = parseInt(this.joao_height) || 0
        let jucaHeight = parseInt(this.juca_height) || 0

        do {
          joaoHeight += 2
          jucaHeight += 3
          years += 1
        } while (joaoHeight > jucaHeight)
        return years
      }
    }
  }
}
</script>

<style>

</style>