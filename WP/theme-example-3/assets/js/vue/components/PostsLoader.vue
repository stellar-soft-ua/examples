<template>
    <div class="theme--posts-loader">
        <slot name="default" v-bind="{posts, fetching, fetched, page, totalPages, fetchMore, fetchButtonDisabled, canFetchMore, trimWords}">
            Default Slot
        </slot>
    </div>
</template>

<script>
    import {api} from '../../api';

    export default {
        mounted() {
            this.fetchPosts();
            // Tell the world that this component has been loaded
            this.$nextTick(() => {
                window.postMessage('posts-loader/init', '*');

                this.$el.querySelectorAll('[data-filter-taxonomy]').forEach(filter => {
                    filter.addEventListener('change', e => this.onTaxonomyChanged(e.target));
                });

                this.$el.querySelectorAll('[data-filter-year]').forEach(filter => {
                    filter.addEventListener('change', e => this.onYearChanged(e.target));
                });
            });
        },
        props: {
            postType: {
                type: String,
                required: true
            },
            perPage: {
                type: Number,
                default: 10
            },
            query: {
                type: Object,
                default: () => ({})
            },
            order: {
                type: String,
                default: 'desc'
            },
            orderby: {
                type: String,
                default: 'date'
            }
        },
        data: () => ({
            taxonomies: {},
            fetching: false,
            fetched: false,
            before: null,
            after: null,
            posts: [],
            page: 0, // The current page is 0, because nothing has been fetch yet.
            total: null,
            totalPages: 1
        }),
        computed: {
            canFetchMore() {
                return this.page < this.totalPages;
            },
            fetchButtonDisabled() {
                return this.fetching || this.page >= this.totalPages;
            }
        },
        methods: {
            makeRequest(params = {}) {
              return api.posts(this.postType, params);
            },
            trimWords(value, words = 35) {
                const split = value.split(' ').splice(0, words);
                value = split.join(' ');

                return split.length >= 20 ? value + '...' : value;
            },
            onTaxonomyChanged(target) {
                const tax = target.getAttribute('data-filter-taxonomy');
                const category = +target.selectedOptions[0].value;

                if (category > 0) {
                    this.taxonomies[tax] = category;
                } else {
                    delete this.taxonomies[tax];
                }

                this.filterChanged();
            },
            onYearChanged(target) {
                const year = JSON.parse(target.selectedOptions[0].value || {});

                if (year.before) {
                    this.before = new Date(year.before, 0, 1);
                } else {
                    this.before = null;
                }

                if (year.after) {
                    this.after = new Date(year.after, 0, 1);
                } else {
                    this.after = null;
                }

                this.filterChanged();
            },
            fetchPosts() {
                if (!this.canFetchMore) {
                    return;
                }

                this.fetching = true;

                let params = {
                    per_page: this.perPage,
                    page: this.page + 1,
                    order: this.order,
                    orderby: this.orderby,
                    before: this.before,
                    after: this.after,
                    ...this.query
                };

                if (Object.keys(this.taxonomies).length > 0) {
                    params = Object.assign(params, this.taxonomies);
                }

                this.makeRequest(params).then(res => {
                    // Make sure, that only posts are added, that were not already fetched
                    const posts = res.data.filter(p => !this.posts.find(pp => pp.id === p.id));
                    this.storePosts(posts);
                    this.total = +res.headers['x-wp-total'];
                    this.totalPages = +res.headers['x-wp-totalpages'];

                    // Update the current page, since we really got new data
                    this.page++;

                    setTimeout(() => {
                        this.$el.dispatchEvent(new CustomEvent('change', {posts}));
                    }, 100);
                }, err => {
                    // Something went wrong...
                }).then(res => {
                    this.fetching = false;
                    this.fetched = true;
                });
            },
            fetchMore() {
                this.fetchPosts();
            },
            storePosts(posts) {
                this.posts = [
                    ...this.posts,
                    ...posts
                ];
            },
            filterChanged() {
                this.fetched = false;
                this.posts = [];
                this.page = 0;
                this.totalPages = 1;
                this.fetchPosts();
            }
        }
    };

</script>
