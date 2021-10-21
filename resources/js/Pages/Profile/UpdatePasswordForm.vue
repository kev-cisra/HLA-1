<template>
    <jet-form-section @submitted="updatePassword">
        <template #title>
            Actualiza contraseña
        </template>

        <template #description>
            Asegúrese de que su cuenta esté usando una contraseña larga y aleatoria para mantenerse seguro.
        </template>

        <template #form>
            <div class="tw-col-span-6 sm:tw-col-span-4">
                <jet-label for="current_password" value="Contraseña actual" />
                <jet-input id="current_password" type="password" class="w-full tw-mt-1 tw-block" v-model="form.current_password" ref="current_password" autocomplete="current-password" />
                <jet-input-error :message="form.errors.current_password" class="mt-2" />
            </div>

            <div class="tw-col-span-6 sm:tw-col-span-4">
                <jet-label for="password" value="Nueva contraseña" />
                <jet-input id="password" type="password" class="tw-mt-1 tw-block tw-w-full" v-model="form.password" ref="password" autocomplete="new-password" />
                <jet-input-error :message="form.errors.password" class="mt-2" />
            </div>

            <div class="tw-col-span-6 sm:tw-col-span-4">
                <jet-label for="password_confirmation" value="confirmar Contraseña" />
                <jet-input id="password_confirmation" type="password" class="tw-mt-1 tw-block tw-w-full" v-model="form.password_confirmation" autocomplete="new-password" />
                <jet-input-error :message="form.errors.password_confirmation" class="tw-mt-2" />
            </div>
        </template>

        <template #actions>
            <jet-action-message :on="form.recentlySuccessful" class="tw-mr-3">
                Salvado.
            </jet-action-message>

            <jet-button :class="{ 'tw-opacity-25': form.processing }" :disabled="form.processing">
                Guardar
            </jet-button>
        </template>
    </jet-form-section>
</template>

<script>
    import JetActionMessage from '@/Jetstream/ActionMessage'
    import JetButton from '@/Jetstream/Button'
    import JetFormSection from '@/Jetstream/FormSection'
    import JetInput from '@/Jetstream/Input'
    import JetInputError from '@/Jetstream/InputError'
    import JetLabel from '@/Jetstream/Label'

    export default {
        components: {
            JetActionMessage,
            JetButton,
            JetFormSection,
            JetInput,
            JetInputError,
            JetLabel,
        },

        data() {
            return {
                form: this.$inertia.form({
                    current_password: '',
                    password: '',
                    password_confirmation: '',
                }),
            }
        },

        methods: {
            updatePassword() {
                this.form.put(route('user-password.update'), {
                    errorBag: 'updatePassword',
                    preserveScroll: true,
                    onSuccess: () => this.form.reset(),
                    onError: () => {
                        if (this.form.errors.password) {
                            this.form.reset('password', 'password_confirmation')
                            this.$refs.password.focus()
                        }

                        if (this.form.errors.current_password) {
                            this.form.reset('current_password')
                            this.$refs.current_password.focus()
                        }
                    }
                })
            },
        },
    }
</script>
