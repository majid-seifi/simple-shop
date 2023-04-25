<template>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Add Product</h4>
                </div>
                <div class="card-body">
                    <form @submit.prevent="create">
                        <div class="row">
                            <div class="col-12 mb-2">
                                <div class="form-group">
                                    <label>Title</label>
                                    <input type="text" class="form-control" v-model="product.title">
                                </div>
                            </div>
                            <div class="col-12 mb-2">
                                <div class="form-group">
                                    <label>Details</label>
                                    <input type="text" class="form-control" v-model="product.details">
                                </div>
                            </div>
                            <div class="col-12 mb-2">
                                <pre dir="ltr" class="text-danger">{{ error }}</pre>
                            </div>
                            <div class="col-12 mb-2">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import ProductService from "../../services/product.service";

export default {
    name: "ProductAdd",
    data() {
        return {
            product: {
                title: "",
                details: "",
            },
            error: '',
        }
    },
    methods: {
        create() {
            ProductService.create(this.product).then(data => {
                this.$router.push({name: "productIndex"});
            }).catch(error => {
                this.error = JSON.stringify(error.response.data, null, 4)
                console.log(error);
            });
        }
    }
}
</script>
