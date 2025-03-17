<template>
  <div class="container">
    <h1>Cadastro de Clientes</h1>

    <!-- Formulário de Adição/Edição -->
    <div class="form-container">
      <h2>{{ isEditing ? 'Editar Cliente' : 'Cadastrar Novo Cliente' }}</h2>

      <form @submit.prevent="isEditing ? editarCliente() : adicionarCliente()">
        <div class="form-group">
          <label for="empresa">Razão Social</label>
          <select v-model="clienteForm.empresa" id="empresa" @change="atualizarRazaoSocial" required>
            <option v-for="empresa in empresas" :key="empresa.codigo" :value="empresa.codigo">
              {{ empresa.razao_social }}
            </option>
          </select>
        </div>

        <div class="form-group">
          <label for="tipo">Tipo</label>
          <select v-model="clienteForm.tipo" id="tipo" required>
            <option value="PJ">Pessoa Jurídica</option>
            <option value="PF">Pessoa Física</option>
          </select>
        </div>

        <div class="form-group">
          <label for="cpf_cnpj">CPF/CNPJ</label>
          <input
              type="text"
              v-model="clienteForm.cpf_cnpj"
              id="cpf_cnpj"
              required
              @input="formatarDocumento"
          />

        </div>

        <button type="submit" class="btn-submit">
          {{ isEditing ? 'Salvar Alterações' : 'Adicionar Cliente' }}
        </button>
      </form>
    </div>

    <!-- Lista de Clientes -->
    <div v-if="clientes.length > 0">
      <h3>Clientes Cadastrados</h3>
      <ul class="clientes-list">
        <li v-for="cliente in clientes" :key="cliente.codigo" class="cliente-item">
          <div class="cliente-info">
            <strong>{{ cliente.razao_social }}</strong> / Tipo:
            <span>{{ cliente.tipo }}</span> / Doc:
            <span>{{ formatarCpfCnpj(cliente.cpf_cnpj, cliente.tipo) }}</span>
          </div>
          <div class="actions">
            <button @click="editarClienteForm(cliente)" class="btn-edit">Editar</button>
            <button @click="excluirCliente(cliente)" class="btn-delete">Excluir</button>
          </div>
        </li>
      </ul>
    </div>

    <p v-else>Não há clientes cadastrados.</p>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      clientes: [],
      empresas: [],
      clienteForm: {
        razao_social: '',
        tipo: 'PJ',
        cpf_cnpj: '',
        empresa: ''
      },
      isEditing: false,
      clienteToEdit: null
    };
  },
  methods: {
    async carregarClientes() {
      try {
        const response = await axios.get(`${import.meta.env.VITE_API_URL}/clientes`);
        this.clientes = response.data;
      } catch (error) {
        console.error("Erro ao carregar clientes:", error);
      }
    },
    async carregarEmpresas() {
      try {
        const response = await axios.get(`${import.meta.env.VITE_API_URL}/empresas`);
        this.empresas = response.data;
      } catch (error) {
        console.error("Erro ao carregar empresas:", error);
      }
    },
    async adicionarCliente() {
      try {
        const clienteData = {
          codigo: Math.floor(Date.now() / 1000),
          empresa: this.clienteForm.empresa,
          tipo: this.clienteForm.tipo,
          cpf_cnpj: this.clienteForm.cpf_cnpj,
          razao_social: this.clienteForm.razao_social
        };
        await axios.post(`${import.meta.env.VITE_API_URL}/clientes`, clienteData);
        this.carregarClientes();
        this.resetarFormulario();
      } catch (error) {
        console.error("Erro ao adicionar cliente:", error);
      }
    },
    async editarCliente() {
      try {
        const clienteData = {
          empresa: this.clienteForm.empresa,
          tipo: this.clienteForm.tipo,
          cpf_cnpj: this.clienteForm.cpf_cnpj,
          razao_social: this.clienteForm.razao_social
        };
        await axios.put(`${import.meta.env.VITE_API_URL}/clientes/${this.clienteToEdit.empresa}/${this.clienteToEdit.codigo}`, clienteData);
        this.carregarClientes();
        this.resetarFormulario();
        this.isEditing = false;
      } catch (error) {
        console.error("Erro ao editar cliente:", error);
      }
    },
    editarClienteForm(cliente) {
      this.isEditing = true;
      this.clienteToEdit = cliente;
      this.clienteForm = {
        razao_social: cliente.razao_social,
        tipo: cliente.tipo,
        cpf_cnpj: cliente.cpf_cnpj,
        empresa: cliente.empresa
      };
    },
    async excluirCliente(cliente) {
      if (confirm("Tem certeza que deseja excluir?")) {
        try {
          await axios.delete(`${import.meta.env.VITE_API_URL}/clientes/${cliente.empresa}/${cliente.codigo}`);
          this.carregarClientes();
        } catch (error) {
          console.error("Erro ao excluir cliente:", error);
        }
      }
    },
    atualizarRazaoSocial() {
      const empresaSelecionada = this.empresas.find(empresa => empresa.codigo === this.clienteForm.empresa);
      this.clienteForm.razao_social = empresaSelecionada ? empresaSelecionada.razao_social : '';
    },
    resetarFormulario() {
      this.clienteForm = { razao_social: '', tipo: 'PJ', cpf_cnpj: '', empresa: '' };
      this.clienteToEdit = null;
    },
    formatarDocumento(event) {
      let input = event.target;
      let doc = input.value.replace(/\D/g, ''); // Remove tudo que não for número

      if (this.clienteForm.tipo === 'PF') {
        doc = doc.slice(0, 11); // Limita a 11 caracteres (CPF)
        if (doc.length > 9) {
          input.value = doc.replace(/(\d{3})(\d{3})(\d{3})(\d{0,2})/, '$1.$2.$3-$4');
        } else if (doc.length > 6) {
          input.value = doc.replace(/(\d{3})(\d{3})(\d{0,3})/, '$1.$2.$3');
        } else if (doc.length > 3) {
          input.value = doc.replace(/(\d{3})(\d{0,3})/, '$1.$2');
        } else {
          input.value = doc;
        }
      } else {
        doc = doc.slice(0, 14); // Limita a 14 caracteres (CNPJ)
        if (doc.length > 12) {
          input.value = doc.replace(/(\d{2})(\d{3})(\d{3})(\d{4})(\d{0,2})/, '$1.$2.$3/$4-$5');
        } else if (doc.length > 8) {
          input.value = doc.replace(/(\d{2})(\d{3})(\d{3})(\d{0,4})/, '$1.$2.$3/$4');
        } else if (doc.length > 5) {
          input.value = doc.replace(/(\d{2})(\d{3})(\d{0,3})/, '$1.$2.$3');
        } else if (doc.length > 2) {
          input.value = doc.replace(/(\d{2})(\d{0,3})/, '$1.$2');
        } else {
          input.value = doc;
        }
      }

      // Atualiza o v-model manualmente
      this.clienteForm.cpf_cnpj = input.value;

    },

    formatarCpfCnpj(cpf_cnpj, tipo) {
      let doc = cpf_cnpj.replace(/\D/g, ''); // Remove tudo que não for número

      if (tipo === 'PF' && doc.length === 11) {
        return doc.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3-$4');
      } else if (tipo === 'PJ' && doc.length === 14) {
        return doc.replace(/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/, '$1.$2.$3/$4-$5');
      }
      return cpf_cnpj; // Caso o número esteja errado ou incompleto
    }
  },
  mounted() {
    this.carregarClientes();
    this.carregarEmpresas();
  }
};
</script>

