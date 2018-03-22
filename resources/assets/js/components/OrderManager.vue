<script>
import VueSticky from 'vue-sticky'

export default {
    components: {
        'cart': require('./Cart'),
        'order-menu': require('./OrderMenu'),
        'delivery-form': require('./DeliveryForm')
    },
    directives: {
        'sticky': VueSticky
    },
    data() {
        return {
            loaded: false,
            error: false,
            products: null,
            orderLines: [],
            showMenu: true
        }
    },
    mounted() {
        this.fetchProducts()
    },
    methods: {
        fetchProducts() {
            axios.get('/api/products').then(response => {
                if (response.status === 200) {
                    this.products = response.data.data
                    this.loaded = true
                }
            }).catch(error => {
                console.log(error)
                this.error = true
            })
        },
        addOrderLine(product, side = null) {
            this.addProductLine(product)
            if (side) this.addSideLine(side)
        },
        addProductLine(product) {
            for (var i = this.orderLines.length - 1; i >= 0; i--) {
                if (this.orderLines[i].productId === product.id) {
                    this.orderLines[i].quantity++
                    return
                }
            }
            this.orderLines.push({
                productId: product.id,
                productName: product.name,
                productPrice: product.price,
                quantity: 1
            })
        },
        addSideLine(side) {
            for (var i = this.orderLines.length - 1; i >= 0; i--) {
                if (this.orderLines[i].productId === side.id) {
                    this.orderLines[i].quantity++
                    return
                }
            }
            this.orderLines.push({
                productId: side.id,
                productName: side.name,
                productPrice: side.price,
                quantity: 1
            })
        },
        removeOrderLine(line) {
            this.orderLines.splice(this.orderLines.indexOf(line), 1)
        },
        handleCartComplete() {
            this.showMenu = false
        },
        handleCartEdit() {
            this.showMenu = true
        }
    }
}
</script>

<template>
    <div v-if="error" class="text-center">
        <p>Le service de commande est indisponible. Veuillez réessayer plus tard.</p>
    </div>
    <div v-else-if="loaded" class="container">
        <div class="row">
            <div class="col-md-8">
                <order-menu v-if="showMenu" :products="products" :handle-add="addOrderLine"></order-menu>
                <delivery-form v-else></delivery-form>
            </div>
            <div class="col-md-4">
                <div v-sticky="{ zIndex: 1020, stickyTop: 115 }">
                    <cart :order-lines="orderLines" :handle-remove="removeOrderLine" v-on:complete="handleCartComplete()" v-on:edit="handleCartEdit()">
                    </cart>
                    <div v-if="!showMenu" class="mt-3">
                        <button class="btn btn-lg btn-block btn-primary" aria-disabled="true" disabled>Commander</button>
                        <button class="btn btn-lg btn-block btn-primary" @click="handleOrder()">Commander</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
