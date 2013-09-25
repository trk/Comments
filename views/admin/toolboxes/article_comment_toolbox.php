<div class="commentsToolbox">
    <div class="divider">
        <a class="button light" id="btnNewComment">
            <i class="icon-comments"></i><?php echo lang('module_comments_button_new_comments'); ?>
        </a>
    </div>
    <div class="divider">
        <a class="button light" id="btnBackToArticle">
            <i class="icon-arrow-left"></i><?php echo lang('module_comments_button_back_to_article'); ?>
        </a>
    </div>
</div>
<script type="text/javascript">

    var module_url = admin_url + 'module/comments/comments/',
        id_article = $('id_article').value,
        rel_article = $('rel_article').value,
        title_article = $('title_article').value,
        button_new_comment = $('btnNewComment'),
        button_back_to_article = $('btnBackToArticle');

    /**
     * New Comment
     */
    button_new_comment.addEvent('click', function(e)
    {
        ION.formWindow(
            'comment',
            'commentForm',
            '<?php echo lang('module_comments_title_window_new_comment'); ?>',
            module_url + 'get_form/' + id
        );
    });

    /**
     * Back to article button
     * Edit article link
     */
    button_back_to_article.addEvent('click', function(e) {
        e.stop();
        ION.splitPanel({
            'urlMain': admin_url + 'article/edit/' + rel_article,
            'urlOptions': admin_url + 'article/get_options/' + rel_article,
            'title': Lang.get('ionize_title_edit_article') + ' : ' + title_article
        });
    });

</script>