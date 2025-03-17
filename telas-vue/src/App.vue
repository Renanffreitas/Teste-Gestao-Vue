<template>
  <div class="app-container">
    <!-- Botão para voltar à tela inicial (aparece em todas as páginas exceto na Home) -->
    <div v-if="$route.path !== '/'" class="top-bar">
      <router-link to="/" class="home-btn">Início</router-link>
    </div>

    <!-- Tela inicial -->
    <div v-if="$route.path === '/'" class="index-container">
      <h1>Sistema de Gestão Basico Teste</h1>
      <div class="button-group">
        <router-link to="/empresas" class="btn">Gerenciar Empresas</router-link>
        <router-link to="/clientes" class="btn">Gerenciar Clientes</router-link>
      </div>
    </div>

    <!-- Exibição das outras rotas -->
    <router-view v-else />
  </div>
</template>

<script setup>
// O Vue Router já gerencia a exibição dos componentes dinamicamente
</script>

<style>
/* Garante que a tela ocupe toda a altura */
html, body, #app {
  height: 100%;
  margin: 0;
  padding: 0;
  background-color: #2c3e50;
  color: white;
  font-family: Arial, sans-serif;
  //display: flex;
  justify-content: center;
  align-items: center;
}

/* Estilização do contêiner principal */
.app-container {
  width: 100%;
  text-align: center;
}

/* Barra superior com o botão de início */
.top-bar {
  position: absolute;
  top: 20px;
  left: 20px;
}

.home-btn {
  text-decoration: none;
  padding: 10px 20px;
  font-size: 18px;
  font-weight: bold;
  border-radius: 6px;
  background-color: #3498db;
  color: white;
  transition: background 0.3s;
}

.home-btn:hover {
  background-color: #2980b9;
}

/* Estilização da tela inicial */
.index-container {
  background-color: #34495e;
  padding: 40px;
  border-radius: 10px;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
}

h1 {
  font-size: 28px;
  margin-bottom: 20px;
  color: #ecf0f1;
}

/* Grupo de botões */
.button-group {
  display: flex;
  gap: 20px;
  justify-content: center;
}

/* Estilo dos botões */
.btn {
  text-decoration: none;
  padding: 15px 25px;
  font-size: 18px;
  font-weight: bold;
  border-radius: 6px;
  background-color: #27ae60;
  color: white;
  transition: background 0.3s;
}

.btn:hover {
  background-color: #2ecc71;
}
</style>
