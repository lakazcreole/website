<script>
import VueSticky from 'vue-sticky'
import DeliveryTimeForm from './DeliveryTimeForm'
import DeliveryTimeSelector from './DeliveryTimeSelector'

export default {
    components: {
        'cart': require('./Cart'),
        'modal': require('./Modal'),
        'order-menu': require('./OrderMenu'),
        'delivery-form': require('./DeliveryForm'),
        DeliveryTimeForm,
        DeliveryTimeSelector,
    },
    directives: {
        'sticky': VueSticky
    },
    data() {
        return {
            loaded: false,
            error: false,
            products: null,
            date: null,
            time: null,
            editedDate: null,
            editedTime: null,
            orderLines: [],
            showTimeSelector: true,
            showBasket: false,
            showMenu: false,
            showDeliveryForm: false,
            showModal: false,
        }
    },
    mounted() {
        this.fetchProducts()
    },
    computed: {
        readableDate() {
            return this.date.toLocaleDateString('fr-FR', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' })
        }
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
        handleDateInput(value) {
            this.date = value
        },
        handleTimeInput(value) {
            this.time = value
        },
        handleDeliveryTimeFormSubmit() {
            this.showTimeSelector = false
            this.showMenu = true
            this.showBasket = true
        },
        handleDeliveryTimeEdit() {
            this.editedDate = this.date
            this.editedTime = this.time
            this.showModal = true
        },
        handleDeliveryTimeModalSave() {
            this.date = this.editedDate
            this.time = this.editedTime
            this.showModal = false
        },
        handleCartValidate() {
            this.showMenu = false
            this.showDeliveryForm = true
        },
        handleCartEdit() {
            this.showMenu = true
            this.showDeliveryForm = false
        },
    }
}
</script>

<template>
    <div v-if="error" class="text-center">
        <p>Le service de commande est indisponible. Veuillez réessayer plus tard.</p>
    </div>
    <div v-else-if="loaded" class="container">
        <div v-if="showTimeSelector">
            <h2>Livraison</h2>
            <DeliveryTimeForm @submit="handleDeliveryTimeFormSubmit" :on-date-input="handleDateInput" :on-time-input="handleTimeInput"></DeliveryTimeForm>
        </div>
        <modal v-if="showModal" @close="showModal = false">
            <h3 slot="header">Livraison</h3>
            <DeliveryTimeSelector slot="body" :default-date="date" :default-time="time"
                :on-date-input="value => { this.editedDate = value }"
                :on-time-input="value => { this.editedTime = value }"
                >
            </DeliveryTimeSelector>
            <div slot="footer" class="text-right">
                <button type="button" class="btn btn-secondary ml-2" @click="showModal = false">Annuler</button>
                <button type="button" class="btn btn-primary ml-2" @click="handleDeliveryTimeModalSave">Modifier</button>
            </div>
        </modal>
        <div class="row">
            <div class="col-md-8">
                <order-menu v-if="showMenu" :products="products" :handle-add="addOrderLine"></order-menu>
                <delivery-form v-if="showDeliveryForm"></delivery-form>
            </div>
            <div class="col-md-4">
                <div v-if="showBasket" v-sticky="{ zIndex: 1020, stickyTop: 115 }">
                    <cart :order-lines="orderLines" :handle-remove="removeOrderLine" v-on:complete="handleCartValidate()" v-on:edit="handleCartEdit()">
                        <div slot="info" class="my-3 text-center">
                            <p class="mb-0">
                                Livraison le <a href="#" class="link" title="Modifier" v-on:click.prevent="handleDeliveryTimeEdit()">{{ readableDate }} à {{ time }}</a>.<br/>
                                Paiement en <strong>espèces</strong>.
                            </p>
                        </div>
                    </cart>
                    <div v-if="showDeliveryForm" class="mt-3">
                        <button v-if="canOrder" class="btn btn-lg btn-block btn-primary" @click="handleOrder()">Commander</button>
                        <button v-else class="btn btn-lg btn-block btn-primary" aria-disabled="true" disabled>Commander</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
