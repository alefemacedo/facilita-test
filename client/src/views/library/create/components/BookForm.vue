<template>
  <b-modal v-model="valueComputed" hide-footer id="book-modal" title="Cadastro de Livro">
    <form @submit.prevent="submit">
      <f-validated-input
        v-model="form.name"
        :messages="error"
        id="name"
        label="Nome"
        placeholder="Por favor informe o nome do livro"/>
      <f-validated-input
        v-model="form.code"
        :messages="error"
        id="code"
        label="Código"
        placeholder="Por favor informe o código do livro"/>
      <div slot="modal-footer" class="form-group d-flex justify-content-end">
        <button type="submit" class="btn btn-success mr-2">Salvar</button>
        <button type="button" class="btn btn-danger" @click.prevent="cancel">Cancelar</button>
      </div>
    </form>
  </b-modal>
</template>

<script>
import ValidatedInput from "@/components/ValidatedInput"
import { create } from "@/api/book"

export default {
  components: {
    "f-validated-input": ValidatedInput
  },
  props: {
    value: {
      type: Boolean,
      required: true,
      default: false
    }
  },
  data() {
    return {
      error: {},
      form: {
        name: "",
        code: ""
      }
    }
  },
  computed: {
    valueComputed: {
      get() {
        return this.value
      },
      set(value) {
        this.$emit("input", value)
      }
    }
  },
  methods: {
    /**
     * Limpa o formulário e as mensagens de erro
     */
    clear() {
      this.form = {
        name: "",
        code: ""
      }
      this.error = {}
    },
    /**
     * Submita os dados do formulário, criando uma
     * nova instância de Livro no banco de dados
     */
    submit() {
      create(this.form)
        .then((response) => {
          this.$toasted.success(response.data.return.message)
          this.clear()
          this.valueComputed = false
        })
        .catch((error) => {
          if (error.response.status === 422) {
            this.error = { ... error.response.data }
            this.$toasted.error("Por favor corrija os erros no formulário")
          } else {
            this.$toasted.error(error.response.data.return.message)
          }
        })
    },
    /**
     * Cancela o cadastro do Livro, limpando o
     * formulário e fechando o modal
     */
    cancel() {
      this.clear()
      this.valueComputed = false
    }
  }
}
</script>

<style>

</style>