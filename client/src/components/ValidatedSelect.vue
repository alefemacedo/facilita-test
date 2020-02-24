<template>
  <div class="form-group mb-2">
    <label class="mr-2" :for="id">{{ label }}</label>
    <div class="input-group">
      <select
        v-model="input"
        :class="{ 'is-invalid':  hasError(id) }"
        class="form-control"
        :id="id">
        <option value="" selected>{{ placeholder }}</option>
        <option
          v-for="(item, index) in items"
          :key="index" :value="item.value">
          {{ item.text }}
        </option>
      </select>

      <div v-for="(message, index) in getErrorMessages(id)" :key="index" class="invalid-feedback">
        {{ message }}
      </div>

      <div v-if="button" class="input-group-append">
        <button @click.prevent="emitShowModal" class="btn btn-outline-success" type="button">
          <i class="far fa-plus-square"></i>
        </button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    value: {
      required: true
    },
    id: {
      type: String,
      required: true,
      default: ""
    },
    placeholder: {
      type: String,
      default: ""
    },
    label: {
      type: String,
      required: true,
      default: ""
    },
    items: {
      type: Array,
      required: true,
      default() {
        return [
          { value: 1, text: "Item 1" }
        ]
      }
    },
    button: {
      type: Boolean,
      required: false,
      default: false
    },
    buttonEvent: {
      type: String,
      required: false,
      default: "event"
    },
    messages: {
      type: Object,
      required: true,
      default() {
        return {}
      }
    }
  },
  data() {
    return {
    }
  },
  computed: {
    /**
     * Computed-property para que a propriedade value
     * interaja com o v-model utilizado no component
     */
    input: {
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
     * Verifica se há mensagens de erro para a propriedade
     * a qual o select está vinculado
     */
    hasError(property) {
      return Object.prototype.hasOwnProperty.call(this.messages, property)
    },
    /**
     * Retorna as mensagens de erro da propriedade em questão
     */
    getErrorMessages(property) {
      return this.messages[property]
    },
    /**
     * Emite um evento para mostrar o modal
     * com o formulário desejado
     */
    emitShowModal() {
      this.$emit(this.buttonEvent)
    }
  }
}
</script>

<style>

</style>