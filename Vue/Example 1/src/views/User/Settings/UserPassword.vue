<template>
    <div class="card mb-4">
        <div class="card-header">
            <h3 class="mb-0">Password</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <validation-observer v-slot="{handleSubmit}" ref="formValidator">
                        <form role="form" @submit.prevent="handleSubmit(onSubmit)">
                            <base-input class="mb-3"
                                        prepend-icon="ni ni-lock-circle-open"
                                        label="Current password"
                                        placeholder="Current password"
                                        type="password"
                                        name="Current password"
                                        vid="password"
                                        :rules="'required:true'"
                                        v-model="password.current">
                            </base-input>

                            <base-input class="mb-3"
                                        prepend-icon="ni ni-lock-circle-open"
                                        label="New password"
                                        placeholder="New password"
                                        type="password"
                                        name="New password"
                                        vid="new_password"
                                        :rules="'required:true|min:10|password'"
                                        v-model="password.newPassword">
                            </base-input>

                            <base-input class="mb-3"
                                        prepend-icon="ni ni-lock-circle-open"
                                        label="Confirm new password"
                                        placeholder="Confirm new password"
                                        type="password"
                                        name="Confirm new password"
                                        :rules="{required: true, min: 10, confirmed: 'new_password'}"
                                        v-model="password.passwordConfirmation"
                                        data-vv-as="new_password">
                            </base-input>

                            <div class="text-left">
                                <base-button type="primary" native-type="submit" class="my-4">Change password</base-button>
                            </div>
                        </form>
                    </validation-observer>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { Select, Option } from 'element-ui'
    import { mapGetters } from 'vuex';

    export default {
        components: {
            [Select.name]: Select,
            [Option.name]: Option,
        },
        data() {
            return {
                password: {
                    current: '',
                    newPassword: '',
                    passwordConfirmation: '',
                },
            }
        },
        computed: {
            ...mapGetters('user', [
                'getUserSettings'
            ]),
        },
        methods: {
            onSubmit() {
                this.showLoading();

                this.$store.dispatch('user/changePassword', this.password).then((response) => {
                    this.hideLoading();
                    this.resetData();
                    this.notifyVue('Password successfully changed.', 'success');
                }).catch((error) => {
                    this.hideLoading();
                });
            },
            notifyVue(message, type = 'default') {
                this.$notify({
                    message: message,
                    timeout: 5000,
                    icon: 'ni ni-bell-55',
                    type: type
                });
            },
            resetData() {
                Object.assign(this.$data, this.$options.data());
                this.$refs.formValidator.reset();
            }
        }
    };
</script>