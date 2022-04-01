<template>
    <app-layout>
        <template #header>
            <div class="tw-mt-2 tw-text-center tw-text-white tw-bg-green-600 tw-shadow-2xl tw-rounded-2xl tw-mr-16 tw-ml-16">
                <h3 class="tw-p-2"><i class="fas fa-house-user tw-ml-3 tw-mr-3"></i>Menu Recursos Humanos</h3>
            </div>
        </template>

        <section class="Contenedor">
            <div class="MenuModulos">
                <!-- Modulo Perfiles-->
                <div class="Modulo">
                    <Link href="/RecursosHumanos/PerfilesUsuarios" class="LinkModulo">
                        <div class="IconoModulo">
                            <i class="fas fa-users"></i>
                        </div>
                        <div>
                            <h4 class="TituloModulo">Perfiles</h4>
                            <span class="linea"></span>
                        </div>
                    </Link>
                </div>

                <!-- Modulo Vacaciones-->
                <div class="Modulo">
                    <Link href="/RecursosHumanos/Vacaciones" class="LinkModulo">
                        <div class="IconoModulo">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <div>
                            <h4 class="TituloModulo">Vacaciones</h4>
                            <span class="linea"></span>
                        </div>
                    </Link>
                </div>

                <!-- Modulo Cancelacion vacaciones-->
                <div class="Modulo">
                    <Link href="/RecursosHumanos/CancelaVacaciones" class="LinkModulo">
                        <div class="IconoModulo">
                            <i class="fas fa-file-signature"></i>
                        </div>
                        <div>
                            <h4 class="TituloModulo">Revisión Vacaciones</h4>
                            <span class="linea"></span>
                        </div>
                    </Link>
                </div>

                <!-- Modulo ReporteVacaciones-->
                <div class="Modulo">
                    <Link href="/RecursosHumanos/ReporteVacaciones" class="LinkModulo">
                        <div class="IconoModulo">
                            <i class="fas fa-file-contract"></i>
                        </div>
                        <div>
                            <h4 class="TituloModulo">Reporte Vacaciones</h4>
                            <span class="linea"></span>
                        </div>
                    </Link>
                </div>

                <!-- Modulo Incidencias-->
                <div class="Modulo">
                    <Link href="/RecursosHumanos/Incidencias" class="LinkModulo">
                        <div class="IconoModulo">
                            <i class="fas fa-user-plus"></i>
                        </div>
                        <div>
                            <h4 class="TituloModulo">Incidencias</h4>
                            <span class="linea"></span>
                        </div>
                    </Link>
                </div>

                <!-- Modulo ReporteIncidencias-->
                <div class="Modulo">
                    <Link href="/RecursosHumanos/ReporteIncidencias" class="LinkModulo">
                        <div class="IconoModulo">
                            <i class="fas fa-file-invoice"></i>
                        </div>
                        <div>
                            <h4 class="TituloModulo">Reporte Incidencias</h4>
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
