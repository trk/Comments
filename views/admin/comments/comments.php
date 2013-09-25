<?php
    $title = $article[Settings::get_lang('default')]['title'];
    if ($title == '') $title = $name;
?>
<input type="hidden" name="id_article" id="id_article" value="<?php echo $article['id_article']; ?>" />
<input type="hidden" name="rel_article" id="rel_article" value="<?php echo $rel; ?>" />
<input type="hidden" name="title_article" id="title_article" value="<?php echo $title; ?>" />

<div id="maincolumn">

    <h2 class="main comments" id="main-title"><?php echo lang('module_comments_title_comments', $title); ?></h2>

    <hr />

    <div class="mainTabs">

        <!-- Comments Tabs -->
        <div id="commentsTab" class="mainTabs">
            <ul class="tab-menu">
                <li><a><span><?php echo lang('module_comments_title_pending_comments'); ?></span></a></li>
                <li><a><span><?php echo lang('module_comments_title_published_comments'); ?></span></a></li>
            </ul>
            <div class="clear"></div>
        </div>

        <!-- Comments list -->
        <div id="commentsTabContent">

            <!-- Pending Comments -->
            <div class="tabcontent">
                <div id="pendingCommentsContainer"></div>
            </div>

            <!-- Published Comments -->
            <div class="tabcontent">
                <div id="publishedCommentsContainer"></div>
            </div>
        </div>

    </div>

</div>
<script type="text/javascript">

    var module_url = admin_url + 'module/comments/comments/';

    /**
     * Panel toolbox
     */
    ION.initModuleToolbox('comments','article_comment_toolbox');

    /**
     * Comments Tabs
     */
    new TabSwapper({
        tabsContainer: 'commentsTab',
        sectionsContainer: 'commentsTabContent',
        selectedClass: 'selected',
        deselectedClass: '',
        tabs: 'li',
        clickers: 'li a',
        sections: 'div.tabcontent',
        cookieName: 'commentsTab'
    });

    /**
     * Load pending comments
     */
    ION.HTML(
        module_url + 'get_list',
        {
            'id_article' : <?php echo $article['id_article']; ?>,
            'status' : 0
        },
        {
            'update': 'pendingCommentsContainer'
        }
    );

    /**
     * Load published comments
     */
    ION.HTML(
        module_url + 'get_list',
        {
            'id_article' : <?php echo $article['id_article']; ?>,
            'status' : 1
        },
        {
            'update': 'publishedCommentsContainer'
        }
    );

</script>