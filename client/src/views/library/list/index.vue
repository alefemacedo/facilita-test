<template>
  <div class="library--list">
    <div class="library--list_title">
      <h3 class="display-4">
        Listar Recibos
      </h3>
    </div>

    <div class="library--list_filter">
      <div class="form-group">
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <select v-model="filter.type" class="custom-select" @change.prevent="handleFilter">
              <option value="book">Livro</option>
              <option value="user">Usuário</option>
            </select>
          </div>

          <input
            v-model="filter.value"
            @input="handleFilter"
            type="text"
            class="form-control"/>
        </div>
			</div>
    </div>

    <div class="library--list_table">
      <f-paginated-table
        v-model="tableData"
        :fields="tableFields"
        :actions="tableActions"
        :pagination="pagination"
        @show="showReceipt"
        @delete="removeReceipt"/>
    </div>
  </div>
</template>

<script>
import PaginatedTable from "@/components/PaginatedTable"
import { fetchAllReceipts, remove } from "@/api/receipt"

export default {
  components: {
    "f-paginated-table": PaginatedTable
  },
  data() {
    return {
      pagination: {
        totalRows: 0,
        currentPage: 1,
        perPage: 25
      },
      filter: {
        type: "user",
        value: ""
      },
      delayFilter: null,
      tableData: [],
      tableFields: [
        { key: "book", label: "Nome do Livro" },
        { key: "user", label: "Usuário" },
        {
          key: "days",
          label: "Tempo de Empréstimo",
          formatter: (value, key, item) => {
            return item.days + ' dias'
          }
        },
        { key: "actions", label: "Ações" }
      ],
      tableActions: [
        { event: "show", icon: "far fa-eye", button_class: "btn btn-primary" },
        { event: "delete", icon: "far fa-trash-alt", button_class: 'btn btn-danger' }
      ]
    }
  },
  mounted() {
    this.getPaginatedReceipts()
  },
  methods: {
    /**
     * Busca todos os recibos paginados e com filtragem
     */
    async getPaginatedReceipts() {
      const params = {
        page: this.pagination.currentPage,
        filter: this.filter.value,
        filter_type: this.filter.type
      }

      await fetchAllReceipts(params)
        .then((response) => {
          this.pagination.totalRows = response.data.return.total
          this.pagination.perPage = response.data.return.per_page
          this.pagination.currentPage = response.data.return.current_page
          this.tableData = [...response.data.return.data]
        })
        .catch((error) => {
          this.$toasted.error(error.response.data.return.message)
        })
    },
    /**
     * Redireciona para a view que irá mostrar os dados
     * do Recibo gerado para o empréstimo
     */
    showReceipt(receipt) {
      this.$router.push({ path: "/library/show/" + receipt.id })
    },
    /**
     * Realiza uma requisição para a API de modo a remover
     * a instância de Recibo a qual o ID pertence
     */
    removeReceipt(receipt) {
      remove(receipt.id)
        .then((response) => {
          this.$toasted.success(response.data.return.message)
          // Refaz a listagem de recibos
          this.getPaginatedReceipts()
        })
        .catch((error) => {
          this.$toasted.error(error.response.data.return.message)
        })
    },
    /**
     * Identifica uma mudança de paginação
     */
    handleCurrentChange() {
      this.getPaginatedReceipts()
    },
    /**
     * Identifica uma filtragem dos dados
     */
    handleFilter() {
      this.pagination.currentPage = 1
      clearTimeout(this.delayFilter)
      this.delayFilter = setTimeout(() => {
        this.handleCurrentChange()
      }, 500)
    }
  }
}
</script>

<style>

</style>