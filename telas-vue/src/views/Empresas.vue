<template>
  <div class="container">
    <h1>Cadastro de Empresas</h1>

    <!-- Formulário de Adição/Edição -->
    <div class="form-container">
      <h2>{{ isEditing ? 'Editar Empresa' : 'Cadastrar Nova Empresa' }}</h2>

      <form @submit.prevent="isEditing ? editarEmpresa() : adicionarEmpresa()">
        <div class="form-group">
          <label for="razao_social">Razão Social</label>
          <input type="text" v-model="empresaForm.razao_social" id="razao_social" required />
        </div>

        <div class="form-group">
          <label for="sigla">Sigla da Empresa</label>
          <input type="text" v-model="empresaForm.sigla" id="sigla" required />
        </div>

        <div class="form-group">
          <label for="codigo">Código da Empresa</label>
          <input type="number" v-model="empresaForm.codigo" id="codigo" required maxlength="4" @input="limitarCodigo('codigo')" />
        </div>

        <div class="form-group">
          <label for="empresa">Código da Empresa (Referência)</label>
          <input type="number" v-model="empresaForm.empresa" id="empresa" required maxlength="4" @input="limitarCodigo('empresa')" />
        </div>

        <div class="form-group btn-container">
          <button type="submit" class="btn-submit">
            {{ isEditing ? 'Salvar Alterações' : 'Adicionar Empresa' }}
          </button>
        </div>
      </form>
    </div>

    <!-- Lista de Empresas -->
    <div v-if="empresas.length > 0">
      <h3>Empresas Cadastradas</h3>
      <ul class="empresas-list">
        <li v-for="empresa in empresas" :key="empresa.codigo" class="empresa-item">
          <div class="empresa-info">
            <strong>{{ empresa.razao_social }}</strong> /
            <span>{{ empresa.sigla }}</span> /
            Código:
            <span>{{ empresa.codigo }}</span>
          </div>
          <div class="actions">
            <button @click="editarEmpresaForm(empresa)" class="btn-edit">Editar</button>
            <button @click="excluirEmpresa(empresa.codigo)" class="btn-delete">Excluir</button>
          </div>
        </li>
      </ul>
    </div>

    <p v-else>Não há empresas cadastradas.</p>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      empresas: [],
      empresaForm: { razao_social: '', sigla: '', codigo: '', empresa: '' },
      isEditing: false,
      empresaToEdit: null
    };
  },
  methods: {
    async carregarEmpresas() {
      try {
        const response = await axios.get(`${import.meta.env.VITE_API_URL}/empresas`);
        this.empresas = response.data;
      } catch (error) {
        console.error("Erro ao carregar empresas:", error);
      }
    },
    async adicionarEmpresa() {
      try {
        await axios.post(`${import.meta.env.VITE_API_URL}/empresas`, this.empresaForm);
        this.carregarEmpresas();
        this.resetarFormulario();
      } catch (error) {
        console.error("Erro ao adicionar empresa:", error);
      }
    },
    async editarEmpresa() {
      try {
        await axios.put(`${import.meta.env.VITE_API_URL}/empresas/${this.empresaToEdit.codigo}`, this.empresaForm);
        this.carregarEmpresas();
        this.resetarFormulario();
        this.isEditing = false;
      } catch (error) {
        console.error("Erro ao editar empresa:", error);
      }
    },
    editarEmpresaForm(empresa) {
      this.isEditing = true;
      this.empresaToEdit = empresa;
      this.empresaForm = { ...empresa };
    },
    async excluirEmpresa(id) {
      if (confirm("Tem certeza que deseja excluir?")) {
        try {
          await axios.delete(`${import.meta.env.VITE_API_URL}/empresas/${id}`);
          this.carregarEmpresas();
        } catch (error) {
          console.error("Erro ao excluir empresa:", error);
        }
      }
    },
    resetarFormulario() {
      this.empresaForm = { razao_social: '', sigla: '', codigo: '', empresa: '' };
      this.empresaToEdit = null;
    },
    limitarCodigo(campo) {
      // Limita o campo para no máximo 4 caracteres
      if (this.empresaForm[campo]) {
        this.empresaForm[campo] = this.empresaForm[campo].toString().slice(0, 4);
      }
    }
  },
  mounted() {
    this.carregarEmpresas();
  }
};
</script>

<style scoped>
.container {
  width: 100%;  /* Ajusta a largura para 100% da tela */
  max-width: 1200px;  /* Limite máximo para não ficar muito largo */
  margin: 20px auto;  /* Centraliza horizontalmente */
  padding: 40px;
  font-family: Arial, sans-serif;
  background-color: #2c3e50;
  color: white;
  border-radius: 10px;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
  display: flex;
  flex-direction: column;
  //align-items: center;  /* Centraliza o conteúdo dentro do container */
  justify-content: flex-start; /* Alinha o conteúdo para o topo */
}

h1 {
  text-align: center;
  font-size: 32px;
  color: #ecf0f1;
}

/* Formulário */
.form-container {
  width: 80%;
  max-width: 800px;  /* Limite máximo para o formulário */
  margin: 0 auto 40px;
  padding: 30px;
  border-radius: 8px;
  background-color: #34495e;
  display: flex;
  flex-direction: column;
}

/* Responsividade */
@media (max-width: 768px) {
  .container {
    width: 90%;
    padding: 20px;
  }

  .form-container {
    padding: 20px;
  }
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

.form-group input {
  width: 100%;
  padding: 12px;
  font-size: 16px;
  border-radius: 6px;
  border: 1px solid #bdc3c7;
  background-color: #ecf0f1;
  box-sizing: border-box;
}

.btn-container {
  text-align: center;
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

/* Lista de Empresas */
.empresas-list {
  list-style-type: none;
  padding: 0;
}

.empresa-item {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 15px;
  margin-bottom: 15px;
  border: 1px solid #bdc3c7;
  border-radius: 6px;
  background-color: #3b4f66;
}

.empresa-info {
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

/* Responsividade */
@media (max-width: 768px) {
  .container {
    width: 90%;
    padding: 20px;
  }

  .form-container {
    padding: 20px;
  }

  .empresa-item {
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
