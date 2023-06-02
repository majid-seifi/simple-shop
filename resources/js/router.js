import {createRouter, createWebHistory} from "vue-router";

const ProductIndex = () => import('../components/product/Index.vue');
const ProductAdd = () => import('../components/product/Add.vue');
const ProductView = () => import('../components/product/View.vue');
const ProductEdit = () => import('../components/product/Edit.vue');
const Profile = () => import('../components/Profile.vue');

const Login = () => import('../components/Login.vue');

const routes = [
    {
        name: 'productIndex',
        path: '/',
        component: ProductIndex,
        alias: '/products',
    },
    {
        name: 'login',
        path: '/login',
        component: Login,
    },
    {
        name: 'profile',
        path: '/profile',
        component: Profile,
    },
    {
        name: 'productView',
        path: '/product/:id',
        component: ProductView,
    },
    {
        name: 'productEdit',
        path: '/product/:id/edit',
        component: ProductEdit,
    },
    {
        name: 'productAdd',
        path: '/product/add',
        component: ProductAdd,
    }
];

const router = createRouter({
    history : createWebHistory(),
    routes
})

export default router;
