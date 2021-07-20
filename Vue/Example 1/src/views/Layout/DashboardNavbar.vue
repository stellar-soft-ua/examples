<template>
    <base-nav
            container-classes="container-fluid"
            class="navbar-top border-bottom navbar-expand"
            :class="{'bg-primary neutral navbar-dark': type === 'default'}"
    >
        <!-- Navbar links -->
        <ul class="navbar-nav align-items-center ml-none ml-xl-auto flex-grow-1 flex-xl-grow-0">
            <li class="nav-item d-xl-none">
                <!-- Sidenav toggler -->
                <div class="pr-3 sidenav-toggler"
                     :class="{active: $sidebar.showSidebar, 'sidenav-toggler-dark': type === 'default', 'sidenav-toggler-light': type === 'light'}"
                     @click="toggleSidebar">
                    <div class="sidenav-toggler-inner">
                        <i class="sidenav-toggler-line"></i>
                        <i class="sidenav-toggler-line"></i>
                        <i class="sidenav-toggler-line"></i>
                    </div>
                </div>
            </li>
        </ul>
        <ul class="navbar-nav align-items-center ml-auto ml-md-0">
            <base-dropdown menu-on-right
               class="nav-item"
               tag="li"
               title-tag="a"
               title-classes="nav-link pr-0">
                <template>
                    <div class="dropdown-header noti-title">
                        <h6 class="text-overflow m-0">Welcome!</h6>
                    </div>

                    <router-link to="/settings" class="dropdown-item">
                        <i class="ni ni-settings-gear-65"></i>
                        <span>Settings</span>
                    </router-link>

                    <div class="dropdown-divider"></div>

                    <a @click.prevent="logout" class="dropdown-item">
                        <i class="ni ni-user-run"></i>
                        <span>Logout</span>
                    </a>
                </template>
            </base-dropdown>
        </ul>
    </base-nav>
</template>

<script>
    import { BaseNav } from '@/components';

    export default {
        components: {
            BaseNav
        },
        props: {
            type: {
                type: String,
                default: 'default', // default|light
                description: 'Look of the dashboard navbar. Default (Green) or light (gray)'
            }
        },
        data() {
            return {

            };
        },
        methods: {
            toggleSidebar() {
                this.$sidebar.displaySidebar(!this.$sidebar.showSidebar);
            },
            logout() {
                this.showLoading();

                this.$store.dispatch('user/logout').then((response) => {
                    this.$router.push('/login');
                    this.hideLoading();
                }).catch((error) => {
                    this.hideLoading();
                });
            }
        }
    };
</script>
