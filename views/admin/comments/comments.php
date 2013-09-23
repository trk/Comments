<?php
    $title = $article[Settings::get_lang('default')]['title'];
    if ($title == '') $title = $name;
?>
<div id="maincolumn">

    <h2 class="main comments" id="main-title"><?php echo lang('module_comments_title_comments', $title); ?></h2>

    <div class="main subtitle">
        <p class="lite">
            <a id="btnBackToArticle" class="button light plus" title="<?php echo lang('module_comments_help_click_here_for_go_back_to_article'); ?>">
                <i class="icon arrow-left"></i><?php echo lang('module_comments_button_back_to_article'); ?>
            </a>
        </p>
    </div>

    <hr />

    <div class="mainTabs">

        <!-- Use XHR for Load Comments -->
        <div id="commentsContainer"></div>

    </div>

</div>
<script type="text/javascript">

    var module_url = admin_url + 'module/comments/comments/';

    /**
     * Panel toolbox
     */
    ION.initToolbox('empty_toolbox');

    /**
     * Back to article button
     * Edit article link
     */
    var articleButton = $('btnBackToArticle');
    articleButton.addEvent('click', function(e) {
        e.stop();
        ION.splitPanel({
            'urlMain': admin_url + 'article/edit/<?php echo $rel; ?>',
            'urlOptions': admin_url + 'article/get_options/<?php echo $rel; ?>',
            'title': Lang.get('ionize_title_edit_article') + ' : <?php echo $title; ?>'
        });
    });

    /**
     * Load comments list to #commentsContainer
     */
    ION.HTML(
        module_url + 'get_list',
        {
            'id_article' : <?php echo $article['id_article']; ?>
        },
        {'update': 'commentsContainer'});
</script>