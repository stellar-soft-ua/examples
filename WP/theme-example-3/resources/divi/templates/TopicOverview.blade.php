<div data-module="TopicOverview" class="isotope-wrapper" data-change-listener=".theme--posts-loader" data-init-message="posts-loader/init">
    <div class="isotope-filter row">
        <div class="col-md-10 offset-md-1 col-xl-12 offset-xl-0">
            <div class="row">
                <div class="col-xl-3 col-lg-12 mt-3">
                    <a href="#" class="btn btn-outline-secondary active" data-filter="*">{{ $filter_overview }}</a>
                </div>
                @foreach($topics as $topic)
                    <div class="col-xl-3 col-lg-4 mt-3">
                        <a href="#{{ $topic->slug }}"
                           class="btn btn-outline-secondary"
                           data-filter=".topic-{{ $topic->slug }}"
                           style="--primary: {{ carbon_get_term_meta($topic->term_id ?? 0, 'theme_color_primary') }};
                                   --secondary: {{ carbon_get_term_meta($topic->term_id ?? 0, 'theme_color_secondary') }};"
                        >{{ $topic->name }}</a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-10 offset-md-1 col-xl-12 offset-xl-0">
            <div class="{{ $module_class }}" data-vue-instance>
                <theme-events-projects-grid :per-page="32" order="desc" orderby="meta_value_num" :query="{ meta_key: 'starts_at' }">
                    <template v-slot="props">
                        <div class="isotope-grid">
                            <div class="component--projects-grid row no-gutters">
                                <div v-for="post of props.posts" :key="post.id"
                                     class="col-xl-4 col-lg-6 isotope-item" :class="['topic-' + post.topic.slug]">
                                    <a class="card" :href="post.link">
                                        <div class="card-body d-flex flex-column"
                                             :style="{backgroundColor: post.topic.color_secondary }">
                                            <div class="small mb-3 project-topic" v-text="post.topic.name"></div>
                                            <div class="project-title mb-2" v-text="post.title.rendered"></div>
                                            <p v-html="props.trimWords(post.excerpt.rendered)"></p>
                                            <div class="card-link text-body align-self-end d-flex">
                                                @include('icons.arrow-right')
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 text-center pt-3">
                                <theme-spinner v-if="props.fetching"></theme-spinner>

                                <span v-else-if="props.canFetchMore"
                                      class="underline font-weight-semi-bold pointer small hover-primary"
                                      @click="props.fetchMore()"
                                      :disabled="props.fetchButtonDisabled"><?php echo __('mehr anzeigen', 'theme'); ?></span>
                            </div>
                        </div>
                    </template>
                </theme-events-projects-grid>
            </div>
        </div>
    </div>
</div>
