<template>
    <app-layout>
        <template #header>
            <div class="tw-mt-2 tw-text-center tw-text-white tw-bg-blueGray-600 tw-shadow-2xl tw-rounded-2xl tw-mr-16 tw-ml-16">
                <h3 class="tw-p-2"><i class="fas fa-house-user tw-ml-3 tw-mr-3"></i>Menu Administrador</h3>
            </div>
        </template>

        <section id="menu" class="tw-flex tw-justify-center tw-min-h-screen tw-mt-8 tw-min-w-screen">
            <div class="container-fluid">
                <div class="row">
                    <!-- Modulo -->
                    <div class="col-sm-12 col-md-4 col-lg-2 tw-text-center tw-p-0 tw-mt-2 tw-mb-14 xl:tw-mx-0 xl:tw-mt-10 tw-transition tw-duration-700 tw-ease-in-out tw-transform tw-h-1/6 sm:tw-h-1/4 hover:tw--translate-y-1 hover:tw-scale-110 tw-h-16 sm:tw-h-10" v-if="hasAnyPermission(['admin.index', 'Produccion.personal.index'])">
                        <Link href="/Admin/Modulos" class="tw-no-underline icono tw-text-9xl md:tw-text-8xl">
                            <div class="tw-flex tw-justify-center tw-mb-4">
                                <i class="fab fa-laravel"></i>
                            </div>
                            <div>
                                <h4 class="tw-text-base tw-font-semibold tw-text-gray-400 tw-uppercase">Modulos del Sistema</h4>
                                <span class="linea"></span>
                            </div>
                        </Link>
                    </div>
                    <!-- Modulo -->
                    <div class="col-sm-12 col-md-4 col-lg-2 tw-text-center tw-p-0 tw-mt-2 tw-mb-14 xl:tw-mx-0 xl:tw-mt-10 tw-transition tw-duration-700 tw-ease-in-out tw-transform tw-h-1/6 hover:tw--translate-y-1 hover:tw-scale-110 tw-h-16" v-if="hasAnyPermission(['admin.index', 'Produccion.procesos.index'])">
                        <Link href="/Admin/Usuarios" class="tw-no-underline icono tw-text-9xl md:tw-text-8xl">
                            <div class="tw-flex tw-justify-center tw-mb-4">
                                <i class="fab fa-laravel"></i>
                            </div>
                            <div>
                                <h4 class="tw-text-base tw-font-semibold tw-text-gray-400 tw-uppercase">Usuarios del Sistema</h4>
                                <span class="linea"></span>
                            </div>
                        </Link>
                    </div>
                    <!-- Modulo -->
                    <div class="col-sm-12 col-md-4 col-lg-2 tw-text-center tw-p-0 tw-mt-2 tw-mb-14 xl:tw-mx-0 xl:tw-mt-10 tw-transition tw-duration-700 tw-ease-in-out tw-transform tw-h-1/6 hover:tw--translate-y-1 hover:tw-scale-110 tw-h-16" v-if="hasAnyPermission(['admin.index', 'Produccion.turnos.index'])">
                        <Link href="Supply/InsumosSolicitados" class="tw-no-underline icono tw-text-9xl md:tw-text-8xl">
                            <div class="tw-flex tw-justify-center tw-mb-4">
                                <i class="fas fa-sitemap"></i>
                            </div>
                            <div>
                                <h4 class="tw-text-base tw-font-semibold tw-text-gray-400 tw-uppercase">ROLES DE USUARIO</h4>
                                <span class="linea"></span>
                            </div>
                        </Link>
                    </div>
                    <!-- Modulo -->
                    <div class="col-sm-12 col-md-4 col-lg-2 tw-text-center tw-p-0 tw-mt-2 tw-mb-14 xl:tw-mx-0 xl:tw-mt-10 tw-transition tw-duration-700 tw-ease-in-out tw-transform tw-h-1/6 hover:tw--translate-y-1 hover:tw-scale-110 tw-h-16" v-if="hasAnyPermission(['admin.index', 'Produccion.turnos.index'])">
                        <Link href="Supply/InsumosSolicitados" class="tw-no-underline icono tw-text-9xl md:tw-text-8xl">
                            <div class="tw-flex tw-justify-center tw-mb-4">
                                <i class="fas fa-code-branch"></i>
                            </div>
                            <div>
                                <h4 class="tw-text-base tw-font-semibold tw-text-gray-400 tw-uppercase">PANEL</h4>
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
    import AppLayout from '@/Layouts/AppLayout'
    import { Link } from '@inertiajs/inertia-vue3'
    import Welcome from '@/Jetstream/Welcome'
    import Canvas from "@/Components/Canvas";

    export default {
        components: {
            AppLayout,
            Link,
        },
    }
</script>
