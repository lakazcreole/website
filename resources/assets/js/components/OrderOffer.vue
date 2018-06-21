<template>
  <div class="card">
    <div class="btn-card">
      <span v-if="description" v-tooltip="description" class="info position-absolute pin-r m-3 badge badge-pill badge-light">i</span>
      <img class="card-img-top" style="height:300px" :src="imgSrc" :alt="name">
      <div class="position-asbolute card-img-overlay"/>
      <div class="position-absolute card-img-header p-3 w-100">
        <div class="d-flex">
          <div class="h3">{{ name }}</div>
          <div class="ml-auto my-auto price">{{ price.toFixed(2).toString().replace('.', ',') }} €</div>
        </div>
      </div>
      <div class="btn-wrapper position-absolute h-100 w-100 d-flex">
        <button class="btn btn-outline-primary btn-lg m-auto" @click="add">Ajouter</button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    id: {
      type: Number,
      required: true
    },
    name: {
      type: String,
      required: true
    },
    price: {
      type: Number,
      required: true
    },
    imgSrc: {
      type: String,
      required: true
    },
    description: {
      type: String,
      required: false,
      default: null
    }
  },

  methods: {
    add () {
      this.$emit('add')
    }
  }
}
</script>

<style lang="scss" scoped>
.btn-card {
  border:none;
  box-shadow: 0 8px 16px 0 rgba(0,0,0,0.05), 0 6px 20px 0 rgba(0,0,0,0.05);
  overflow: hidden;

  .pin-r {
    right: 0;
  }
  .badge {
    font-size: 1rem;
    font-weight: bold;
    // font-style: italic;
  }

  .card-img-header {
    transform: translateY(-100%);
    color: white;
    text-shadow: 2px 2px 4px #000000;

    .price {
      min-width: 65px;
      font-size: 1.2rem;
    }
  }

  .card-img-overlay {
    transition: background-color 0.5s;
  }

  .btn-wrapper {
    transform: translateY(-100%);
    opacity: 0;
    transition: opacity 0.5s;
  }
}

.btn-card:hover {
  .badge {
    z-index: 1;
  }
  .card-img-overlay {
    background-color: rgba(0, 0, 0, 0.5);
  }
  .btn-wrapper {
    opacity: 1;
  }
}
</style>
