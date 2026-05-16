<template>
  <div>
    <h2 class="text-xl font-bold mb-4">Contratos</h2>

    <!-- FORM -->
    <div class="grid gap-3 mb-4">
      <select v-model="form.client_id" class="border p-2 rounded">
        <option value="">Selecione cliente</option>
        <option v-for="c in clients" :key="c.id" :value="c.id">
          {{ c.name }}
        </option>
      </select>

      <input v-model="form.start_date" type="date" class="border p-2 rounded" />
      <input v-model="form.end_date" type="date" class="border p-2 rounded" />
    </div>

    <!-- ADD SERVICES -->
    <h3 class="font-bold mb-2">Serviços</h3>

    <div v-for="s in services" :key="s.id" class="flex gap-2 items-center mb-2">
      <span class="w-40">{{ s.name }} (R$ {{ s.base_price }})</span>

      <input
        type="number"
        v-model.number="s.quantity"
        class="border p-1 w-20"
        placeholder="Qtd"
      />

      <button @click="addItem(s)" class="bg-green-600 text-white px-2 rounded">
        Adicionar
      </button>
    </div>

    <!-- ITEMS -->
    <h3 class="font-bold mt-4">Itens do contrato</h3>

    <div v-for="(i, index) in items" :key="index" class="flex justify-between border p-2 mt-2">
      <span>
        {{ i.name }} - {{ i.quantity }} x R$ {{ i.unit_price }}
      </span>

      <button @click="removeItem(index)" class="text-red-500">
        Remover
      </button>
    </div>

    <!-- TOTAL -->
    <div class="mt-4 text-xl font-bold">
      Total: R$ {{ total }}
    </div>

    <button
      @click="save"
      class="mt-4 bg-blue-600 text-white p-2 rounded"
    >
      Salvar contrato
    </button>

    <!-- LIST -->
    <hr class="my-6" />

    <div v-for="c in contracts" :key="c.id" class="border p-3 mb-3 rounded">
      <p><strong>Cliente:</strong> {{ c.client?.name }}</p>
      <p><strong>Status:</strong> {{ c.status }}</p>
      <p class="font-bold text-green-600">Total: R$ {{ c.total }}</p>

      <button @click="remove(c.id)" class="bg-red-500 text-white px-2 rounded mt-2">
        Excluir
      </button>
    </div>
  </div>
</template>

<script>
import api from "../services/api";

export default {
  data() {
    return {
      clients: [],
      services: [],
      contracts: [],
      items: [],
      form: {
        client_id: "",
        start_date: "",
        end_date: "",
      },
    };
  },

  computed: {
    total() {
      return this.items.reduce((sum, i) => {
        return sum + (i.quantity * i.unit_price);
      }, 0);
    },
  },

  mounted() {
    this.load();
  },

  methods: {
    async load() {
      const [clients, services, contracts] = await Promise.all([
        api.get("/v1/clients"),
        api.get("/v1/services"),
        api.get("/v1/contracts"),
      ]);

      this.clients = clients.data;
      this.services = services.data;
      this.contracts = contracts.data;
    },

    addItem(service) {
      this.items.push({
        service_id: service.id,
        name: service.name,
        quantity: service.quantity || 1,
        unit_price: service.base_price,
      });
    },

    removeItem(index) {
      this.items.splice(index, 1);
    },

    async save() {
      await api.post("/v1/contracts", {
        ...this.form,
        items: this.items,
      });

      this.reset();
      this.load();
    },

    async remove(id) {
      await api.delete(`/v1/contracts/${id}`);
      this.load();
    },

    reset() {
      this.form = {
        client_id: "",
        start_date: "",
        end_date: "",
      };
      this.items = [];
    },
  },
};
</script>