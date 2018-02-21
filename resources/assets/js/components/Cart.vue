<script>
export default {
    props: {
        orderLines: {
            type: Array,
            required: true
        },
        handleRemove: {
            type: Function,
            require: true
        }
    },
    computed: {
        totalPrice() {
            return this.orderLines.reduce((accumulator, line) => accumulator + line.quantity * line.productPrice, 0)
        },
        deliveryCost() {
            if (this.totalPrice === 0 || this.totalPrice >= 15) return 0
            else if (this.totalPrice <= 13) return 2
            else return 15 - this.totalPrice
        },
        fullPrice() {
            return this.totalPrice + this.deliveryCost
        }
    }
}
</script>

<template>
    <div class="order-cart">
        <div class="card">
            <div v-if="orderLines.length === 0" class="card-header">
                Votre panier est vide.
            </div>
            <div v-else>
                <ul class="list-group list-group-flush">
                    <li v-for="line in orderLines" v-if="line.quantity" class="list-group-item">
                        <div class="d-flex flex-row align-items-center">
                            <span class="badge badge-pill badge-secondary mr-2 px-2 py-1">{{ line.quantity }}</span>
                            {{ line.productName }}
                            <span v-if="line.productPrice != 0" class="ml-auto">{{ (line.quantity * line.productPrice).toString().replace('.', ',') }} €</span>
                            <small v-else class="ml-auto">Offert</small>
                            <button type="button" class="text-danger close ml-3" @click="handleRemove(line)">&times;</button>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div v-if="totalPrice < 15">
                            <div class="d-flex flex-row align-items-center">
                                Livraison<span class="ml-auto">{{ deliveryCost.toString().replace('.', ',') }} €</span>
                            </div>
                            <small>Offert à partir de 15 € de commande (hors frais).</small>
                        </div>
                        <div v-else class="d-flex flex-row align-items-center">
                            Livraison <small class="ml-auto">Offert</small>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="card-footer d-flex flex-row align-items-center">
                Total : <span class="ml-auto">{{ fullPrice.toString().replace('.', ',') }} €</span>
            </div>
        </div>
        <div class="mt-3">
            <button v-if="orderLines.length === 0" class="btn btn-lg btn-block btn-primary" aria-disabled="true" disabled>Commander</button>
            <button v-else class="btn btn-lg btn-block btn-primary">Commander</button>
        </div>
    </div>
</template>
