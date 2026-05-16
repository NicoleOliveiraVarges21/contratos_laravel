<template>
  <div>
    <h1>Sistema de Contratos</h1>
    <nav>
      <button @click="page = 'clients'">Clientes</button>
      <button @click="page = 'services'">Serviços</button>
      <button @click="page = 'contracts'">Contratos</button>
    </nav>

    <hr />

    <Clients v-if="page === 'clients'" />
    <Services v-if="page === 'services'" />
    <Contracts v-if="page === 'contracts'" />
  </div>
</template>

<script>
import Clients from './pages/Clients.vue';
import Services from './pages/Services.vue';
import Contracts from './pages/Contracts.vue';

export default {
  components: {
    Clients,
    Services,
    Contracts,
  },

  data() {
    return {
      page: 'clients',
    };
  },
};
</script>