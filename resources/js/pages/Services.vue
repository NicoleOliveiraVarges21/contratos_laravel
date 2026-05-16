<template>
  <div>
    <h2 class="text-xl font-bold mb-4">Serviços</h2>

    <form @submit.prevent="save" class="grid gap-3 mb-6">
      <input v-model="form.name" class="border p-2 rounded" placeholder="Nome do serviço" />
      <input v-model="form.base_price" type="number" class="border p-2 rounded" placeholder="Preço base" />

      <button class="bg-blue-600 text-white p-2 rounded">
        Salvar
      </button>
    </form>

    <table class="w-full border">
      <thead>
        <tr class="bg-gray-200">
          <th class="p-2">Nome</th>
          <th>Preço base</th>
          <th>Ações</th>
        </tr>
      </thead>

      <tbody>
        <tr v-for="s in services" :key="s.id" class="border-t">
          <td class="p-2">{{ s.name }}</td>
          <td>R$ {{ s.base_price }}</td>

          <td class="flex gap-2 p-2">
            <button @click="edit(s)" class="bg-yellow-400 px-2 rounded">Editar</button>
            <button @click="remove(s.id)" class="bg-red-500 text-white px-2 rounded">Excluir</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import api from "../services/api";

export default {
  data() {
    return {
      services: [],
      form: {
        id: null,
        name: "",
        base_price: 0,
      },
    };
  },

  mounted() {
    this.load();
  },

  methods: {
    async load() {
      const { data } = await api.get("/v1/services");
      this.services = data;
    },

    async save() {
      if (this.form.id) {
        await api.put(`/v1/services/${this.form.id}`, this.form);
      } else {
        await api.post("/v1/services", this.form);
      }

      this.reset();
      this.load();
    },

    edit(item) {
      this.form = { ...item };
    },

    async remove(id) {
      await api.delete(`/v1/services/${id}`);
      this.load();
    },

    reset() {
      this.form = {
        id: null,
        name: "",
        base_price: 0,
      };
    },
  },
};
</script>