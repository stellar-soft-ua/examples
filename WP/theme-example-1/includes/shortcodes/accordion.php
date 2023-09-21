<?php

function accordion($attr, $content)
{
    $re             = '/\[accordion-title.*?][\s|\S]*?\[\/accordion-title\]/';
    $re_description = '/\[accordion-description.*?][\s|\S]*?\[\/accordion-description\]/';
    $titles         = '';
    $descriptions   = '';
    preg_match_all($re, $content, $matches, PREG_SET_ORDER, 0);
    preg_match_all($re_description, $content, $matches_description, PREG_SET_ORDER, 0);
    foreach ($matches as $match) {
        $titles .= $match[0];
    }
    foreach ($matches_description as $matche_description) {
        $descriptions .= $matche_description[0];
    }

    return (
        '<section class="accardion accardion--vna-solution">
             <div class="container">
                 <div class="accardion__block">
                    <div class="accardion__titles">
                        ' . do_shortcode($titles) . '
                    </div>
                 <div class="accardion__description">
                ' . do_shortcode($descriptions) . '
                 </div>
                  </div>
             </div>
        </section>
    <script>
          var accordion_title = document.getElementsByClassName("accardion__title");
          var title = accordion_title[0];
          title.className += "accardion-active";
          var accordion_description = document.getElementsByClassName("accardion__item ");
          accordion_description[0].classList.remove("toggle-accardion");
    </script>'
    );
}

add_shortcode("accordion", "accordion");

function accordion_title($atts, $content = "")
{
    $atts = shortcode_atts([
        'title' => 'title',
        'order' => ''
    ], $atts);

    return ('
        <div class="accardion__title " data-manual=' . $atts['order'] . '>
        ' . $content . '
        </div>
        
    ');
}

add_shortcode('accordion-title', 'accordion_title');

function accordion_description($atts, $content = "")
{
    $atts = shortcode_atts([
        'description' => 'description',
        'order'       => ''
    ], $atts);

    return ('
       <div class="accardion__item toggle-accardion" data-manual=' . $atts['order'] . '>
          <div class="accardion__unit">
            <p> ' . $content . ' </p>
          </div>
        </div>
    ');

}

add_shortcode('accordion-description', 'accordion_description');
