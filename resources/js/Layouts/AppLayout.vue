<template>
    <div>
        <jet-banner />

        <div class="tw-min-h-screen tw-bg-gray-100">
            <nav class="tw-sticky tw-top-0 tw-z-50 tw-bg-white tw-shadow tw-text-gray-400">
                <!-- Primary Navigation Menu -->
                <div class="tw-w-full twpx-4 sm:tw-px-4 md:tw-px-2 lg:tw-px-8">
                    <div class="tw-flex tw-justify-between tw-h-16">
                        <div class="tw-flex tw-text-gray-600">
                            <!-- Logo -->
                            <div class="tw-flex tw-items-center tw-flex-shrink-0">
                                <a :href="route('dashboard')" >
                                    <img src="img/logo.png" class="tw-mt-2"/>
                                </a>
                            </div>

                            <!-- Navigation Links -->
                            <div class="tw-hidden tw-space-x-8 sm:tw--my-px sm:tw-ml-10 sm:tw-flex">
                                <jet-nav-link :href="route('dashboard')" :active="route().current('dashboard')">
                                    <i class="tw-mr-2 fas fa-home tw-text-gray-600"></i>Inicio
                                </jet-nav-link>
                            </div>
                        </div>

                        <div class="tw-hidden sm:tw-flex sm:tw-items-center sm:tw-ml-6">
                            <!-- Settings Dropdown -->
                            <div class="tw-hidden sm:tw-flex sm:tw-items-center sm:tw-ml-6">
                                <div class="tw-relative tw-ml-3">
                                    <jet-dropdown align="right" width="48">
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
                                                Perfil
                                            </jet-dropdown-link>

                                            <div class="tw-border-t tw-border-gray-100"></div>

                                            <!-- Authentication -->
                                            <form @submit.prevent="logout">
                                                <jet-dropdown-link as="button">
                                                    Salir
                                                </jet-dropdown-link>
                                            </form>
                                        </template>
                                    </jet-dropdown>
                                </div>
                            </div>
                        </div>

                        <!-- Hamburger -->
                        <div class="tw--mr-2 tw-flex tw-items-center sm:tw-hidden">
                            <button @click="showingNavigationDropdown = ! showingNavigationDropdown" class="tw-inline-flex tw-items-center tw-justify-center tw-p-2 tw-rounded-md tw-text-gray-400 hover:tw-text-gray-500 hover:tw-bg-gray-100 focus:tw-outline-none focus:tw-bg-gray-100 focus:tw-text-gray-500 tw-transition">
                                <svg class="tw-h-6 tw-w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path :class="{'hidden': showingNavigationDropdown, 'tw-inline-flex': ! showingNavigationDropdown }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                    <path :class="{'hidden': ! showingNavigationDropdown, 'tw-inline-flex': showingNavigationDropdown }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div :class="{'block': showingNavigationDropdown, 'hidden': ! showingNavigationDropdown}" class="sm:tw-hidden">
                    <div class="pt-2 pb-3 space-y-1">
                        <jet-responsive-nav-link :href="route('dashboard')" :active="route().current('dashboard')">
                            Dashboard
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
                                Profile
                            </jet-responsive-nav-link>

                            <jet-responsive-nav-link :href="route('api-tokens.index')" :active="route().current('api-tokens.index')" v-if="$page.props.jetstream.hasApiFeatures">
                                API Tokens
                            </jet-responsive-nav-link>

                            <!-- Authentication -->
                            <form method="POST" @submit.prevent="logout">
                                <jet-responsive-nav-link as="button">
                                    Log Out
                                </jet-responsive-nav-link>
                            </form>

                            <!-- Team Management -->
                            <template v-if="$page.props.jetstream.hasTeamFeatures">
                                <div class="tw-border-t tw-border-gray-200"></div>

                                <div class="tw-block tw-px-4 tw-py-2 tw-text-xs tw-text-gray-400">
                                    Manage Team
                                </div>

                                <!-- Team Settings -->
                                <jet-responsive-nav-link :href="route('teams.show', $page.props.user.current_team)" :active="route().current('teams.show')">
                                    Team Settings
                                </jet-responsive-nav-link>

                                <jet-responsive-nav-link :href="route('teams.create')" :active="route().current('teams.create')" v-if="$page.props.jetstream.canCreateTeams">
                                    Create New Team
                                </jet-responsive-nav-link>

                                <div class="tw-border-t tw-border-gray-200"></div>

                                <!-- Team Switcher -->
                                <div class="tw-block tw-px-4 tw-py-2 tw-text-xs tw-text-gray-400">
                                    Switch Teams
                                </div>

                                <template v-for="team in $page.props.user.all_teams" :key="team.id">
                                    <form @submit.prevent="switchToTeam(team)">
                                        <jet-responsive-nav-link as="button">
                                            <div class="tw-flex tw-items-center">
                                                <svg v-if="team.id == $page.props.user.current_team_id" class="tw-mr-2 tw-h-5 tw-w-5 tw-text-green-400" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                <div>{{ team.name }}</div>
                                            </div>
                                        </jet-responsive-nav-link>
                                    </form>
                                </template>
                            </template>
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
