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
            editedDate: null,
            editedTime: null,
            order: {
                lines: [],
                date: null,
                time: null,
                information: '',
                customer: {
                    firstName: '',
                    lastName: '',
                    email: '',
                    phone: ''
                },
                address1: '',
                address2: '',
                address3: '',
                city: '',
                zip: ''
            },
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
            return this.order.date.toLocaleDateString('fr-FR', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' })
        },
        deliveryFormFilled() {
            return this.order.customer.firstName !== '' && this.order.customer.lastName !== '' && this.order.customer.email !== '' && this.order.customer.phone !== '' &&
                this.order.address1 !== '' && this.order.address2 !== '' && this.order.address3 !== '' && this.order.city !== '' && this.order.zip !== ''
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
            for (var i = this.order.lines.length - 1; i >= 0; i--) {
                if (this.order.lines[i].productId === product.id) {
                    this.order.lines[i].quantity++
                    return
                }
            }
            this.order.lines.push({
                productId: product.id,
                productName: product.name,
                productPrice: product.price,
                quantity: 1
            })
        },
        addSideLine(side) {
            for (var i = this.order.lines.length - 1; i >= 0; i--) {
                if (this.order.lines[i].productId === side.id) {
                    this.order.lines[i].quantity++
                    return
                }
            }
            this.order.lines.push({
                productId: side.id,
                productName: side.name,
                productPrice: side.price,
                quantity: 1
            })
        },
        removeOrderLine(line) {
            this.order.lines.splice(this.order.lines.indexOf(line), 1)
        },
        handleDateInput(value) {
            this.order.date = value
        },
        handleTimeInput(value) {
            this.order.time = value
        },
        handleDeliveryTimeFormSubmit() {
            this.showTimeSelector = false
            this.showMenu = true
            this.showBasket = true
        },
        handleDeliveryTimeEdit() {
            this.editedDate = this.order.date
            this.editedTime = this.order.time
            this.showModal = true
        },
        handleDeliveryTimeModalSave() {
            this.order.date = this.editedDate
            this.order.time = this.editedTime
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
            <DeliveryTimeSelector slot="body" :default-date="order.date" :default-time="order.time"
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
                <delivery-form v-if="showDeliveryForm"
                    :on-first-name-input="value => { this.order.customer.firstName = value }"
                    :on-last-name-input="value => { this.order.customer.lastName = value }"
                    :on-email-input="value => { this.order.customer.email = value }"
                    :on-phone-input="value => { this.order.customer.phone = value }"
                    :on-address-one-input="value => { this.order.address1 = value }"
                    :on-address-two-input="value => { this.order.address2 = value }"
                    :on-address-three-input="value => { this.order.address3 = value }"
                    :on-city-input="value => { this.order.city = value }"
                    :on-zip-input="value => { this.order.zip = value }"
                >
                </delivery-form>
            </div>
            <div class="col-md-4">
                <div v-if="showBasket" v-sticky="{ zIndex: 1020, stickyTop: 115 }">
                    <cart :order-lines="order.lines" :handle-remove="removeOrderLine" v-on:complete="handleCartValidate()" v-on:edit="handleCartEdit()">
                        <div slot="info" class="my-3">
                            <div v-if="showDeliveryForm" class="form-group">
                                <label for="inputInformation">Informations</label>
                                <textarea @input="value => { this.order.information = value }" class="form-control" placeholder="Allergies, etc."></textarea>
                            </div>
                            <p class="mb-0 text-center">
                                Livraison le <a href="#" class="link" title="Modifier" v-on:click.prevent="handleDeliveryTimeEdit()">{{ readableDate }} à {{ order.time }}</a>.<br/>
                                Paiement en <strong>espèces</strong>.
                            </p>
                        </div>
                    </cart>
                    <div v-if="showDeliveryForm" class="mt-3">
                        <button v-if="deliveryFormFilled" class="btn btn-lg btn-block btn-primary" @click="handleOrder()">Commander</button>
                        <button v-else class="btn btn-lg btn-block btn-primary" aria-disabled="true" disabled>Commander</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
