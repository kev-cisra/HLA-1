<template>
    <app-layout>
        <Header>
            Área: {{usuario.perfiles_area.Nombre}}
        </Header>
        <pre>
            {{procesos}}
        </pre>
        <Accions>
            <template  v-slot:SelectB>
                <select  v-show="!SM" @change="verTabla" class="InputSelect" v-model="S_Area">
                    <option value="">Selecciona una área</option>
                    <option v-for="area in areas" :key="area" :value="area.id">{{ area.Nombre }}</option>
                </select>
            </template>
            <template v-slot:BtnNuevo>
                    <jet-button @click="openModal" class="BtnNuevo">Nuevo Módulo </jet-button>
                </template>
        </Accions>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout.vue';
    import Header from '@/Components/Header'
    import Accions from '@/Components/Accions'
    import Table from '@/Components/Table'
    import JetButton from '@/Components/Button';
    import JetCancelButton from '@/Components/CancelButton';
    import JetInput from '@/Components/Input';
    import JetSelect from '@/Components/Select';
    import Modal from '@/Jetstream/Modal';

    export default {
        props: [
            'usuario',
            'procesos',
            'areas',
            'areaM',
            'errors'
        ],
        components: {
            AppLayout,
            Header,
            Accions,
            Table,
            JetButton,
            JetCancelButton,
            JetInput,
            JetSelect,
            Modal,
        },
        data() {
            return {
                S_Area: '',
                SM: false,
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
        mounted() {
            this.mostSelect();
        },
        methods: {
            mostSelect() {
                this.$nextTick(() => {
                    if(this.usuario.perfiles_area.idArea !== "PRO"){
                        this.SM = true;
                    }
                });
            },
            verTabla(event){
                //console.log(event.target.value)
                this.$inertia.get('/Produccion/Procesos',{ busca: event.target.value }, { preserveState: true })
            },
            openModal() {
                console.log(this.usuario.perfiles_area.idArea == "PRO")
                //this.chageClose();
                //this.reset();
                //this.editMode = false;
            },
            /*chageClose(){
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
