<?php
get_header();
$args = [
    'post_type'   => 'position',
    'post_status' => 'publish',
    'meta_query'  => [
        [
            'key'   => 'available-position',
            'value' => 'on'
        ]
    ]
];

$slider_args = [
    'post_type'   => 'position',
    'post_status' => 'publish'
];

$all_query = new WP_Query;
$_slides = $all_query->query($slider_args);

$query = new WP_Query;
$_posts = $query->query($args);

foreach ($_posts as $post) {
    $departments[] = @get_post_custom_values('department', $post->ID)[0];
}

$departments = array_unique($departments);
?>
    <!-- Positions sections -->

    <section class="positions">
        <h1>Available Positions</h1>
        <div class="positions__slider">
            <div class="positions__block">
                <?php foreach ($_slides as $slide): ?>
                    <?php $position_img = get_the_post_thumbnail_url($slide->ID); ?>
                    <?php if ($position_img): ?>
                        <img src="<?= $position_img != '' ? $position_img : false ?>" alt="Slider positions"/>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
            <i class="arrow-slider arrow-slider--left"></i>
            <i class="arrow-slider arrow-slider--right"></i>
        </div>
    </section>

    <!-- End positions sections -->

    <!-- Available Positions sections -->

    <section class="positions">
        <div class="container">
            <div class="position__filter">
                <p>Filter by Department: </p>
                <select class="select select--positions">
                    <option value="all">All</option>
                    <?php foreach ($departments as $department): ?>
                        <option value="<?= $department ?>"><?= $department ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="positions__info">

            </div>
        </div>
    </section>
<?php
wp_enqueue_script('cmt-position-filter');
get_footer() ?>
