<template>
    <app-layout>
        <section id="menu" class="tw-flex tw-justify-center tw-min-h-screen tw-mt-8 tw-min-w-screen">
            <div class="container-fluid">
                <div class="row">
                    <!-- Modulo -->
                    <div class="col-sm-12 col-md-4 col-lg-2 tw-text-center tw-p-0 tw-mt-2 tw-mb-14 xl:tw-mx-0 xl:tw-mt-10 tw-transition tw-duration-700 tw-ease-in-out tw-transform tw-h-1/6 sm:tw-h-1/4 hover:tw--translate-y-1 hover:tw-scale-110 tw-h-16 sm:tw-h-10">
                        <Link href="/Compras/Requisiciones" class="tw-no-underline icono tw-text-9xl md:tw-text-8xl">
                            <div class="tw-flex tw-justify-center tw-mb-4">
                                <i class="fas fa-clipboard-list"></i>
                            </div>
                            <div>
                                <h4 class="tw-text-base tw-font-semibold tw-text-gray-400 tw-uppercase">Requisiciones</h4>
                                <span class="linea"></span>
                            </div>
                        </Link>
                    </div>
                    <!-- Modulo -->
                    <div class="col-sm-12 col-md-4 col-lg-2 tw-text-center tw-p-0 tw-mt-2 tw-mb-14 xl:tw-mx-0 xl:tw-mt-10 tw-transition tw-duration-700 tw-ease-in-out tw-transform tw-h-1/6 sm:tw-h-1/4 hover:tw--translate-y-1 hover:tw-scale-110 tw-h-16 sm:tw-h-10">
                        <Link href="/Compras/RequisicionPapeleria" class="tw-no-underline icono tw-text-9xl md:tw-text-8xl">
                            <div class="tw-flex tw-justify-center tw-mb-4">
                                <i class="fas fa-pencil-ruler"></i>
                            </div>
                            <div>
                                <h4 class="tw-text-base tw-font-semibold tw-text-gray-400 tw-uppercase">REQUISICIÓN PAPELERIA</h4>
                                <span class="linea"></span>
                            </div>
                        </Link>
                    </div>
                    <!-- Modulo -->
                    <div class="col-sm-12 col-md-4 col-lg-2 tw-text-center tw-p-0 tw-mt-2 tw-mb-14 xl:tw-mx-0 xl:tw-mt-10 tw-transition tw-duration-700 tw-ease-in-out tw-transform tw-h-1/6 sm:tw-h-1/4 hover:tw--translate-y-1 hover:tw-scale-110 tw-h-16 sm:tw-h-10">
                        <Link href="/RecursosHumanos/Vacaciones" class="tw-no-underline icono tw-text-9xl md:tw-text-8xl">
                            <div class="tw-flex tw-justify-center tw-mb-4">
                                <i class="fas fa-calendar-check"></i>
                            </div>
                            <div>
                                <h4 class="tw-text-base tw-font-semibold tw-text-gray-400 tw-uppercase">VACACIONES</h4>
                                <span class="linea"></span>
                            </div>
                        </Link>
                    </div>
                    <!-- Modulo -->
                    <div class="col-sm-12 col-md-4 col-lg-2 tw-text-center tw-p-0 tw-mt-2 tw-mb-14 xl:tw-mx-0 xl:tw-mt-10 tw-transition tw-duration-700 tw-ease-in-out tw-transform tw-h-1/6 sm:tw-h-1/4 hover:tw--translate-y-1 hover:tw-scale-110 tw-h-16 sm:tw-h-10">
                        <Link href="/RecursosHumanos/Incidencias" class="tw-no-underline icono tw-text-9xl md:tw-text-8xl">
                            <div class="tw-flex tw-justify-center tw-mb-4">
                                <i class="fas fa-user-plus"></i>
                            </div>
                            <div>
                                <h4 class="tw-text-base tw-font-semibold tw-text-gray-400 tw-uppercase">INCIDENCIAS</h4>
                                <span class="linea"></span>
                            </div>
                        </Link>
                    </div>
                    <!--------------------------- Produccion -------------------->
                    <!-- modulo cargas -->
                    <div class="col-sm-12 col-md-4 col-lg-2 tw-text-center tw-p-0 tw-mt-2 tw-mb-14 xl:tw-mx-0 xl:tw-mt-10 tw-transition tw-duration-700 tw-ease-in-out tw-transform tw-h-1/6 sm:tw-h-1/4 hover:tw--translate-y-1 hover:tw-scale-110 tw-h-16 sm:tw-h-10" v-if="hasAnyPermission(['admin.index', 'Produccion.carga.index'])">
                        <Link href="Produccion/Carga" class="tw-no-underline icono tw-text-9xl md:tw-text-8xl">
                            <div class="tw-flex tw-justify-center tw-mb-4">
                                <i class="fas fa-pallet"></i>
                            </div>
                            <div>
                                <h4 class="tw-text-base tw-font-semibold tw-text-gray-400 tw-uppercase">CARGA DE PRODUCCIÓN</h4>
                                <span class="linea"></span>
                            </div>
                        </Link>
                    </div>
                    <!-- modulo Paros -->
                    <div class="col-sm-12 col-md-4 col-lg-2 tw-text-center tw-p-0 tw-mt-2 tw-mb-14 xl:tw-mx-0 xl:tw-mt-10 tw-transition tw-duration-700 tw-ease-in-out tw-transform tw-h-1/6 sm:tw-h-1/4 hover:tw--translate-y-1 hover:tw-scale-110 tw-h-16 sm:tw-h-10" v-if="hasAnyPermission(['admin.index', 'Produccion.paros.index'])">
                        <Link href="Produccion/Paros" class="tw-no-underline icono tw-text-9xl md:tw-text-8xl">
                            <div class="tw-flex tw-justify-center tw-mb-4">
                                <i class="fas fa-business-time"></i>
                            </div>
                            <div>
                                <h4 class="tw-text-base tw-font-semibold tw-text-gray-400 tw-uppercase">PAROS</h4>
                                <span class="linea"></span>
                            </div>
                        </Link>
                    </div>

                                        <!-- Modulo -->
                    <div class="col-sm-12 col-md-4 col-lg-2 tw-text-center tw-p-0 tw-mt-2 tw-mb-14 xl:tw-mx-0 xl:tw-mt-10 tw-transition tw-duration-700 tw-ease-in-out tw-transform tw-h-1/6 sm:tw-h-1/4 hover:tw--translate-y-1 hover:tw-scale-110 tw-h-16 sm:tw-h-10">
                        <Link href="/Compras/RequisicionesInsumos" class="tw-no-underline icono tw-text-9xl md:tw-text-8xl">
                            <div class="tw-flex tw-justify-center tw-mb-4">
                                <i class="fa-solid fa-clipboard-list"></i>
                            </div>
                            <div>
                                <h4 class="tw-text-base tw-font-semibold tw-text-gray-400 tw-uppercase">REQUISICIÓN INSUMOS</h4>
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
        },
    }
</script>
