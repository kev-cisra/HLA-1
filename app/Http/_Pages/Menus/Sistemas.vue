<template>
    <app-layout>
        <template #header>
            <div class="tw-mt-2 tw-text-center tw-text-white tw-bg-sky-600 tw-shadow-2xl tw-rounded-2xl tw-mr-16 tw-ml-16">
                <h3 class="tw-p-2"><i class="fas fa-house-user tw-ml-3 tw-mr-3"></i>Menu Sistemas</h3>
            </div>
        </template>

        <section class="Contenedor">
            <div class="MenuModulos">
                <!-- Modulo Equipos-->
                <div class="Modulo" v-if="hasAnyPermission(['Sistemas.EquiposComputo'])">
                    <Link href="Sistemas/EquiposComputo" class="LinkModulo">
                        <div class="IconoModulo">
                            <i class="fa-solid fa-desktop"></i>
                        </div>
                        <div>
                            <h4 class="TituloModulo">Equipos Cómputo</h4>
                            <span class="linea"></span>
                        </div>
                    </Link>
                </div>
                <!-- Modulo Asignación Equipos-->
                <div class="Modulo" v-if="hasAnyPermission(['Sistemas.EquiposComputo'])">
                    <Link href="Sistemas/EquiposAsignados" class="LinkModulo">
                        <div class="IconoModulo">
                            <i class="fa-solid fa-house-laptop"></i>
                        </div>
                        <div>
                            <h4 class="TituloModulo">Asignación Equipos</h4>
                            <span class="linea"></span>
                        </div>
                    </Link>
                </div>

                <!-- Modulo Calendario Mantenimientos-->
                <div class="Modulo" v-if="hasAnyPermission(['Sistemas.CalendarioMantenimientos'])">
                    <Link href="Sistemas/CalendarioMantenimientos" class="LinkModulo">
                        <div class="IconoModulo">
                            <i class="fa-solid fa-screwdriver-wrench"></i>
                        </div>
                        <div>
                            <h4 class="TituloModulo">Calendario Mantenimientos</h4>
                            <span class="linea"></span>
                        </div>
                    </Link>
                </div>

                <!-- Modulo Proveedores Sistemas-->
                <div class="Modulo" v-if="hasAnyPermission(['Sistemas.CotizacionSistemas'])">
                    <Link href="Sistemas/Proveedores" class="LinkModulo">
                        <div class="IconoModulo">
                            <i class="fas fa-truck"></i>
                        </div>
                        <div>
                            <h4 class="TituloModulo">Proveedores</h4>
                            <span class="linea"></span>
                        </div>
                    </Link>
                </div>

                <!-- Modulo Requisiciones Sistemas-->
                <div class="Modulo" v-if="hasAnyPermission(['Sistemas.RequisicionSistemas'])">
                    <Link href="Sistemas/RequisicionSistemas" class="LinkModulo">
                        <div class="IconoModulo">
                            <i class="fa-solid fa-cart-shopping"></i>
                        </div>
                        <div>
                            <h4 class="TituloModulo">Requisiciones Sistemas</h4>
                            <span class="linea"></span>
                        </div>
                    </Link>
                </div>

                <!-- Modulo Cotizaciones Sistemas-->
                <div class="Modulo" v-if="hasAnyPermission(['Sistemas.CotizacionSistemas'])">
                    <Link href="Sistemas/CotizacionSistemas" class="LinkModulo">
                        <div class="IconoModulo">
                            <i class="fa-brands fa-amazon-pay"></i>
                        </div>
                        <div>
                            <h4 class="TituloModulo">Cotizaciones</h4>
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
            'usuario',
            'modulos'
        ],
        components: {
            AppLayout,
            Link
        },
    }
</script>
