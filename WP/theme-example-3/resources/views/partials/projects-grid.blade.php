<div class="component--projects-grid row">
    @foreach((array)$projects as $project)
        <div class="col-xl-4 col-lg-6 isotope-item topic-{{ $project->topic->slug ?? 'unset' }}">
            <a class="card" href="{{ get_permalink($project) }}">
                <div class="card-body d-flex flex-column"
                     style="background-color: {{ carbon_get_term_meta($project->topic->term_id ?? 0, 'theme_color_secondary') }};">
                    <div class="small mb-3 project-topic">{{ $project->topic->name ?? '' }}</div>
                    <div class="project-title mb-2">{{ $project->post_title }}</div>
                    <p>{!! wp_trim_words(e($project->post_excerpt), 35)  !!}</p>
                    <div class="card-link text-body align-self-end d-flex">
                        @include('icons.arrow-right')
                    </div>
                </div>
            </a>
        </div>
    @endforeach
</div>
