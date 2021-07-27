<template>
    <jet-authentication-card>
        <template #logo>
            <jet-authentication-card-logo />
        </template>

        <jet-validation-errors class="tw-mb-4" />

        <form @submit.prevent="submit">
            <div>
                <jet-label for="IdEmp" value="IdEmp" />
                <jet-input id="IdEmp" type="text" class="tw-block tw-w-full tw-mt-1" v-model="form.IdEmp" required autofocus autocomplete="IdEmp" />
            </div>

            <div>
                <jet-label for="name" value="Name" />
                <jet-input id="name" type="text" class="tw-block tw-w-full tw-mt-1" v-model="form.name" required autofocus autocomplete="name" />
            </div>

            <div>
                <jet-label for="Area" value="Area" />
                <jet-input id="Area" type="text" class="tw-block tw-w-full tw-mt-1" v-model="form.Area" required autofocus autocomplete="Area" />
            </div>

            <div class="tw-mt-4">
                <jet-label for="email" value="Email" />
                <jet-input id="email" type="email" class="tw-block tw-w-full tw-mt-1" v-model="form.email" required />
            </div>

            <div class="tw-mt-4">
                <jet-label for="password" value="Password" />
                <jet-input id="password" type="password" class="tw-block tw-w-full tw-mt-1" v-model="form.password" required autocomplete="new-password" />
            </div>

            <div class="tw-mt-4">
                <jet-label for="password_confirmation" value="Confirm Password" />
                <jet-input id="password_confirmation" type="password" class="tw-block tw-w-full tw-mt-1" v-model="form.password_confirmation" required autocomplete="new-password" />
            </div>

            <div class="tw-mt-4" v-if="$page.props.jetstream.hasTermsAndPrivacyPolicyFeature">
                <jet-label for="terms">
                    <div class="tw-flex tw-items-center">
                        <jet-checkbox name="terms" id="terms" v-model:checked="form.terms" />

                        <div class="tw-ml-2">
                            I agree to the <a target="_blank" :href="route('terms.show')" class="tw-text-sm tw-text-gray-600 tw-underline hover:tw-text-gray-900">Terms of Service</a> and <a target="_blank" :href="route('policy.show')" class="text-sm text-gray-600 underline hover:text-gray-900">Privacy Policy</a>
                        </div>
                    </div>
                </jet-label>
            </div>

            <div class="tw-flex tw-items-center tw-justify-end mt-4">
                <inertia-link :href="route('login')" class="tw-text-sm tw-text-gray-600 tw-underline hover:tw-text-gray-900">
                    Already registered?
                </inertia-link>

                <jet-button class="tw-ml-4" :class="{ 'tw-opacity-25': form.processing }" :disabled="form.processing">
                    Register
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
    import JetCheckbox from "@/Jetstream/Checkbox";
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

        data() {
            return {
                form: this.$inertia.form({
                    IdEmp: '',
                    Area: '',
                    name: '',
                    email: '',
                    password: '',
                    password_confirmation: '',
                    terms: false,
                })
            }
        },

        methods: {
            submit() {
                this.form.post(this.route('register'), {
                    onFinish: () => this.form.reset('password', 'password_confirmation'),
                })
            }
        }
    }
</script>
