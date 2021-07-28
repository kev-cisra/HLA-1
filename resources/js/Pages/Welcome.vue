<template>
    <div class="flex-container">
        <div class="flex-item-left fullHeight">
            <div id="carouselExampleDark" class="carousel carousel-dark slide carousel-fade fullHeight" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="1" aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="2" aria-label="Slide 3"></button>
                </div>
                <div class="carousel-inner fullHeight">
                    <div class="h-full carousel-item active" data-bs-interval="3500">
                    <img src="img/anuncios/Plantilla3.png" class="d-block w-100 fullHeight" alt="...">
                    </div>
                    <div class="carousel-item fullHeight" data-bs-interval="3500">
                    <img src="img/anuncios/Plantilla2.png" class="d-block w-100 fullHeight" alt="...">
                    </div>
                    <div class="carousel-item fullHeight" data-bs-interval="3500">
                    <img src="img/anuncios/Plantilla1.png" class="d-block w-100 fullHeight" alt="...">
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
        <div class="flex-item-right fullHeight" name="loginXXX">
            <jet-authentication-card>
                <template #logo>
                    <img class="p-2" src="img/logo.png" alt="Workflow">
                </template>

                <jet-validation-errors class="tw-mb-4" />

                <div v-if="status" class="tw-mb-4 tw-text-sm tw-font-medium tw-text-green-600">
                    {{ status }}
                </div>

                <form @submit.prevent="submit">
                    <div>
                        <jet-label for="IdEmp" value="Num. Control" />
                        <jet-input id="IdEmp" type="text" class="tw-block tw-w-full tw-mt-1" v-model="form.IdEmp" required autofocus />
                    </div>

                    <div class="tw-mt-4">
                        <jet-label for="password" value="Password" />
                        <jet-input id="password" type="password" class="tw-block tw-w-full tw-mt-1" v-model="form.password" required autocomplete="current-password" />
                    </div>

                    <div class="mt-4 tw-flex tw-items-center tw-justify-end">
                        <button type="submit"
                        class="tw-relative tw-flex tw-justify-center tw-w-full tw-px-4 tw-py-2 tw-text-sm tw-font-medium tw-text-white tw-bg-indigo-600 tw-border tw-border-transparent tw-rounded-md tw-group hover:tw-bg-indigo-700 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-offset-2 focus:tw-ring-indigo-500"
                        :disabled="form.processing">
                            <span class="tw-absolute tw-inset-y-0 tw-left-0 tw-flex tw-items-center tw-pl-3">
                                <svg class="tw-h-5 tw-text-indigo-500 tw-w-5 group-hover:tw-text-indigo-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                                </svg>
                            </span>
                            Inicia Sesión
                        </button>
                    </div>
                </form>

                <a href="#loginXXX" class="btn-flotante">+</a>
            </jet-authentication-card>
        </div>
    </div>
</template>

<script>
    import JetAuthenticationCard from '@/Jetstream/AuthenticationCard'
    import JetAuthenticationCardLogo from '@/Jetstream/AuthenticationCardLogo'
    import JetButton from '@/Jetstream/Button'
    import JetInput from '@/Jetstream/Input'
    import JetCheckbox from '@/Jetstream/Checkbox'
    import JetLabel from '@/Jetstream/Label'
    import JetValidationErrors from '@/Jetstream/ValidationErrors'

    export default {
        components: {
            JetAuthenticationCard,
            JetAuthenticationCardLogo,
            JetButton,
            JetInput,
            JetCheckbox,
            JetLabel,
            JetValidationErrors
        },

        props: {
            canLogin: Boolean,
            canRegister: Boolean,
            laravelVersion: String,
            phpVersion: String,
            canResetPassword: Boolean,
            status: String
        },

        data() {
            return {
                form: this.$inertia.form({
                    IdEmp: '',
                    password: '',
                    remember: false
                })
            }
        },

        methods: {
            submit() {
                this.form
                    .transform(data => ({
                        ... data,
                        remember: this.form.remember ? 'on' : ''
                    }))
                    .post(this.route('login'), {
                        onFinish: () => this.form.reset('password'),
                    })
            }
        }
    }
</script>
