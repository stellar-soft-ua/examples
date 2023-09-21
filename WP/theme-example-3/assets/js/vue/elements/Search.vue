<template>
    <transition name="modal">
        <div class="modal fullscreen" tabindex="-1" role="dialog" v-if="showModal" @keydown.esc="hide">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header filled">
                        <div :class="$wp.container">
                            <theme-cross class="float-right" @click="hide()"></theme-cross>
                            <span class="modal-title h1">
                                {{ i18n.t('search.title') }}
                            </span>
                            <div class="row">
                                <div :class="$wp.columns" class="d-flex justify-content-between">
                                    <form class="form-inline mt-2 mt-md-0 w-100" @submit="doSearch">
                                        <div class="input-group input-group-transparent flex-grow-1 align-items-center">
                                            <input ref="input" type="text" v-model="query" class="form-control"
                                                   :placeholder="i18n.t('search.placeholder')">
                                            <div class="input-group-append">
                                                <theme-icon-search @click="doSearch"></theme-icon-search>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-body">
                        <div :class="$wp.container">
                            <div class="row">
                                <div :class="$wp.columns">
                                    <div v-if="results" class="h4">{{ i18n.t('search.results') }}</div>

                                    <div v-if="isSearching" class="spinner">
                                        <theme-spinner></theme-spinner>
                                    </div>

                                    <div v-else-if="results && results.length > 0">
                                        <div class="results children-gutter-y">
                                            <div class="result" v-for="result of results">
                                                <a :href="result.url">
                                                    <span>{{ result.title }}</span>
                                                </a>
                                                <span v-html="ellipsis(result.excerpt, 150)"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div v-else-if="results && results.length === 0">
                                        <span>{{ i18n.t('search.no_results') }}</span>
                                    </div>

                                    <div v-else-if="error">
                                        {{ error }}
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </transition>
</template>

<script>
    import {api} from '../../api';

    export default {
        data: () => ({
            showModal: false,
            isSearching: false,
            results: null,
            error: null,
            query: null
        }),
        methods: {
            show() {
                this.showModal = true;
                document.body.classList.add('modal-open');
                this.$nextTick(() => this.$refs.input.focus());
            },
            hide() {
                this.showModal = false;
                document.body.classList.remove('modal-open');
            },
            doSearch(e) {
                e.preventDefault();

                this.isSearching = true;
                this.results = null;

                api.search({
                    search: this.query,
                    post_type: ['page', 'post', 'project', 'event'].join(','),
                    per_page: 15
                })
                    .then(res => {
                        this.results = res.data;
                    })
                    .catch(err => {
                        this.results = null;
                        this.error = err && err.data.message || null;
                    })
                    .then(() => {
                        this.isSearching = false;
                    });

            }
        }
    };
</script>

<style lang="scss" scoped>
    .modal {
        .modal-header {
            padding-bottom: 50px !important;
        }

        .modal-title {
            margin-bottom: 100px !important;

            @include media-breakpoint-down(lg) {
                margin-bottom: 70px !important;
            }

            @include media-breakpoint-down(sm) {
                margin-bottom: 50px !important;
            }
        }

        .modal-body {
            padding-top: 50px !important;
        }

        .spinner {
            width: 100%;
            text-align: center;
        }

        .result {
            display: flex;
            flex-direction: column;
        }

        .result > a {
            text-decoration: underline;

            &:hover {
                color: $primary;
            }
        }

        theme-icon-search::v-deep {
            margin-top: -5px;
        }
    }
</style>
