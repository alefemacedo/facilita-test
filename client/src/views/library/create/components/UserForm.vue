<template>
  <b-modal v-model="valueComputed" hide-footer id="user-modal" title="Cadastro de Usuário">
    <form @submit.prevent="submit">
      <f-validated-input
        v-model="form.name"
        :messages="error"
        id="name"
        label="Nome"
        placeholder="Por favor informe o nome da pessoa"/>

      <f-validated-select
        v-model="form.type"
        :items="typeSelectItems"
        :messages="error"
        id="type"
        label="Tipo"
        placeholder="Por favor selecione o tipo de usuário"/>

      <div slot="modal-footer" class="form-group d-flex justify-content-end">
        <button type="submit" class="btn btn-success mr-2">Salvar</button>
        <button type="button" class="btn btn-danger" @click.prevent="cancel">Cancelar</button>
      </div>
    </form>
  </b-modal>
</template>

<script>
import ValidatedInput from "@/components/ValidatedInput"
import ValidatedSelect from "@/components/ValidatedSelect"
import { create } from "@/api/user"

export default {
  components: {
    "f-validated-input": ValidatedInput,
    "f-validated-select": ValidatedSelect
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
        type: ""
      },
      typeSelectItems: [
        { value: "T", text: "Professor" },
        { value: "S", text: "Aluno" }
      ]
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
        type: ""
      }
      this.error = {}
    },
    /**
     * Submita os dados do formulário, criando uma
     * nova instância de Pessoa no banco de dados
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
     * Cancela o cadastro de Usuário, limpando o
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