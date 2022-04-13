<template>
    <app-layout>
        <template #header>
            <div class="tw-mt-2 tw-text-center tw-text-white tw-bg-teal-600 tw-shadow-2xl tw-rounded-2xl tw-mr-16 tw-ml-16">
                <h3 class="tw-p-2"><i class="fas fa-house-user tw-ml-3 tw-mr-3"></i>Menu Compras</h3>
            </div>
        </template>

        <section class="Contenedor">
            <div class="MenuModulos">
                <!-- Modulo Proveedores-->
                <div class="Modulo" v-if="hasAnyPermission(['Compras.Proveedores'])">
                    <Link href="/Compras/Proveedores" class="LinkModulo">
                        <div class="IconoModulo">
                            <i class="fas fa-truck"></i>
                        </div>
                        <div>
                            <h4 class="TituloModulo">PROVEEDORES</h4>
                            <span class="linea"></span>
                        </div>
                    </Link>
                </div>

                <!-- Modulo Cotizaciones-->
                <div class="Modulo" v-if="hasAnyPermission(['Compras.Cotizaciones'])">
                    <Link href="/Compras/Cotizaciones" class="LinkModulo">
                        <div class="IconoModulo">
                            <i class="fas fa-calculator"></i>
                        </div>
                        <div>
                            <h4 class="TituloModulo">COTIZACIONES</h4>
                            <span class="linea"></span>
                        </div>
                    </Link>
                </div>

                <!-- Modulo Papeleria-->
                <div class="Modulo" v-if="hasAnyPermission(['Compras.Papeleria'])">
                    <Link href="/Compras/Papeleria" class="LinkModulo">
                        <div class="IconoModulo">
                            <i class="fas fa-store"></i>
                        </div>
                        <div>
                            <h4 class="TituloModulo">PAPELERÍA</h4>
                            <span class="linea"></span>
                        </div>
                    </Link>
                </div>

                <!-- Modulo Alta Papeleria-->
                <div class="Modulo" v-if="hasAnyPermission(['Compras.AltaPapeleria'])">
                    <Link href="/Compras/AltaPapeleria" class="LinkModulo">
                        <div class="IconoModulo">
                            <i class="fas fa-pencil-alt"></i>
                        </div>
                        <div>
                            <h4 class="TituloModulo">ALTA PAPELERÍA</h4>
                            <span class="linea"></span>
                        </div>
                    </Link>
                </div>

                <!-- Modulo Insumos-->
                <div class="Modulo" v-if="hasAnyPermission(['Compras.Insumos'])">
                    <Link href="/Compras/Insumos" class="LinkModulo">
                        <div class="IconoModulo">
                            <i class="fa-solid fa-boxes-stacked"></i>
                        </div>
                        <div>
                            <h4 class="TituloModulo">INSUMOS</h4>
                            <span class="linea"></span>
                        </div>
                    </Link>
                </div>
        </div>

        </section>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import { Link } from '@inertiajs/inertia-vue3'

    export default {
        props: [
            'User',
        ],
        components: {
            AppLayout,
            Link
        },
    }
</script>
