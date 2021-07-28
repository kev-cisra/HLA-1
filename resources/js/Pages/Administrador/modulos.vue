<template>
    <app-layout>
        <jet-button class="tw-bg-green-500 tw-m-5 tw-rounded focus:tw-outline-none hover:tw-bg-green-300">Agregar</jet-button>

        <modal :show="showModal" @close="chageClose">
            
        </modal>

        {{modulos}}
    </app-layout>

</template>

<script>
    import AppLayout from '../../Layouts/AppLayout.vue';
    import JetButton from '@/Jetstream/Button';
    import Modal from '@/Jetstream/Modal';

    export default {
        props: [
            'usuario',
            'modulos'
        ],
        components: {
            AppLayout,
            JetButton,
            Modal,
                Modal,
        },
        data() {
            return {
                showModal: false
            }
        },
        methods: {
            chageClose(){
                this.showModal = !this.showModal
            }
        }
    }
</script>
