<template>
    <div class="row">
        <div v-if="hasCreatePermission" class="col-12 mb-2 text-end">
            <router-link :to='{name:"productAdd"}' class="btn btn-primary">Create</router-link>
        </div>
        <div class="col-12">
            <Table :searchIsEnable="true" title="Products" :setLoading="setLoading" :products="products" :links="links" :loading="loading" :getProducts="getProducts" />
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
        this.getProducts(to?.query?.page, to?.query?.search);
    },
    data() {
        return {
            loading: false,
            products: [],
            links: [],
        }
    },
    mounted() {
        this.getProducts(this.$route?.query?.page, this.$route?.query?.search);
    },
    computed: {
        hasCreatePermission() {
            return this.$store.state.auth.accesses ? this.$store.state.auth.accesses.find(item => item === 'Create product') : false;
        },
    },
    methods: {
        async getProducts(page, query = null) {
            this.loading = true;
            ProductService.list(page, query).then(response => {
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
        setLoading(status) {
          this.loading = status;
        }
    },
}
</script>
