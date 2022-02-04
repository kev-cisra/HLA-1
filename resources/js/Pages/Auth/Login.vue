<template>
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
                <jet-label for="IdEmp" value="Número de Control" />
                <jet-input id="IdEmp" type="text" class="tw-block tw-w-full tw-mt-1" v-model="form.IdEmp" required autofocus />
            </div>

            <div class="tw-mt-4">
                <jet-label for="password" value="Contraseña" />
                <jet-input id="password" type="password" class="tw-block tw-w-full tw-mt-1" v-model="form.password" required autocomplete="current-password" />
            </div>

            <div class="tw-mt-4">
                <jet-label for="empresa" value="Empresa" />
                <select id="empresa" v-model="form.Empresa" required class="InputSelect">
                    <option v-for="emp in Empresas" :key="emp" :value="emp.Empresa">{{emp.Empresa}}</option>
                </select>
            </div>

            <div class="mt-4 tw-flex tw-items-center tw-justify-end">

                <jet-button class="tw-ml-4" :class="{ 'tw-opacity-25': form.processing }" :disabled="form.processing">
                    Entrar
                </jet-button>
            </div>
        </form>
    </jet-authentication-card>
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
            canResetPassword: Boolean,
            status: String
        },

        data() {
            return {
                form: this.$inertia.form({
                    IdEmp: '',
                    password: '',
                    Empresa: '',
                    remember: false
                }),
                Empresas: [],
            }
        },

        mounted() {
            this.conEmpre();
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
            },
            conEmpre() {
                axios.get('General/ConEmpre').then(eve => {this.Empresas = eve.data})
            }
        }
    }
</script>
