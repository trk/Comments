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

    /**
     * Back to article button
     * Edit article link
     */
    var article_rel = $('article_rel').value,
        article_title = $('article_title').value,
        articleButton = $('btnBackToArticle');

    articleButton.addEvent('click', function(e) {
        e.stop();
        ION.splitPanel({
            'urlMain': admin_url + 'article/edit/' + article_rel,
            'urlOptions': admin_url + 'article/get_options/' + article_rel,
            'title': Lang.get('ionize_title_edit_article') + ' : ' + article_title
        });
    });

</script>