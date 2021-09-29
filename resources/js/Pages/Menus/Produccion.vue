<template>
    <app-layout>
        <template #header>
            <div class="tw-mt-5 tw-text-center tw-text-white tw-bg-green-600 tw-shadow-2xl tw-rounded-2xl tw-mr-16 tw-ml-16 xl:tw-mt-8">
                <h3 class="tw-p-2"><i class="fas fa-house-user tw-ml-3 tw-mr-3"></i>Menu Produccion</h3>
            </div>
        </template>
        <section id="menu" class="tw-flex tw-justify-center tw-mt-8 tw-min-w-screen">

            <div class="container-fluid">
                <div class="row">
                    <!-- For --><!---- clase tw-w-1/6 tw-p-0 tw-mt-2 tw-text-center tw-transition tw-duration-700 tw-ease-in-out tw-transform tw-h-1/6 hover:tw--translate-y-1 hover:tw-scale-110-->
                    <!-- <div v-for="modulo in modelos" :key="modulo.id" class="col-sm-12 col-md-4 col-lg-2 tw-text-center tw-p-0 tw-mt-2 tw-mb-14 xl:tw-mx-0 xl:tw-mt-10 tw-transition tw-duration-700 tw-ease-in-out tw-transform tw-h-1/6 hover:tw--translate-y-1 hover:tw-scale-110 tw-h-16">
                        <Link :href="modulo.Ruta" class="tw-no-underline icono tw-text-9xl md:tw-text-8xl xl:tw-text-9xl">
                            <div class="tw-flex tw-justify-center tw-mb-4">
                                <i :class="modulo.Icono"></i>
                            </div>
                            <div>
                                <h4 class="tw-text-base tw-font-semibold tw-text-gray-400 tw-uppercase">{{ modulo.NombreModulo }}</h4>
                                <span class="linea"></span>
                            </div>
                        </Link>
                    </div> -->
                    <!-- Fin for -->
                    <!-- Modulo personal -->
                    <div class="col-sm-12 col-md-4 col-lg-2 tw-text-center tw-p-0 tw-mt-2 tw-mb-14 xl:tw-mx-0 xl:tw-mt-10 tw-transition tw-duration-700 tw-ease-in-out tw-transform tw-h-1/6 hover:tw--translate-y-1 hover:tw-scale-110 tw-h-16" v-if="hasAnyPermission(['admin.index', 'Produccion.personal.index'])">
                        <Link href="Produccion/Personal" class="tw-no-underline icono tw-text-9xl md:tw-text-8xl xl:tw-text-9xl">
                            <div class="tw-flex tw-justify-center tw-mb-4">
                                <i class="fas fa-users"></i>
                            </div>
                            <div>
                                <h4 class="tw-text-base tw-font-semibold tw-text-gray-400 tw-uppercase">PERSONAL</h4>
                                <span class="linea"></span>
                            </div>
                        </Link>
                    </div>
                    <!-- modulo procesos -->
                    <div class="col-sm-12 col-md-4 col-lg-2 tw-text-center tw-p-0 tw-mt-2 tw-mb-14 xl:tw-mx-0 xl:tw-mt-10 tw-transition tw-duration-700 tw-ease-in-out tw-transform tw-h-1/6 hover:tw--translate-y-1 hover:tw-scale-110 tw-h-16" v-if="hasAnyPermission(['admin.index', 'Produccion.procesos.index'])">
                        <Link href="Produccion/Procesos" class="tw-no-underline icono tw-text-9xl md:tw-text-8xl xl:tw-text-9xl">
                            <div class="tw-flex tw-justify-center tw-mb-4">
                                <i class="fas fa-cogs"></i>
                            </div>
                            <div>
                                <h4 class="tw-text-base tw-font-semibold tw-text-gray-400 tw-uppercase">PROCESOS</h4>
                                <span class="linea"></span>
                            </div>
                        </Link>
                    </div>
                    <!-- Modulo maquinas -->
                    <div class="col-sm-12 col-md-4 col-lg-2 tw-text-center tw-p-0 tw-mt-2 tw-mb-14 xl:tw-mx-0 xl:tw-mt-10 tw-transition tw-duration-700 tw-ease-in-out tw-transform tw-h-1/6 hover:tw--translate-y-1 hover:tw-scale-110 tw-h-16" v-if="hasAnyPermission(['admin.index', 'Produccion.maquinas.index'])">
                        <Link href="Produccion/Maquinas" class="tw-no-underline icono tw-text-9xl md:tw-text-8xl xl:tw-text-9xl">
                            <div class="tw-flex tw-justify-center tw-mb-4">
                                <i class="fas fa-digital-tachograph"></i>
                            </div>
                            <div>
                                <h4 class="tw-text-base tw-font-semibold tw-text-gray-400 tw-uppercase">MAQUINAS</h4>
                                <span class="linea"></span>
                            </div>
                        </Link>
                    </div>
                    <!-- Modulos turnos -->
                    <div class="col-sm-12 col-md-4 col-lg-2 tw-text-center tw-p-0 tw-mt-2 tw-mb-14 xl:tw-mx-0 xl:tw-mt-10 tw-transition tw-duration-700 tw-ease-in-out tw-transform tw-h-1/6 hover:tw--translate-y-1 hover:tw-scale-110 tw-h-16" v-if="hasAnyPermission(['admin.index', 'Produccion.turnos.index'])">
                        <Link href="Produccion/Turnos" class="tw-no-underline icono tw-text-9xl md:tw-text-8xl xl:tw-text-9xl">
                            <div class="tw-flex tw-justify-center tw-mb-4">
                                <i class="fas fa-user-clock"></i>
                            </div>
                            <div>
                                <h4 class="tw-text-base tw-font-semibold tw-text-gray-400 tw-uppercase">TURNOS Y EQUIPOS</h4>
                                <span class="linea"></span>
                            </div>
                        </Link>
                    </div>
                    <!-- Modulo materiales -->
                    <div class="col-sm-12 col-md-4 col-lg-2 tw-text-center tw-p-0 tw-mt-2 tw-mb-14 xl:tw-mx-0 xl:tw-mt-10 tw-transition tw-duration-700 tw-ease-in-out tw-transform tw-h-1/6 hover:tw--translate-y-1 hover:tw-scale-110 tw-h-16" v-if="hasAnyPermission(['admin.index', 'Produccion.materiales.index'])">
                        <Link href="Produccion/Materiales" class="tw-no-underline icono tw-text-9xl md:tw-text-8xl xl:tw-text-9xl">
                            <div class="tw-flex tw-justify-center tw-mb-4">
                                <i class="fas fa-boxes"></i>
                            </div>
                            <div>
                                <h4 class="tw-text-base tw-font-semibold tw-text-gray-400 tw-uppercase">MATERIALES</h4>
                                <span class="linea"></span>
                            </div>
                        </Link>
                    </div>
                    <!-- Modulo claves -->
                    <div class="col-sm-12 col-md-4 col-lg-2 tw-text-center tw-p-0 tw-mt-2 tw-mb-14 xl:tw-mx-0 xl:tw-mt-10 tw-transition tw-duration-700 tw-ease-in-out tw-transform tw-h-1/6 hover:tw--translate-y-1 hover:tw-scale-110 tw-h-16" v-if="hasAnyPermission(['admin.index', 'Produccion.clamat.index'])">
                        <Link href="Produccion/Clamat" class="tw-no-underline icono tw-text-9xl md:tw-text-8xl xl:tw-text-9xl">
                            <div class="tw-flex tw-justify-center tw-mb-4">
                                <i class="fas fa-barcode"></i>
                            </div>
                            <div>
                                <h4 class="tw-text-base tw-font-semibold tw-text-gray-400 tw-uppercase">CLAVES</h4>
                                <span class="linea"></span>
                            </div>
                        </Link>
                    </div>
                    <!-- modulo cargas -->
                    <div class="col-sm-12 col-md-4 col-lg-2 tw-text-center tw-p-0 tw-mt-2 tw-mb-14 xl:tw-mx-0 xl:tw-mt-10 tw-transition tw-duration-700 tw-ease-in-out tw-transform tw-h-1/6 hover:tw--translate-y-1 hover:tw-scale-110 tw-h-16" v-if="hasAnyPermission(['admin.index', 'Produccion.carga.index'])">
                        <Link href="Produccion/Carga" class="tw-no-underline icono tw-text-9xl md:tw-text-8xl xl:tw-text-9xl">
                            <div class="tw-flex tw-justify-center tw-mb-4">
                                <i class="fas fa-clipboard-list"></i>
                            </div>
                            <div>
                                <h4 class="tw-text-base tw-font-semibold tw-text-gray-400 tw-uppercase">CARGA DE DATOS</h4>
                                <span class="linea"></span>
                            </div>
                        </Link>
                    </div>
                    <!-- modulo Paros -->
                    <div class="col-sm-12 col-md-4 col-lg-2 tw-text-center tw-p-0 tw-mt-2 tw-mb-14 xl:tw-mx-0 xl:tw-mt-10 tw-transition tw-duration-700 tw-ease-in-out tw-transform tw-h-1/6 hover:tw--translate-y-1 hover:tw-scale-110 tw-h-16" v-if="hasAnyPermission(['admin.index', 'Produccion.paros.index'])">
                        <Link href="Produccion/Paros" class="tw-no-underline icono tw-text-9xl md:tw-text-8xl xl:tw-text-9xl">
                            <div class="tw-flex tw-justify-center tw-mb-4">
                                <i class="fas fa-business-time"></i>
                            </div>
                            <div>
                                <h4 class="tw-text-base tw-font-semibold tw-text-gray-400 tw-uppercase">PAROS</h4>
                                <span class="linea"></span>
                            </div>
                        </Link>
                    </div>
                    <!-- modulo Entregas -->
                    <div class="col-sm-12 col-md-4 col-lg-2 tw-text-center tw-p-0 tw-mt-2 tw-mb-14 xl:tw-mx-0 xl:tw-mt-10 tw-transition tw-duration-700 tw-ease-in-out tw-transform tw-h-1/6 hover:tw--translate-y-1 hover:tw-scale-110 tw-h-16" v-if="hasAnyPermission(['admin.index', 'Produccion.paros.index'])">
                        <Link href="Produccion/Entregas" class="tw-no-underline icono tw-text-9xl md:tw-text-8xl xl:tw-text-9xl">
                            <div class="tw-flex tw-justify-center tw-mb-4">
                                <i class="fas fa-truck-loading"></i>
                            </div>
                            <div>
                                <h4 class="tw-text-base tw-font-semibold tw-text-gray-400 tw-uppercase">Entregas</h4>
                                <span class="linea"></span>
                            </div>
                        </Link>
                    </div>
                </div>
            </div>
        </section>
    </app-layout>
</template>

<script>

    import AppLayout from '@/Layouts/AppLayout.vue';
    import { Link } from '@inertiajs/inertia-vue3';

    export default {
        props: [
            'usuario',
            'modelos'
        ],
        components: {
            AppLayout,
            Link,
        }
    }
</script>

