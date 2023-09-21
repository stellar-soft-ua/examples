<template>
    <div class="theme--posts-loader vue--events-projects-grid" :class="{ fetching }">
      <slot name="default" v-bind="{posts, fetching, fetched, page, totalPages, fetchMore, fetchButtonDisabled, canFetchMore, trimWords}">
        Default Slot
      </slot>
    </div>
</template>

<script>
    import PostsLoader from './PostsLoader';
    import {api} from '../../api';

    export default {
        mixins: [
            PostsLoader
        ],
        props: {
          postType: {
            required: false,
          }
        },
        methods: {
            makeRequest(params = {}) {
                return api.projectsAndEvents(params);
            }
        }
    };
</script>

<style lang="scss" scoped>
    .vue--events-projects-grid::v-deep {

    }
</style>
