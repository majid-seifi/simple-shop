<template>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Update Product</h4>
                </div>
                <div class="card-body">
                    <form @submit.prevent="update">
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
                                <button type="submit" class="btn btn-primary">Update</button>
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
    name: "ProductEdit",
    data() {
        return {
            product: {
                title: "",
                details: "",
            },
            error: '',
        }
    },
    mounted() {
        this.showProduct()
    },
    methods: {
        showProduct() {
            ProductService.show(this.$route.params.id).then(data => {
                const {title, details} = data;
                this.product.title = title;
                this.product.details = details;
            }).catch(error => {
                console.log(error)
            });
        },
        update() {
            ProductService.update(this.$route.params.id, this.product).then(data => {
                this.$router.push({name: "productIndex"})
            }).catch(error => {
                this.error = JSON.stringify(error?.response?.data, null, 4);
                console.log(error);
            })
        }
    }
}
</script>
