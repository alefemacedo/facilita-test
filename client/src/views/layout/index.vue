<template>
  <div class="app--wrapper h-100 d-flex flex-column">
    <div class="app--header">
      <b-navbar toggleable="lg" type="light" variant="light">
        <b-navbar-brand href="/">
          <img src="~@/assets/facilita_logo.png" height="50">
        </b-navbar-brand>

        <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

        <b-collapse id="nav-collapse" is-nav>
          <b-navbar-nav>
            <b-nav-item to="/">Home</b-nav-item>
            <b-nav-item to="/height-problem">Problema da Altura</b-nav-item>
            <b-nav-item-dropdown right>
              <template v-slot:button-content>
                Empresas
              </template>
              <b-dropdown-item to="/company">Listar</b-dropdown-item>
              <b-dropdown-item to="/company/create">Cadastrar</b-dropdown-item>
            </b-nav-item-dropdown>
          </b-navbar-nav>
        </b-collapse>
      </b-navbar>
    </div>
    <div class="app--body p-2 flex-grow-1 flex-column">
      <router-view/>
    </div>
    <div class="app--footer p-2 font-weight-light text-center bg-gradient-light">
      © App Facilita Vendas. Todos os direitos reservados.
    </div>
  </div>
</template>

<script>
export default {
  name: "Layout",
  methods: {}
}
</script>

<style lang="scss" scoped>
  .app--wrapper {
    .app--header {

    }

    .app--body {

    }

    .app--footer {
      // background-color: black;
    }
  }
</style>