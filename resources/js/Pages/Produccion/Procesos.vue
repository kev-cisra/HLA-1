<template>
    <app-layout>
        Procesos
        <pre>
            {{procesos}}
        </pre>

    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout.vue';
    import JetButton from '@/Jetstream/Button';
    import JetInput from '@/Jetstream/Input';
    import Modal from '@/Jetstream/Modal';

    export default {
        props: [
            'usuario',
            'procesos',
            'areaM',
            'errors'
        ],
        components: {
            AppLayout,
            JetButton,
            JetInput,
            Modal,
                Modal,
        },
        data() {
            return {
                /*showModal: false,
                editMode: false,
                form: {
                    IdUser: this.usuario.id,
                    NombreModulo: null,
                    Icono: null,
                    Ruta: null,
                    Area: null,
                },*/
            }
        },
        methods: {
            /*openModal() {
                this.chageClose();
                this.reset();
                this.editMode = false;
            },
            chageClose(){
                this.showModal = !this.showModal
            },
            reset(){
                this.form = {
                    IdUser: this.usuario.id,
                    NombreModulo: null,
                    Icono: null,
                    Ruta: null,
                    Area: null,
                }
            },
            save(data) {
                this.$inertia.post('/Admin/Modulos', data, {
                    onSuccess: () => {this.reset(), this.chageClose()},
                });
            },
            edit: function (data) {
                this.form = Object.assign({}, data);
                //this.vari = data.id;
                this.editMode = true;
                this.chageClose();
            },
            update(data) {
                data._method = 'PUT';
                this.$inertia.post('/Admin/Modulos/' + data.id, data, {
                    onSuccess: () => {this.reset(), this.chageClose()},
                });
            },
            deleteRow: function (data) {
                if (!confirm('¿Estas seguro de querer eliminar este Modulo?')) return;
                data._method = 'DELETE';
                this.$inertia.post('/Admin/Modulos/' + data.id, data);
            }*/

        }
    }
</script>
