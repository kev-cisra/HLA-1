<template>
    <jet-form-section @submitted="updateProfileInformation">
        <template #title>
           Información del perfil
        </template>

        <template #description>
            Actualice la información de perfil y la dirección de correo electrónico de su cuenta.
        </template>

        <template #form>
            <!-- Profile Photo -->
            <div class="tw-col-span-6 sm:tw-col-span-4" v-if="$page.props.jetstream.managesProfilePhotos">
                <!-- Profile Photo File Input -->
                <input type="file" class="hidden"
                            ref="photo"
                            @change="updatePhotoPreview">

                <jet-label for="photo" value="Foto" />

                <!-- Current Profile Photo -->
                <div class="tw-mt-2" v-show="! photoPreview">
                    <img :src="user.profile_photo_url" :alt="user.name" class="tw-rounded-full tw-h-20 tw-w-20 tw-object-cover">
                </div>

                <!-- New Profile Photo Preview -->
                <div class="tw-mt-2" v-show="photoPreview">
                    <span class="tw-block tw-rounded-full tw-w-20 tw-h-20"
                          :style="'background-size: cover; background-repeat: no-repeat; background-position: center center; background-image: url(\'' + photoPreview + '\');'">
                    </span>
                </div>

                <jet-secondary-button class="tw-mt-2 tw-mr-2" type="button" @click.prevent="selectNewPhoto">
                    Seleccione una nueva foto
                </jet-secondary-button>

                <jet-secondary-button type="button" class="tw-mt-2" @click.prevent="deletePhoto" v-if="user.profile_photo_path">
                    Quitar foto
                </jet-secondary-button>

                <jet-input-error :message="form.errors.photo" class="tw-mt-2" />
            </div>

            <!-- Name -->
            <div class="tw-col-span-6 sm:tw-col-span-4">
                <jet-label for="name" value="Nombre de Usuario" />
                <jet-input id="name" type="text" class="tw-mt-1 tw-block tw-w-full" v-model="form.name" autocomplete="name" />
                <jet-input-error :message="form.errors.name" class="tw-mt-2" />
            </div>

            <!-- Email -->
<!--             <div class="tw-col-span-6 sm:tw-col-span-4">
                <jet-label for="email" value="Email" />
                <jet-input id="email" type="email" class="tw-mt-1 tw-block tw-w-full" v-model="form.email" />
                <jet-input-error :message="form.errors.email" class="tw-mt-2" />
            </div> -->
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
    import JetButton from '@/Jetstream/Button'
    import JetFormSection from '@/Jetstream/FormSection'
    import JetInput from '@/Jetstream/Input'
    import JetInputError from '@/Jetstream/InputError'
    import JetLabel from '@/Jetstream/Label'
    import JetActionMessage from '@/Jetstream/ActionMessage'
    import JetSecondaryButton from '@/Jetstream/SecondaryButton'

    export default {
        components: {
            JetActionMessage,
            JetButton,
            JetFormSection,
            JetInput,
            JetInputError,
            JetLabel,
            JetSecondaryButton,
        },

        props: ['user'],

        data() {
            return {
                form: this.$inertia.form({
                    _method: 'PUT',
                    name: this.user.name,
                    email: this.user.email,
                    photo: null,
                }),

                photoPreview: null,
            }
        },

        methods: {
            updateProfileInformation() {
                if (this.$refs.photo) {
                    this.form.photo = this.$refs.photo.files[0]
                }

                this.form.post(route('user-profile-information.update'), {
                    errorBag: 'updateProfileInformation',
                    preserveScroll: true,
                    onSuccess: () => (this.clearPhotoFileInput()),
                });
            },

            selectNewPhoto() {
                this.$refs.photo.click();
            },

            updatePhotoPreview() {
                const photo = this.$refs.photo.files[0];

                if (! photo) return;

                const reader = new FileReader();

                reader.onload = (e) => {
                    this.photoPreview = e.target.result;
                };

                reader.readAsDataURL(photo);
            },

            deletePhoto() {
                this.$inertia.delete(route('current-user-photo.destroy'), {
                    preserveScroll: true,
                    onSuccess: () => {
                        this.photoPreview = null;
                        this.clearPhotoFileInput();
                    },
                });
            },

            clearPhotoFileInput() {
                if (this.$refs.photo?.value) {
                    this.$refs.photo.value = null;
                }
            },
        },
    }
</script>
