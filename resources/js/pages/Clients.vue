<template>
  <div>
    <h2 class="text-xl font-bold mb-4">Clientes</h2>

    <form @submit.prevent="save" class="grid gap-3 mb-6">
      <input v-model="form.name" class="border p-2 rounded" placeholder="Nome" />
      <input v-model="form.document" class="border p-2 rounded" placeholder="CPF/CNPJ" />
      <input v-model="form.email" class="border p-2 rounded" placeholder="Email" />

      <select v-model="form.status" class="border p-2 rounded">
        <option value="active">Ativo</option>
        <option value="inactive">Inativo</option>
      </select>

      <button class="bg-blue-600 text-white p-2 rounded">
        Salvar
      </button>
    </form>

    <table class="w-full border">
      <thead>
        <tr class="bg-gray-200">
          <th class="p-2">Nome</th>
          <th>Email</th>
          <th>Status</th>
          <th>Ações</th>
        </tr>
      </thead>

      <tbody>
        <tr v-for="c in clients" :key="c.id" class="border-t">
          <td class="p-2">{{ c.name }}</td>
          <td>{{ c.email }}</td>
          <td>{{ c.status }}</td>

          <td class="flex gap-2 p-2">
            <button @click="edit(c)" class="bg-yellow-400 px-2 rounded">Editar</button>
            <button @click="remove(c.id)" class="bg-red-500 text-white px-2 rounded">Excluir</button>
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
      clients: [],
      form: {
        id: null,
        name: "",
        document: "",
        email: "",
        status: "active",
      },
    };
  },

  mounted() {
    this.load();
  },

  methods: {
    async load() {
      const { data } = await api.get("/v1/clients");
      
      this.clients = data.data;
    },

    async save() {
      if (this.form.id) {
        await api.put(`/v1/clients/${this.form.id}`, this.form);
      } else {
        await api.post("/v1/clients", this.form);
      }

      this.reset();
      this.load();
    },

    edit(item) {
      this.form = { ...item };
    },

    async remove(id) {
      await api.delete(`/v1/clients/${id}`);
      this.reset();
      this.load();
    },

    reset() {
      this.form = {
        id: null,
        name: "",
        document: "",
        email: "",
        status: "active",
      };
    },
  },
};
</script>