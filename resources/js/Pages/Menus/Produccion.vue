<template>
    <app-layout>
        <template #header>
            <div class="tw-mt-2 tw-text-center tw-text-white tw-bg-cyan-800 tw-shadow-2xl tw-rounded-2xl tw-mr-16 tw-ml-16">
                <h3 class="tw-p-2"><i class="fas fa-house-user tw-ml-3 tw-mr-3"></i>Menu Produccion</h3>
            </div>
        </template>
        <section id="menu" class="tw-grid sm:tw-grid-cols-1 md:tw-grid-cols-3 lg:tw-grid-cols-6 tw-gap-4">
            <!-- Modulo personal -->
            <div class="tw-text-center tw-p-0 tw-transition tw-duration-700 tw-ease-in-out tw-transform hover:tw--translate-y-1 hover:tw-scale-110 tw-h-full tw-my-5" v-if="hasAnyPermission(['admin.index', 'Produccion.personal.index'])">
                <Link href="Produccion/Personal" class="tw-no-underline icono tw-text-9xl md:tw-text-8xl">
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
            <div class="tw-text-center tw-p-0 tw-transition tw-duration-700 tw-ease-in-out tw-transform hover:tw--translate-y-1 hover:tw-scale-110 tw-h-full tw-my-5" v-if="hasAnyPermission(['admin.index', 'Produccion.procesos.index'])">
                <Link href="Produccion/Procesos" class="tw-no-underline icono tw-text-9xl md:tw-text-8xl">
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
            <div class="tw-text-center tw-p-0 tw-transition tw-duration-700 tw-ease-in-out tw-transform hover:tw--translate-y-1 hover:tw-scale-110 tw-h-full tw-my-5" v-if="hasAnyPermission(['admin.index', 'Produccion.maquinas.index'])">
                <Link href="Produccion/Maquinas" class="tw-no-underline icono tw-text-9xl md:tw-text-8xl">
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
            <div class="tw-text-center tw-p-0 tw-transition tw-duration-700 tw-ease-in-out tw-transform hover:tw--translate-y-1 hover:tw-scale-110 tw-h-full tw-my-5" v-if="hasAnyPermission(['admin.index', 'Produccion.turnos.index'])">
                <Link href="Produccion/Turnos" class="tw-no-underline icono tw-text-9xl md:tw-text-8xl">
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
            <div class="tw-text-center tw-p-0 tw-transition tw-duration-700 tw-ease-in-out tw-transform hover:tw--translate-y-1 hover:tw-scale-110 tw-h-full tw-my-5" v-if="hasAnyPermission(['admin.index', 'Produccion.materiales.index'])">
                <Link href="Produccion/Materiales" class="tw-no-underline icono tw-text-9xl md:tw-text-8xl">
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
            <div class="tw-text-center tw-p-0 tw-transition tw-duration-700 tw-ease-in-out tw-transform hover:tw--translate-y-1 hover:tw-scale-110 tw-h-full tw-my-5" v-if="hasAnyPermission(['admin.index', 'Produccion.clamat.index'])">
                <Link href="Produccion/Clamat" class="tw-no-underline icono tw-text-9xl md:tw-text-8xl">
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
            <div class="tw-text-center tw-p-0 tw-transition tw-duration-700 tw-ease-in-out tw-transform hover:tw--translate-y-1 hover:tw-scale-110 tw-h-full tw-my-5" v-if="hasAnyPermission(['admin.index', 'Produccion.carga.index'])">
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
            <div class="tw-text-center tw-p-0 tw-transition tw-duration-700 tw-ease-in-out tw-transform hover:tw--translate-y-1 hover:tw-scale-110 tw-h-full tw-my-5" v-if="hasAnyPermission(['admin.index', 'Produccion.paros.index'])">
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
            <!-- modulo Reportes Produccion -->
            <div class="tw-text-center tw-p-0 tw-transition tw-duration-700 tw-ease-in-out tw-transform hover:tw--translate-y-1 hover:tw-scale-110 tw-h-full tw-my-5" v-if="hasAnyPermission(['admin.index', 'Produccion.reporpro.index'])">
                <Link href="Produccion/ReportesPro" class="tw-no-underline icono tw-text-9xl md:tw-text-8xl">
                    <div class="tw-flex tw-justify-center tw-mb-4">
                        <i class="fas fa-folder-open"></i>
                    </div>
                    <div>
                        <h4 class="tw-text-base tw-font-semibold tw-text-gray-400 tw-uppercase">Reportes</h4>
                        <span class="linea"></span>
                    </div>
                </Link>
            </div>

            <!-- modulo Objetivos -->
            <div class="tw-text-center tw-p-0 tw-transition tw-duration-700 tw-ease-in-out tw-transform hover:tw--translate-y-1 hover:tw-scale-110 tw-h-full tw-my-5" v-if="hasAnyPermission(['admin.index', 'Produccion.reporpro.index'])">
                <Link href="Produccion/ObjeCordi" class="tw-no-underline icono tw-text-9xl md:tw-text-8xl">
                    <div class="tw-flex tw-justify-center tw-mb-4">
                        <i class="fas fa-clipboard"></i>
                    </div>
                    <div>
                        <h4 class="tw-text-base tw-font-semibold tw-text-gray-400 tw-uppercase">Objetivos</h4>
                        <span class="linea"></span>
                    </div>
                </Link>
            </div>

            <!-- modulo Abastos y entregas -->
            <div class="tw-text-center tw-p-0 tw-transition tw-duration-700 tw-ease-in-out tw-transform hover:tw--translate-y-1 hover:tw-scale-110 tw-h-full tw-my-5" v-if="hasAnyPermission(['admin.index', 'Produccion.reporpro.index'])">
                <Link href="Produccion/AbaEntre" class="tw-no-underline icono tw-text-9xl md:tw-text-8xl">
                    <div class="tw-flex tw-justify-center tw-mb-4">
                        <i class="fas fa-dolly"></i>
                    </div>
                    <div>
                        <h4 class="tw-text-base tw-font-semibold tw-text-gray-400 tw-uppercase">Abastos y Entregas</h4>
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
        }
    }
</script>

