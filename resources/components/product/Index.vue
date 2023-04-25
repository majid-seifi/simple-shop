<template>
    <div class="row">
        <div v-if="hasCreatePermission" class="col-12 mb-2 text-end">
            <router-link :to='{name:"productAdd"}' class="btn btn-primary">Create</router-link>
        </div>
        <div class="col-12">
            <Table title="Products" :products="products" :links="links" :loading="loading" />
        </div>
    </div>
</template>
<script>
import ProductService from "../../services/product.service";
import Pagination from "../Pagination.vue";
import Table from "./Table.vue";

export default {
    name: 'ProductIndex',
    components: {Table, Pagination},
    beforeRouteUpdate (to, from, next) {
        next();
        this.getProducts(to?.query?.page);
    },
    data() {
        return {
            loading: false,
            products: [],
            links: [],
        }
    },
    mounted() {
        this.getProducts(this.$route?.query?.page);
    },
    computed: {
        hasCreatePermission() {
            return this.$store.state.auth.accesses ? this.$store.state.auth.accesses.find(item => item === 'Create product') : false;
        },
    },
    methods: {
        async getProducts(page) {
            this.loading = true;
            ProductService.list(page).then(response => {
                this.products = response.data;
                this.links = response.links;
            }).catch(error => {
                console.log(error)
                this.products = [];
                this.links = [];
            }).finally(() => {
                this.loading = false;
            });
        },
    },
}
</script>
