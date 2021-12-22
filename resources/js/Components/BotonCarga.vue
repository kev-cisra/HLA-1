<template>
    <button v-if="verBot" class="btn" ><i :class="iconoV"></i> {{ textoV }}</button>
    <button v-else class="btn" disabled><span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span> {{ textoOC }}</button>
</template>

<script>
import Button from './Button.vue'
    export default {
        components: { Button },
        props: {
            verBot: {
                type: Boolean,
                default: true,
            },
            textoV: {
                type: String
            },
            iconoV: {
                type: String
            },
            textoOC: {
                type: String
            }
        }
    }
</script>
