<div class="{{ $module_class }}">
    @if($projects['tender'])

        <div id="{{ str_slug($text_tender, '-', 'de') }}" class="anchor"></div>
        <h2 class="heading-bordered">{{ $text_tender }}</h2>

        <div id="projects-tender" class="row">
            @foreach((array)$projects['tender'] as $index => $project)
                <div class="col-lg-10 offset-lg-1">
                    <div class="section">
                        <div class="header">
                            <div class="d-flex flex-row justify-content-between">
                                <a href="{{ get_the_permalink($project) }}">
                                    <strong>{{ $project->post_title }}</strong>
                                </a>
                            </div>
                        </div>

                        <div class="content compact" id="accordeon-{{ $index }}" data-parent="#projects-tender">
                            <div class="d-flex flex-column justify-content-center">
                                <div>{{ $project->post_excerpt }}</div>

                                @if($downloads = \Carbon_Fields\Helper\Helper::get_post_meta($project->ID, 'sections') ?: null)
                                    <div class="download-links children-gutter-y-md">
                                        @foreach(array_filter(array_flatten($downloads, 2), 'is_array') as $download)
                                            @if(array_get($download, 'file'))
                                                <a target="_blank"
                                                   download
                                                   class="d-block underline"
                                                   href="{{ array_get($download, 'file_url') ?: get_attachment_url(array_get($download, 'file', '')) }}">
                                                    <div class="row">
                                                        <div class="col-10">
                                                            <span>{{ trim(array_get($download, 'title', '')) ?: 'Unterlagen' }}</span>
                                                        </div>
                                                        <div class="col-2 text-right font-weight-semi-bold">
                                                            <span>{{ trim(array_get($download, 'file_title', '')) ?: 'PDF' }}</span>
                                                        </div>
                                                    </div>
                                                </a>
                                            @endif
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    @if(count($events) > 0)
        <div id="{{ str_slug($text_events, '-', 'de') }}" class="anchor"></div>
        <h2 class="heading-bordered">{{ $text_events }}</h2>
        @include('partials.events-grid', ['events' => $events])
    @endif

    @if($projects['ongoing'])
        <div id="{{ str_slug($text_ongoing, '-', 'de') }}" class="anchor"></div>
        <h2 class="heading-bordered">{{ $text_ongoing }}</h2>
        @include('partials.projects-grid', ['projects' => $projects['ongoing']])
    @endif

    @if($projects['done'])
        <div id="{{ str_slug($text_completed, '-', 'de') }}" class="anchor"></div>
        <h2 class="heading-bordered">{{ $text_completed }}</h2>
        @include('partials.events-grid', ['events' => $projects['done']])
    @endif
</div>
