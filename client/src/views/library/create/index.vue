<template>
  <div class="library--create">
    <div class="library--create_title">
      <h3 class="display-4">
        Cadastrar Empréstimo
      </h3>
    </div>
    <div class="library--create_form">
      <form @submit.prevent="submit">
        <div class="library--create_form_user">
          <f-validated-select
            v-model="form.user_id"
            :items="userSelectItems"
            :messages="error"
            button
            buttonEvent="show-user-form"
            id="user_id"
            label="Usuário"
            placeholder="Por favor selecione o usuário do empréstimo"
            @show-user-form="showUserForm = true"/>
          
          <f-user-form v-model="showUserFormComputed" :messages="error"/>
        </div>
        <div class="library--create_form_user">
          <f-validated-select
            v-model="form.book_id"
            :items="bookSelectItems"
            :messages="error"
            button
            buttonEvent="show-book-form"
            id="book_id"
            label="Livro"
            placeholder="Por favor selecione o livro do empréstimo"
            @show-book-form="showBookForm = true"/>

          <f-book-form v-model="showBookFormComputed" :messages="error"/>
        </div>
        <div slot="modal-footer" class="form-group d-flex justify-content-end">
          <button type="submit" class="btn btn-success mr-2">Salvar</button>
          <button type="button" class="btn btn-danger" @click.prevent="cancel">Cancelar</button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import ValidatedSelect from '@/components/ValidatedSelect'
import BookForm from "./components/BookForm"
import UserForm from "./components/UserForm"
import { fetchAllUsers } from "@/api/user"
import { fetchAllBooks } from "@/api/book"
import { create } from "@/api/receipt"

export default {
  components: {
    "f-validated-select": ValidatedSelect,
    "f-user-form": UserForm,
    "f-book-form": BookForm
  },
  data() {
    return {
      bookSelectItems: [],
      error: {},
      form: {
        user_id: "",
        book_id: "",
        days: 0
      },
      showUserForm: false,
      showBookForm: false,
      userSelectItems: []
    }
  },
  mounted() {
    this.mountForm()
  },
  computed: {
    showUserFormComputed: {
      get() {
        return this.showUserForm
      },
      set(value) {
        this.showUserForm = value
        this.getUsers()
      }
    },
    showBookFormComputed: {
      get() {
        return this.showBookForm
      },
      set(value) {
        this.showBookForm = value
        this.getBooks()
      }
    }
  },
  methods: {
    /**
     * Busca todos os usuários cadastrados formatados
     * em um array
     */
    async getUsers() {
      await fetchAllUsers()
        .then((response) => {
          this.userSelectItems = [...response.data.return]
        })
        .catch((error) => {
          this.$toasted.error(error.response.data.return.message)
        })
    },
    /**
     * Busca todos os livros cadastrados formatados
     * em um array
     */
    async getBooks() {
      await fetchAllBooks()
        .then((response) => {
          this.bookSelectItems = [...response.data.return]
        })
        .catch((error) => {
          this.$toasted.error(error.response.data.return.message)
        })
    },
    /**
     * Monta o formulário de cadastro, buscando os
     * usuários e livros cadastrados no banco
     */
    mountForm() {
      this.getUsers()
      this.getBooks()
    },
    /**
     * Submita os dados do formulário de modo
     * a cadastrar um novo recibo
     */
    submit() {
      create(this.form)
        .then((response) => {
          this.$toasted.success(response.data.return.message)
          // Redireciona para a view que irá mostrar os
          // dados do recibo
          this.$router.push({ path: '/library/show/' + response.data.return.receipt_id })
        })
        .catch((error) => {
          if (error.response.status === 422) {
            this.error = { ... error.response.data }
            this.$toasted.error("Por favor corrija os erros no formulário")
          } else {
            this.$toasted.error(error.response.data.return.message)
          }
        })
    }
  },

}
</script>

<style>

</style>