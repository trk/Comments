<div id="maincolumn">

    <h2 class="main comments"><?php echo lang('module_comments_title'); ?></h2>

    <div class="main subtitle">

        <p class="lite">
            <?php echo lang('module_comments_about'); ?>
        </p>

    </div>
    <hr />
    <div class="mainTabs">

        <!-- RSS Pages to use tab content -->
        <div class="tabcontent droppable dropArticleForComments">
            <?php echo lang('ionize_label_drop_article_here'); ?>
        </div>

        <!-- Container for : Get comments for dropped article -->
        <div id="commentsArticleContainer"></div>

    </div>

</div>
<script type="text/javascript">

    /** Module Panel toolbox **/
    ION.initModuleToolbox('comments','comments_toolbox');

    /**
     * Article Drop callback function
     *
     * @param	HTML Dom Element	The dropped article.
     *								rel : contains the article ID
     * @param	HTML Dom Element	The receiver.
     * @param	Event				Drop event
     *
     */
    function droppedArticleForComments(element, droppable, event)
    {
        ION.JSON(admin_url + 'module/comments/comments/get_comments', {'id_article': element.getProperty('data-id')});
    };

    /**
     * Make each article draggable
     *
     */
    $$('.treeContainer .page a.title').each(function(item, idx)
    {
        ION.addDragDrop(item, '.dropArticleForComments', 'droppedArticleForComments');
    });

    // Adds the drag'n drop on each child article when opening a article in the tree
    // Mandatory because the childs article aren't known before opening
    $$('.treeContainer').each(function(tree, idx)
    {
        tree.retrieve('tree').addEvent('get', function()
        {
            $$('.treeContainer .page a.title').each(function(item, idx)
            {
                ION.addDragDrop(item, '#dropArticleForComments', 'ION.droppedArticleForComments');
            });
        });
    });

</script>