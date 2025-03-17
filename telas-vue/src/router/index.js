import { createRouter, createWebHistory } from 'vue-router';
import Empresas from '@/views/Empresas.vue'; // Caminho para o componente Empresas
import Clientes from '@/views/Clientes.vue'; // Caminho para o componente Clientes

let Home;
const routes = [
    {
        path: '/',
        name: 'home',
        redirect: Home
    },
    {
        path: '/empresas',
        name: 'empresas',
        component: Empresas, // Página de Empresas
    },
    {
        path: '/clientes',
        name: 'clientes',
        component: Clientes, // Página de Clientes
    },
];

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes, // Configuração das rotas
});

export default router;
