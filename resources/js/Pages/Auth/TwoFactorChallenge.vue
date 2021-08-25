<template>
    <jet-authentication-card>
        <template #logo>
            <jet-authentication-card-logo />
        </template>

        <div class="tw-mb-4 tw-text-sm tw-text-gray-600">
            <template v-if="! recovery">
                Confirme el acceso a su cuenta ingresando el código de autenticación proporcionado por su aplicación de autenticación.
            </template>

            <template v-else>
                Confirme el acceso a su cuenta ingresando uno de sus códigos de recuperación de emergencia.
            </template>
        </div>

        <jet-validation-errors class="tw-mb-4" />

        <form @submit.prevent="submit">
            <div v-if="! recovery">
                <jet-label for="code" value="Code" />
                <jet-input ref="code" id="code" type="text" inputmode="numeric" class="tw-mt-1 tw-block tw-w-full" v-model="form.code" autofocus autocomplete="one-time-code" />
            </div>

            <div v-else>
                <jet-label for="recovery_code" value="Recovery Code" />
                <jet-input ref="recovery_code" id="recovery_code" type="text" class="tw-mt-1 tw-block tw-w-full" v-model="form.recovery_code" autocomplete="one-time-code" />
            </div>

            <div class="mt-4 tw-flex tw-items-center tw-justify-end">
                <button type="button" class="tw-text-sm tw-text-gray-600 hover:tw-text-gray-900 tw-underline tw-cursor-pointer" @click.prevent="toggleRecovery">
                    <template v-if="! recovery">
                        Usa un código de recuperación
                    </template>

                    <template v-else>
                        Usa un código de autenticación
                    </template>
                </button>

                <jet-button class="tw-ml-4" :class="{ 'tw-opacity-25': form.processing }" :disabled="form.processing">
                    Iniciar sesión
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
    import JetLabel from '@/Jetstream/Label'
    import JetValidationErrors from '@/Jetstream/ValidationErrors'

    export default {
        components: {
            JetAuthenticationCard,
            JetAuthenticationCardLogo,
            JetButton,
            JetInput,
            JetLabel,
            JetValidationErrors,
        },

        data() {
            return {
                recovery: false,
                form: this.$inertia.form({
                    code: '',
                    recovery_code: '',
                })
            }
        },

        methods: {
            toggleRecovery() {
                this.recovery ^= true

                this.$nextTick(() => {
                    if (this.recovery) {
                        this.$refs.recovery_code.focus()
                        this.form.code = '';
                    } else {
                        this.$refs.code.focus()
                        this.form.recovery_code = ''
                    }
                })
            },

            submit() {
                this.form.post(this.route('two-factor.login'))
            }
        }
    }
</script>
