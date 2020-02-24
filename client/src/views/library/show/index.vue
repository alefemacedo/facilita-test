<template>
  <div class="container library--show">
    <div class="library--show_title">
      <h3 class="display-4">Recibo de Empréstimo</h3>
    </div>

    <div class="library--show_details">
      <div class="card">
        <div class="card-header">
          Dados do Recibo
        </div>
        <div class="card-body">
          <h5 class="card-title">Livro: {{ receipt.book.name }} </h5>
          <p class="card-text">Nome do Locatário: {{ receipt.user.name }} </p>
          <p class="card-text">Tipo de Locatário: {{ receipt.user.type }} </p>
          <p class="card-text">Tempo para devolução: {{ receipt.days }} dias </p>
          <button type="button" class="btn btn-primary" @click="$router.push({ path: '/library' })">Listar Recibos</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { fetch } from '@/api/receipt'

export default {
  props: {
    receiptId: {
      type: String,
      required: true,
      default: '0'
    }
  },
  data() {
    return {
      receipt: {
        user: {
          type: 'T'
        },
        book: {
          name: 'Livro',
          days: 0
        }
      }
    }
  },
  mounted() {
    this.getReceipt()
  },
  methods: {
    getReceipt() {
      fetch({ receipt_id: this.receiptId })
        .then((response) => {
          this.receipt = { ...response.data.return }
        })
        .catch((error) => {
          if (error.response.status === 404) {
            this.$toasted.error(error.response.data.return.message)
            this.$router.push({ path: "/library" })
          } else {
            this.$toasted.error(error.response.data.return.message)
          }
        })
    }
  }
}
</script>

<style>

</style>