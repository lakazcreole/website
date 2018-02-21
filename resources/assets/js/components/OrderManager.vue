<script>
import VueSticky from 'vue-sticky'
const VueScrollTo = require('vue-scrollto')

export default {
    components: {
        'cart': require('./Cart'),
        'order-menu': require('./OrderMenu')
    },
    directives: {
        'sticky': VueSticky
    },
    data() {
        return {
            loaded: false,
            error: false,
            products: null,
            orderLines: []
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
        scrollToTag: function(tag) {
            const options = {
                container: 'body',
                easing: 'ease-in',
                offset: -100,
                cancelable: true,
                onDone: function() {
                  // scrolling is done
                },
                onCancel: function() {
                  // scrolling has been interrupted
                },
                x: false,
                y: true
            }
            this.$scrollTo(`#${tag}`, 500, options)
        }
    }
}
</script>

<template>
    <div v-if="error" class="text-center">
        <p>Le service de commande est indisponible. Veuillez réessayer plus tard.</p>
    </div>
    <div v-else-if="loaded" class="row my-3">
        <div class="col-md-8">
            <order-menu :products="products" :handle-add="addOrderLine"></order-menu>
        </div>
        <div class="col-md-4">
            <div v-sticky="{ zIndex: 1020, stickyTop: 115 }">
                <h2>Panier</h2>
                <cart :order-lines="orderLines" :handle-remove="removeOrderLine">
                </cart>
            </div>
        </div>
    </div>
</template>
