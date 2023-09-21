<div class="{{ $module_class }}{{ $compact_mode === 'on' ? ' compact' : '' }}" data-vue-instance>
    <theme-deposits :per-page="{{ intval($number_entries) }}">
        <template v-slot="props">
            @if($compact_mode === 'on')
                <h2 class="heading-bordered mt-5">{{ $label_heading }}</h2>
            @endif

            @if($show_filter === 'on')
                <div class="filters container">
                    <div class="row">
                        <div class="{{ $columns }} p-0">
                            <div class="row">
                                <div class="col-md-6 col-lg-5">
                                    <select class="selectpicker"
                                            data-style="btn-select-round"
                                            data-filter-taxonomy="topic">
                                        <option selected disabled class="d-none">{{ $filter_topics }}</option>
                                        <option value="0"><?php echo _x('Alle', 'Kein aktiver Filter', 'theme'); ?></option>
                                        @foreach($topics as $topic)
                                            <option value="{{ $topic->term_id }}">{{ $topic->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4 col-lg-3 mt-3 mt-md-0">
                                    <select class="selectpicker"
                                            data-style="btn-select-round"
                                            data-filter-year>
                                        <option selected disabled class="d-none">{{ $filter_year }}</option>
                                        <option value="{}"><?php echo _x('Alle', 'Kein aktiver Filter', 'theme'); ?></option>
                                        @foreach($years as $label => $value)
                                            <option value='{!! json_encode($value) !!}'>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="container">
                <div class="row">
                    <div v-for="post of props.posts" :key="post.id"
                         class="deposit--item {{ $compact_mode === 'off' ? 'col-12' : 'col-md-6' }}">
                        <div class="row {{ $compact_mode === 'on' ? 'no-gutters' : '' }}">
                            <div class="{{ $compact_mode === 'off' ? 'col-md-5 offset-md-1 col-xl-4 offset-xl-2' : 'col-12' }}">
                                <a v-if="post.zenodo_meta.files" :href="post.zenodo_meta.files[0].links.download || null" class="cover" :style="{'background': post.colors.color_primary}">
                                    <div class="cover-content">
                                        <div class="title" v-text="post.title"></div>

                                        <div class="preview">
                                            <img :src="post.featured_image"/>
                                        </div>
                                    </div>
                                </a>
                                <div v-else class="cover" :style="{'background': post.colors.color_primary}">
                                    <div class="cover-content">
                                        <div class="title" v-text="post.title"></div>
                                    </div>
                                </div>
                            </div>
                            @if($compact_mode === 'off')
                                <div class="flex col-md-5 col-xl-4 mt-md mt-md-0">
                                    <theme-more-content :max-height="185" class="flex">
                                        <div class="description" v-html="post.description"></div>

                                        <template v-slot:expand="content">
                                            <div class="align-self-center">
                                                <div @click="content.toggle()"
                                                     class="icon chevron"
                                                     :class="{top: content.expanded, bottom: !content.expanded}"></div>
                                            </div>
                                        </template>
                                    </theme-more-content>

                                    <div class="files">
                                        <div class="file" v-for="file in post.zenodo_meta.files" :key="file.id">
                                            <a :href="file.links.download" download v-text="file.filename"></a>
                                        </div>
                                    </div>

                                    @if($order_modal_id)
                                        <div class="btn btn-outline-primary" onclick="window.showModal('{{ $order_modal_id }}')">
                                            {{ $label_order_deposit }}
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>

                    <template v-if="props.fetching">
                        <div class="{{ $columns }} text-center">
                            <theme-spinner></theme-spinner>
                        </div>
                    </template>

                    <template v-if="props.fetched && props.posts.length === 0">
                        <div class="{{ $columns }}"><?php echo __('Keine Publikationen gefunden', 'theme'); ?></div>
                    </template>
                </div>
            </div>

            @if($show_more_button === 'on')
                <div class="container text-center" v-if="props.canFetchMore">
                    <div class="row">
                        <div class="{{ $columns }} mt-3">
                            <span class="underline font-weight-semi-bold pointer small hover-primary"
                                  @click="props.fetchMore()"
                                  :disabled="props.fetchButtonDisabled"><?php echo __('mehr anzeigen', 'theme'); ?></span>
                        </div>
                    </div>
                </div>
            @endif
        </template>
    </theme-deposits>
</div>
