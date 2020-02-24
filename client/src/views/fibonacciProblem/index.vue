<template>
  <div class="fibonacci--problem container">
    <div class="fibonacci--problem_title">
      <h3 class="display-4">
        Recupera Fibonacci
      </h3>
    </div>

    <div class="fibonacci--problem_form">
      <div class="form-group">
        <label for="input">Sequência de Caracteres</label>
        <input
          id="input"
          v-model="input"
          class="form-control"
          type="text"
          placeholder="Por favor informe uma sequência de números separados por vírgula">
      </div>

      <div class="form-group">
        <label for="fibonacci">Sequência de Fibonacci Gerada</label>
        <input :value="fibonacciComputed" disabled class="form-control" type="text" id="fibonacci">
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      input: "",
      fibonacci: [0,1]
    }
  },
  watch: {
    /**
     * Observa os caracteres informados para o input
     * e remove todos que não foram vírgula ou número
     */
    input(value) {
      const reg = /[^,0-9]/g
      this.input = value.replace(reg, '')
    }
  },
  computed: {
    fibonacciComputed: {
      get() {
        const array = this.input.split(',')
        let sequence = []

        // Verifica quais números pertencem a Sequência de
        // Fibonacci
        array.forEach(number => {
          number = parseInt(number)
          if (this.isFibonacci(number)
          && ((number === 1 && this.ocorrences(sequence, number) < 2) || !sequence.includes(number))) {
            sequence.push(number)
          }
        })

        // Ordena os números da Sequência de Fibonacci
        sequence.sort((a,b) => {
          return a-b
        })

        // Retorna a Sequência de Fibonacci como uma string
        return sequence.join(',')
      }
    }
  },
  methods: {
    /**
     * Recebe um valor numérico e verifica
     * se este pertence a Sequência de Fibonacci
     */
    isFibonacci(number) {
      let flag = false
      // Insere números na sequência de fibonacci até
      // que o último número seja maior ou igual ao número
      // a ser analizado
      while (this.fibonacci[this.fibonacci.length-1] < number) {
        this.fibonacci.push(this.fibonacci[this.fibonacci.length-1] + this.fibonacci[this.fibonacci.length-2])
      }

      // Verifica se o número pertence a Sequência de
      // Fibonacci
      if (this.fibonacci.includes(number)) {
        flag = true
      }

      return flag
    },
    /**
     * Recebe um array e um valor, e conta o número de
     * ocorrências do valor no array
     */
    ocorrences(array, value) {
      let count = 0
      array.forEach(element => {
        if (element === value) count++
      })

      return count
    }
  }
}
</script>

<style>

</style>