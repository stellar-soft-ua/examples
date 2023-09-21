<form role="search" method="get" id="searchform" action="<?php echo home_url('/') ?>" class="search-page-form">
    <input type="text" value="<?php echo get_search_query() ?>" name="s" id="website-search"
           class="website-search-page"/>
    <input type="hidden" name="post_type" value="vna">
</form>