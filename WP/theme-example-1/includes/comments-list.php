<?php
function advanced_comment($comment, $args, $depth)
{
    $GLOBALS['comment'] = $comment; ?>

    <li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
        <div class="comment-author vcard">
            <?= get_avatar($comment, 40); ?>
            <div class="comment-meta"
            <a href="<?php the_author_meta('user_url'); ?>"><?php printf(__('%s'), get_comment_author_link()) ?></a>
        </div>
        <small style="float: right;"><?php printf(__('%1$s at %2$s'), get_comment_date(),
                get_comment_time()) ?><?php edit_comment_link(__('(Edit)'), '  ', '') ?></small>
        </div>
    </li>
    <div class="clear"></div>

    <?php if ($comment->comment_approved == '0') : ?>
    <em><?php _e('Your comment is awaiting moderation.') ?></em>
    <br/>
<?php endif; ?>

    <div class="comment-text">
        <?php comment_text() ?>
    </div>

    <div class="reply">
        <?php comment_reply_link(array_merge($args, ['depth' => $depth, 'max_depth' => $args['max_depth']])) ?>
    </div>
    <div class="clear"></div>
<?php } ?>