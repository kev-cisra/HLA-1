<template>
    <app-layout>
        <section id="menu" class="tw-flex tw-justify-center tw-min-h-screen tw-mt-8 tw-min-w-screen">
            <!-- For -->
            <div class="tw-w-1/6 tw-p-0 tw-mt-2 tw-text-center tw-transition tw-duration-700 tw-ease-in-out tw-transform tw-h-1/6 hover:tw--translate-y-1 hover:tw-scale-110">
                <Link href="/Compras/Requisiciones" class="tw-no-underline icono">
                    <div class="tw-flex tw-justify-center tw-mb-4">
                        <i class="fas fa-clipboard-list"></i>
                    </div>
                    <div>
                        <h4 class="tw-text-base tw-font-semibold tw-text-gray-400 tw-uppercase">Requisiciones</h4>
                        <span class="linea"></span>
                    </div>
                </Link>
            </div>

            <div class="tw-w-1/6 tw-p-0 tw-mt-2 tw-text-center tw-transition tw-duration-700 tw-ease-in-out tw-transform tw-h-1/6 hover:tw--translate-y-1 hover:tw-scale-110">
                <Link href="/Compras/RequisicionPapeleria" class="tw-no-underline icono">
                    <div class="tw-flex tw-justify-center tw-mb-4">
                        <i class="fas fa-pencil-ruler"></i>
                    </div>
                    <div>
                        <h4 class="tw-text-base tw-font-semibold tw-text-gray-400 tw-uppercase">REQUISICIÓN PAPELERIA</h4>
                        <span class="linea"></span>
                    </div>
                </Link>
            </div>
            <!-- Fin for -->

            <!-- Produccion -->
            <!-- modulo cargas -->
            <div class="tw-w-1/6 tw-p-0 tw-mt-2 tw-text-center tw-transition tw-duration-700 tw-ease-in-out tw-transform tw-h-1/6 hover:tw--translate-y-1 hover:tw-scale-110" v-if="hasAnyPermission(['admin.index', 'Produccion.carga.index'])">
                <Link href="Produccion/Carga" class="tw-no-underline icono">
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
            <div class="tw-w-1/6 tw-p-0 tw-mt-2 tw-text-center tw-transition tw-duration-700 tw-ease-in-out tw-transform tw-h-1/6 hover:tw--translate-y-1 hover:tw-scale-110" v-if="hasAnyPermission(['admin.index', 'Produccion.paros.index'])">
                <Link href="Produccion/Paros" class="tw-no-underline icono">
                    <div class="tw-flex tw-justify-center tw-mb-4">
                        <i class="fas fa-business-time"></i>
                    </div>
                    <div>
                        <h4 class="tw-text-base tw-font-semibold tw-text-gray-400 tw-uppercase">PAROS</h4>
                        <span class="linea"></span>
                    </div>
                </Link>
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
