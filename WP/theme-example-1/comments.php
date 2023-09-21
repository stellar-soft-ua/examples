<?php
if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME'])) {
    die (0);
}

if (post_password_required()) { ?>
    <p class="nocomments">This post is password protected. Enter the password to view comments.</p>
    <?php
    return;
}
?>
<?php $comments_args = [
    'class_form'        => 'form form--post',
    'title_reply'       => __(''),
    'title_reply_to'    => __('Leave a Reply to %s'),
    'cancel_reply_link' => __('Cancel Reply'),
    'label_submit'      => __('Post Comment'),
    'comment_field'     => '<p class="comment-form-comment"><label for="comment">' . _x('Comment *',
            'noun') . '</label> <textarea id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea></p>'
] ?>
<?php comment_form($comments_args); ?>

<?php if (have_comments()) : ?>

    <ol class="commentlist">
        <?php wp_list_comments('type=comment&callback=advanced_comment'); //this is the important part that ensures we call our custom comment layout defined above
        ?>
    </ol>
    <div class="clear"></div>
    <div class="comment-navigation">
        <div class="older"><?php previous_comments_link() ?></div>
        <div class="newer"><?php next_comments_link() ?></div>
    </div>
    <?php if (comments_open()) : ?>
    <?php else : ?>
        <p class="nocomments">Comments are closed.</p>
    <?php endif; ?>
<?php endif; ?>


<?php if (comments_open()) : ?>

    <div id="respond">
        <div class="cancel-comment-reply">
            <small><?php cancel_comment_reply_link(); ?></small>
        </div>
        <?php if (get_option('comment_registration') && !is_user_logged_in()) : ?>
            <p>You must be <a href="<?php echo wp_login_url(get_permalink()); ?>">logged in</a> to post a comment.</p>
        <?php endif; ?>
    </div>
<?php endif; ?>