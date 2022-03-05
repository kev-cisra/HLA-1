<template>
    <app-layout>
        <Header :class="['tw-bg-blue-600', 'tw-mt-2 tw-text-center tw-text-white tw-shadow-xl tw-rounded-2xl']">
            <slot>
                <h3 class="tw-p-2">
                    <i class="fas fa-folder-open"></i>
                        Reporte de  Producción
                </h3>
            </slot>
        </Header>
        <Accions>
            <template  v-slot:SelectB v-if="usuario.dep_pers.length != 1">
                <div class="sm:tw-flex tw-gap-3">
                    <select class="InputSelect sm:tw-w-full" v-model="S_Area">
                        <option value="" disabled>Selecciona un departamento</option>
                        <option v-for="o in opc" :key="o.value" :value="o.value">{{o.text}}</option>
                    </select>
                </div>
            </template>
            <!--  <template v-slot:BtnNuevo v-if="S_Area">
                <div class="md:tw-flex tw-gap-3">
                    boton de carga masiva
                    <div class="tw-m-3">
                        <button class="btn btn-primary tw-w-full" @click="openModalC">Carga masiva</button>
                    </div> -->
                    <!-- Boton de filtros
                    <div class="tw-m-3">
                        <button class="btn btn-primary tw-w-full" data-bs-toggle="collapse" data-bs-target="#filtro" aria-expanded="false" aria-controls="filtro"><i class="fas fa-filter"> </i> Filtros</button>
                    </div>
                    <div class="tw-m-3">
                        <button class="btn tw-bg-green-600 hover:tw-bg-green-700 tw-text-white hover:tw-text-white tw-w-full" data-bs-toggle="collapse" data-bs-target="#grafica" aria-expanded="false" aria-controls="grafica"><i class="fas fa-chart-pie"></i> Graficas</button>
                    </div>
                </div>
            </template> -->
        </Accions>
        <div class="d-flex align-items-start m-auto tw-w-11/12">
            <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                <button class="nav-link active" id="v-pills-home-tab" data-bs-toggle="pill" data-bs-target="#v-pills-home" type="button" role="tab" aria-controls="v-pills-home" aria-selected="true">Abastos</button>
                <button class="nav-link" id="v-pills-profile-tab" data-bs-toggle="pill" data-bs-target="#v-pills-profile" type="button" role="tab" aria-controls="v-pills-profile" aria-selected="false">Entregas</button>
                <!-- <button class="nav-link" id="v-pills-messages-tab" data-bs-toggle="pill" data-bs-target="#v-pills-messages" type="button" role="tab" aria-controls="v-pills-messages" aria-selected="false">Messages</button>
                <button class="nav-link" id="v-pills-settings-tab" data-bs-toggle="pill" data-bs-target="#v-pills-settings" type="button" role="tab" aria-controls="v-pills-settings" aria-selected="false">Settings</button> -->
            </div>
            <div class="tab-content" id="v-pills-tabContent">
                <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, quibusdam quo provident illo soluta ullam totam. Iusto deleniti tempore earum rerum consequuntur dolore commodi dolor exercitationem ea ex, sapiente architecto.
                    <pre>
                        {{ depaT }}
                    </pre>
                </div>
                <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Atque, ipsum est distinctio facilis reiciendis rem voluptatem minima sapiente, provident odit pariatur facere soluta unde deserunt eveniet tenetur quod quo natus.
                    Lorem ipsum dolor sit, amet consectetur adipisicing elit. Saepe officia consectetur debitis nemo nostrum aperiam esse eos minima quas neque quo deleniti, natus est vero? Accusamus, fugiat officia. Tempora, ad.
                    <pre>
                        {{ carga }}
                    </pre>
                </div>
                <!-- <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">
                    Lorem, ipsum dolor sit amet consectetur adipisicing elit. Voluptate accusantium sit obcaecati dolorum eius ea est atque quas, dolore officiis, corrupti totam placeat maiores quaerat. Magnam dicta rerum nostrum dolorum?
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Aliquid, sed. Quaerat distinctio mollitia quasi perspiciatis laudantium placeat suscipit quis rem ipsam numquam? Nemo tenetur saepe quaerat consectetur esse eius doloribus?
                    Lorem ipsum dolor sit amet consectetur, adipisicing elit. Quae molestiae autem accusamus a optio. Ut cupiditate consectetur quia enim explicabo officiis in optio dolores ratione incidunt eius, obcaecati, tempora repellendus.
                </div>
                <div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">...</div> -->
            </div>
        </div>
    </app-layout>
</template>
<script>
    import AppLayout from '@/Layouts/AppLayout.vue';
    import Header from '@/Components/Header';
    import Accions from '@/Components/Accions';

    export default {
        props: [
            'usuario',
            'depa',
            'depaT'
        ],
        components: {
            AppLayout,
            Header,
            Accions,
        },

        data() {
            return {
                S_Area: '',
                carga: [],
            }
        },

        computed: {
            //Opciones departamento
            opc: function() {
                const ar = [];
                this.depa.forEach(r => {
                    if (r.departamentos) {
                        ar.push({text: r.departamentos.Nombre, value: r.departamentos.id});
                    }else{
                        ar.push({text: r.Nombre, value: r.id});
                        r.sub__departamentos.forEach(rr => {
                            ar.push({text: rr.Nombre, value: rr.id});
                            //console.log(rr.Nombre);
                        })
                    }
                })
                return ar;
            },
        },

        watch: {
            S_Area: async function(b){

                var datos = {'departamento_id': this.S_Area, 'modulo': 'abaEntre'};

                //Produccion
                let car = await axios.post('AbaEntre/Carga', datos)
                console.log(car)
                this.carga = car.data;

                //Materiales
                /* let mate = await axios.post('General/ConMateriales', datos)
                this.materiales = mate.data */
            },
        }
    }
</script>
