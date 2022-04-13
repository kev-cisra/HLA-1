<template>
    <div>
        <jet-banner />

        <nav class="tw-sticky tw-top-0 tw-z-50 tw-bg-white tw-shadow tw-text-gray-400">
            <!-- Primary Navigation Menu -->
            <div class="tw-mx-4">
                <div class="tw-flex tw-justify-between tw-h-16">
                    <div class="tw-flex tw-text-gray-600">
                        <!-- Logo -->
                        <div class="tw-flex tw-items-center tw-flex-shrink-0">
                            <a :href="route('dashboard')">
                                <jet-application-mark> </jet-application-mark>
                            </a>
                        </div>

                        <!-- Navigation Links -->
                        <div class="tw-hidden tw-space-x-8 lg:tw--my-px lg:tw-ml-10 lg:tw-flex">
                            <jet-nav-link :href="route('dashboard')" :active="route().current('dashboard')">
                                <i class="tw-mr-2 fas fa-home tw-text-gray-600"></i>Prueba
                            </jet-nav-link>
                        </div>
                        <div class="tw-hidden tw-space-x-8 lg:tw--my-px lg:tw-ml-10 lg:tw-flex" v-if="hasAnyPermission(['admin.index'])">
                            <jet-nav-link :href="route('Admin')" :active="route().current('Admin')">
                                <i class="tw-mr-2 fa-solid fa-user-secret tw-text-gray-600"></i>Administrador
                            </jet-nav-link>
                        </div>
                        <div class="tw-hidden tw-space-x-8 lg:tw--my-px lg:tw-ml-10 lg:tw-flex" v-if="hasAnyPermission(['admin.index', 'RecursosHumanos.index'])">
                            <jet-nav-link :href="route('RecursosHumanos')" :active="route().current('RecursosHumanos')">
                                <i class="tw-mr-2 fas fa-user-tie tw-text-gray-600"></i>Recursos Humanos
                            </jet-nav-link>
                        </div>
                        <div class="tw-hidden tw-space-x-8 lg:tw--my-px lg:tw-ml-10 lg:tw-flex" v-if="hasAnyPermission(['admin.index', 'Compras.index'])">
                            <jet-nav-link :href="route('Compras')" :active="route().current('Compras')">
                                    <i class="tw-mr-2 fas fa-business-time tw-text-gray-600"></i>Compras
                            </jet-nav-link>
                        </div>
                        <div class="tw-hidden tw-space-x-8 lg:tw--my-px lg:tw-ml-10 lg:tw-flex" v-if="hasAnyPermission(['admin.index', 'Almacen.index'])">
                            <jet-nav-link :href="route('Almacen')" :active="route().current('Almacen')">
                                <i class="tw-mr-2 fas fa-home tw-text-gray-600"></i>Almacen
                            </jet-nav-link>
                        </div>
                        <div class="tw-hidden tw-space-x-8 lg:tw--my-px lg:tw-ml-10 lg:tw-flex" v-if="hasAnyPermission(['admin.index', 'Contabilidad.index'])">
                            <jet-nav-link :href="route('Contabilidad')" :active="route().current('Contabilidad')">
                                <i class="tw-mr-2 fas fa-balance-scale tw-text-gray-600"></i>Contabilidad
                            </jet-nav-link>
                        </div>
                        <div class="tw-hidden tw-space-x-8 lg:tw--my-px lg:tw-ml-10 lg:tw-flex" v-if="hasAnyPermission(['admin.index', 'Supply.index'])">
                            <jet-nav-link :href="route('Supply')" :active="route().current('Supply')">
                                <i class="tw-mr-2 fas fa-warehouse tw-text-gray-600"></i>Supply
                            </jet-nav-link>
                        </div>
                        <div class="tw-hidden tw-space-x-8 lg:tw--my-px lg:tw-ml-10 lg:tw-flex">
                            <jet-nav-link :href="route('Sistemas')" :active="route().current('Sistemas')" v-if="hasAnyPermission(['Sistemas.index'])">
                                <i class="tw-mr-2 fa-solid fa-laptop-code tw-text-gray-600"></i>Sistemas
                            </jet-nav-link>
                        </div>
                        <div class="tw-hidden tw-space-x-8 lg:tw--my-px lg:tw-ml-10 lg:tw-flex"  v-if="hasAnyPermission(['admin.index', 'Produccion.index'])">
                            <jet-nav-link :href="route('Produccion')" :active="route().current('Produccion')">
                                <i class="tw-mr-2 fas fa-shipping-fast tw-text-gray-600"></i>Producción
                            </jet-nav-link>
                        </div>
                        <div class="tw-hidden tw-space-x-8 lg:tw--my-px lg:tw-ml-10 lg:tw-flex"  v-if="hasAnyPermission(['admin.index', 'Calidad.index'])">
                            <jet-nav-link :href="route('Calidad')" :active="route().current('Calidad')">
                                <i class="tw-mr-2 fas fa-vials tw-text-gray-600"></i>Calidad
                            </jet-nav-link>
                        </div>
                        <div class="tw-hidden tw-space-x-8 lg:tw--my-px lg:tw-ml-10 lg:tw-flex"  v-if="hasAnyPermission(['admin.index', 'Direccion.index'])">
                            <jet-nav-link :href="route('Direccion')" :active="route().current('Direccion')">
                                <i class="tw-mr-2 fas fa-landmark tw-text-gray-600"></i> Dirección
                            </jet-nav-link>
                        </div>
                    </div><!--- v-if="hasAnyPermission(['admin.index', 'Produccion.index', 'Sistemas.index',])" -->

                    <div class="tw-hidden lg:tw-flex lg:tw-items-center lg:tw-ml-6">
                        <!-- Settings Dropdown -->
                        <div class="tw-hidden lg:tw-flex lg:tw-items-center lg:tw-ml-6">
                            <div class="tw-relative">
                                <jet-dropdown align="tw-right" width="48">
                                    <template #trigger>
                                        <button v-if="$page.props.jetstream.managesProfilePhotos" class="tw-flex tw-text-sm tw-border-2 tw-border-transparent tw-rounded-full focus:tw-outline-none focus:tw-border-gray-300 tw-transition">
                                            <img class="tw-h-8 tw-w-8 tw-rounded-full tw-object-cover" :src="$page.props.user.profile_photo_url" :alt="$page.props.user.name" />
                                        </button>

                                        <span v-else class="tw-inline-flex tw-rounded-md">
                                            <button type="button" class="tw-inline-flex tw-items-center tw-px-3 tw-py-2 tw-border tw-border-transparent tw-text-sm tw-leading-4 tw-font-medium tw-rounded-md tw-text-gray-500 tw-bg-white hover:tw-text-gray-700 focus:tw-outline-none tw-transition">
                                                {{ $page.props.user.name }}

                                                <svg class="tw-ml-2 tw--mr-0.5 tw-h-4 tw-w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <!-- Account Management -->
                                        <div class="tw-block tw-px-4 tw-py-2 tw-text-xs tw-text-gray-400">
                                            Administración de la cuenta
                                        </div>

                                        <jet-dropdown-link :href="route('profile.show')">
                                            <i class="fas fa-user-circle"></i> Perfil
                                        </jet-dropdown-link>

                                        <div class="tw-border-t tw-border-gray-100"></div>

                                        <!-- Authentication -->
                                        <form @submit.prevent="logout">
                                            <jet-dropdown-link as="button">
                                                <i class="fas fa-sign-out-alt"></i> Salir
                                            </jet-dropdown-link>
                                        </form>
                                    </template>
                                </jet-dropdown>
                            </div>
                        </div>
                    </div>

                    <!-- Hamburger -->
                    <div class="tw--mr-2 tw-flex tw-items-center lg:tw-hidden">
                        <button @click="showingNavigationDropdown = ! showingNavigationDropdown" class="tw-inline-flex tw-items-center tw-justify-center tw-p-2 tw-rounded-md tw-text-gray-400 hover:tw-text-gray-500 hover:tw-bg-gray-100 focus:tw-outline-none focus:tw-bg-gray-100 focus:tw-text-gray-500 tw-transition">
                            <svg class="tw-h-6 tw-w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path :class="{'tw-hidden': showingNavigationDropdown, 'tw-inline-flex': ! showingNavigationDropdown }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                <path :class="{'tw-hidden': ! showingNavigationDropdown, 'tw-inline-flex': showingNavigationDropdown }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Responsive Navigation Menu -->
            <div :class="{'tw-block': showingNavigationDropdown, 'tw-hidden': ! showingNavigationDropdown}" class="tw-uppercase lg:tw-hidden">
                <div class="pt-2 pb-3 space-y-1">
                    <jet-responsive-nav-link :href="route('dashboard')" :active="route().current('dashboard')">
                        <i class="tw-mr-2 fas fa-home tw-text-gray-600"></i> INICIO
                    </jet-responsive-nav-link>
                </div>
                <div class="pt-2 pb-3 space-y-1" v-if="hasAnyPermission(['admin.index'])">
                    <jet-responsive-nav-link :href="route('Admin')" :active="route().current('Admin')">
                        <i class="tw-mr-2 fa-solid fa-user-secret tw-text-gray-600"></i> ADMINISTRADOR
                    </jet-responsive-nav-link>
                </div>
                <div class="pt-2 pb-3 space-y-1" v-if="hasAnyPermission(['admin.index', 'RecursosHumanos.index'])">
                    <jet-responsive-nav-link :href="route('RecursosHumanos')" :active="route().current('RecursosHumanos')">
                        <i class="tw-mr-2 fas fa-user-tie"></i> RECURSOS HUMANOS
                    </jet-responsive-nav-link>
                </div>
                <div class="pt-2 pb-3 space-y-1" v-if="hasAnyPermission(['admin.index', 'Compras.index'])">
                    <jet-responsive-nav-link :href="route('Compras')" :active="route().current('AlComprasmacen')">
                        <i class="tw-mr-2 fas fa-business-time"></i> COMPRAS
                    </jet-responsive-nav-link>
                </div>
                <div class="pt-2 pb-3 space-y-1" v-if="hasAnyPermission(['admin.index', 'Almacen.index'])">
                    <jet-responsive-nav-link :href="route('Almacen')" :active="route().current('Almacen')">
                        <i class="tw-mr-2 fas fa-warehouse"></i> ALMACÉN
                    </jet-responsive-nav-link>
                </div>
                <div class="pt-2 pb-3 space-y-1" v-if="hasAnyPermission(['admin.index', 'Contabilidad.index'])">
                    <jet-responsive-nav-link :href="route('Contabilidad')" :active="route().current('Contabilidad')">
                        <i class="tw-mr-2 fas fa-balance-scale tw-text-gray-600"></i> CONTABILIDAD
                    </jet-responsive-nav-link>
                </div>
                <div class="pt-2 pb-3 space-y-1" v-if="hasAnyPermission(['admin.index', 'Supply.index'])">
                    <jet-responsive-nav-link :href="route('Supply')" :active="route().current('Supply')">
                        <i class="tw-mr-2 fas fa-home tw-text-gray-600"></i> SUPPLY
                    </jet-responsive-nav-link>
                </div>
                <div class="pt-2 pb-3 space-y-1">
                    <jet-responsive-nav-link :href="route('Sistemas')" :active="route().current('Sistemas')">
                        <i class="tw-mr-2 fa-solid fa-laptop-code tw-text-gray-600"></i> SISTEMAS
                    </jet-responsive-nav-link>
                </div>
                <div class="pt-2 pb-3 space-y-1" v-if="hasAnyPermission(['admin.index', 'Produccion.index'])">
                    <jet-responsive-nav-link :href="route('Produccion')" :active="route().current('Produccion')">
                        <i class="tw-mr-2 fas fa-home tw-text-gray-600"></i> PRODUCCIÓN
                    </jet-responsive-nav-link>
                </div>
                <div class="pt-2 pb-3 space-y-1" v-if="hasAnyPermission(['admin.index', 'Calidad.index'])">
                    <jet-responsive-nav-link :href="route('Calidad')" :active="route().current('Calidad')">
                        <i class="tw-mr-2 fas fa-vials tw-text-gray-600"></i>Calidad
                    </jet-responsive-nav-link>
                </div>
                <div class="pt-2 pb-3 space-y-1" v-if="hasAnyPermission(['admin.index', 'Direccion.index', 'Direccion.index'])">
                    <jet-responsive-nav-link :href="route('Direccion')" :active="route().current('Direccion')">
                        <i class="tw-mr-2 fas fa-landmark tw-text-gray-600"></i> DIRECCION
                    </jet-responsive-nav-link>
                </div>

                <!-- Responsive Settings Options -->
                <div class="tw-pt-4 tw-pb-1 tw-border-t tw-border-gray-200">
                    <div class="tw-flex tw-items-center tw-px-4">
                        <div v-if="$page.props.jetstream.managesProfilePhotos" class="tw-flex-shrink-0 tw-mr-3" >
                            <img class="tw-h-10 tw-w-10 tw-rounded-full tw-object-cover" :src="$page.props.user.profile_photo_url" :alt="$page.props.user.name" />
                        </div>

                        <div>
                            <div class="tw-font-medium tw-text-base tw-text-gray-800">{{ $page.props.user.name }}</div>
                            <div class="tw-font-medium tw-text-sm tw-text-gray-500">{{ $page.props.user.email }}</div>
                        </div>
                    </div>

                    <div class="tw-mt-3 tw-space-y-1">
                        <jet-responsive-nav-link :href="route('profile.show')" :active="route().current('profile.show')">
                            <i class="fas fa-user-circle"></i> Perfil
                        </jet-responsive-nav-link>

                        <!-- Authentication -->
                        <form method="POST" @submit.prevent="logout">
                            <jet-responsive-nav-link as="button">
                                <i class="fas fa-sign-out-alt"></i> Salir
                            </jet-responsive-nav-link>
                        </form>

                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Heading -->
        <header v-if="$slots.header">
                <slot name="header"></slot>
        </header>

        <!-- Page Content -->
        <main>
            <slot></slot>
        </main>
    </div>
</template>

<script>
    import JetApplicationMark from '@/Jetstream/ApplicationMark'
    import JetBanner from '@/Jetstream/Banner'
    import JetDropdown from '@/Jetstream/Dropdown'
    import JetDropdownLink from '@/Jetstream/DropdownLink'
    import JetNavLink from '@/Jetstream/NavLink'
    import JetResponsiveNavLink from '@/Jetstream/ResponsiveNavLink'

    export default {
        components: {
            JetApplicationMark,
            JetBanner,
            JetDropdown,
            JetDropdownLink,
            JetNavLink,
            JetResponsiveNavLink,
        },

        data() {
            return {
                showingNavigationDropdown: false,

            }
        },
        methods: {
            switchToTeam(team) {
                this.$inertia.put(route('current-team.update'), {
                    'team_id': team.id
                }, {
                    preserveState: false
                })
            },

            logout() {
                this.$inertia.post(route('logout'));
            },
        }
    }
</script>
