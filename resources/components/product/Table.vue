<template>
    <div class="card">
        <div class="card-header">
            <h4>{{ title }}</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <div v-if="loading" class="spin-loading d-flex justify-content-center">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
                <table v-else class="table table-bordered">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th v-if="loggedIn">Actions</th>
                    </tr>
                    </thead>
                    <tbody v-if="products.length > 0">
                    <tr v-for="(product,key) in products" :key="key">
                        <td>{{ product.id }}</td>
                        <td>{{ product.title }}</td>
                        <td v-if="loggedIn">
                            <div class="btn-group">
                                <router-link v-if="hasReadPermission" :to='{ name:"productView" , params:{ id:product.id } }'
                                             class="btn btn-info text-white">View
                                </router-link>
                                <router-link v-if="hasUpdatePermission" :to='{ name:"productEdit" , params:{ id:product.id } }'
                                             class="btn btn-success">Edit
                                </router-link>
                                <button v-if="hasDeletePermission" type="button" @click="deleteProduct(product.id)" class="btn btn-danger">
                                    Delete
                                </button>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                    <tbody v-else>
                    <tr>
                        <td colspan="4" align="center">No Products Found.</td>
                    </tr>
                    </tbody>
                </table>
                <Pagination class="mt-6" :links="links" />
            </div>
        </div>
    </div>
</template>

<script>
import Pagination from "../Pagination.vue";
import {defineComponent} from "vue";
import ProductService from "../../services/product.service";

export default defineComponent({
    props: {
        title: String,
        products: Array,
        loading: Boolean,
        links: Array,
    },
    name: "Table",
    components: {Pagination},
    computed: {
        loggedIn() {
            return this.$store.state.auth.status.loggedIn;
        },
        hasReadPermission() {
            return this.$store.state.auth.accesses ? this.$store.state.auth.accesses.find(item => item === 'Read product') : false;
        },
        hasUpdatePermission() {
            return this.$store.state.auth.accesses ? this.$store.state.auth.accesses.find(item => item === 'Update product') : false;
        },
        hasDeletePermission() {
            return this.$store.state.auth.accesses ? this.$store.state.auth.accesses.find(item => item === 'Delete product') : false;
        },
    },
    methods: {
        deleteProduct(id) {
            if (confirm("Are you sure to delete this product ?")) {
                this.loading = true;
                ProductService.delete(id).then(response => {
                    this.getProducts();
                }).catch(error => {
                    console.log(error);
                })
            }
        },
    },
});
</script>

<style scoped>

</style>