<style scoped>
.container {
  width: 100%;
  max-width: 1200px;
  margin: 20px auto;
  padding: 40px;
  font-family: Arial, sans-serif;
  background-color: #2c3e50;
  color: white;
  border-radius: 10px;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
  display: flex;
  flex-direction: column;
  justify-content: flex-start;
}

h1 {
  text-align: center;
  font-size: 32px;
  color: #ecf0f1;
}

.form-container {
  width: 100%;
  max-width: 800px;
  margin: 0 auto 40px;
  padding: 30px;
  border-radius: 8px;
  background-color: #34495e;
  display: flex;
  flex-direction: column;
}

.form-group {
  margin-bottom: 20px;
}

.form-group label {
  display: block;
  font-size: 18px;
  font-weight: bold;
  margin-bottom: 5px;
}

.form-group input,
.form-group select {
  width: 100%;
  padding: 12px;
  font-size: 16px;
  border-radius: 6px;
  border: 1px solid #bdc3c7;
  background-color: #ecf0f1;
  box-sizing: border-box;
}

.btn-submit {
  padding: 12px 25px;
  font-size: 18px;
  background-color: #27ae60;
  color: white;
  border: none;
  border-radius: 6px;
  cursor: pointer;
  transition: background 0.3s;
  width: 100%;
}

.btn-submit:hover {
  background-color: #2ecc71;
}

.clientes-list {
  list-style-type: none;
  padding: 0;
}

.cliente-item {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 15px;
  margin-bottom: 15px;
  border: 1px solid #bdc3c7;
  border-radius: 6px;
  background-color: #3b4f66;
}

.cliente-info {
  font-size: 18px;
}

.actions {
  display: flex;
  gap: 10px;
}

.actions button {
  padding: 10px 15px;
  font-size: 16px;
  border-radius: 6px;
  cursor: pointer;
  transition: background 0.3s;
}

.btn-edit {
  background-color: #f39c12;
  color: white;
  border: none;
}

.btn-edit:hover {
  background-color: #e67e22;
}

.btn-delete {
  background-color: #e74c3c;
  color: white;
  border: none;
}

.btn-delete:hover {
  background-color: #c0392b;
}

@media (max-width: 768px) {
  .container {
    width: 90%;
    padding: 20px;
  }

  .form-container {
    padding: 20px;
  }

  .cliente-item {
    flex-direction: column;
    align-items: flex-start;
  }

  .actions {
    width: 100%;
    justify-content: space-between;
  }

  .btn-submit {
    width: 100%;
  }
}
</style>
