<!-- Tabs -->
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

        <table class="list table-striped" id="pendingCommentsTable">
            <thead>
                <tr>
                    <th><?php echo lang('ionize_label_id'); ?></th>
                    <th axis="string"><?php echo lang('ionize_label_author'); ?></th>
                    <th axis="string"><?php echo lang('ionize_label_email'); ?></th>
                    <th axis="string"><?php echo lang('module_comments_title_website'); ?></th>
                    <th axis="string"><?php echo lang('ionize_label_content'); ?></th>
                    <th axis="string"><?php echo lang('module_comments_title_ip') ?></th>
                    <th axis="string"><?php echo lang('ionize_label_created') ?></th>
                    <th axis="string"><?php echo lang('ionize_label_updated') ?></th>
                    <th class="right" style="width:100px;"><?php echo lang('ionize_label_actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($comments['pending'] as $comment): ?>
                    <tr class="comment">
                        <td><?php echo $comment['id_article_comment']; ?></td>
                        <td><?php echo $comment['author']; ?></td>
                        <td><?php echo $comment['email']; ?></td>
                        <td><?php echo $comment['site']; ?></td>
                        <td><?php echo $comment['content']; ?></td>
                        <td><?php echo $comment['ip']; ?></td>
                        <td><?php echo $comment['created']; ?></td>
                        <td><?php echo $comment['updated']; ?></td>
                        <td>
                            <a data-id_article_comment="<?php echo $comment['id_article_comment']; ?>" data-id_article="<?php echo $comment['id_article']; ?>" class="icon delete right mr5"></a>
                            <a data-id_article_comment="<?php echo $comment['id_article_comment']; ?>" data-id_article="<?php echo $comment['id_article']; ?>" class="icon status<?php if($comment['status'] == 1){ ?> online<?php } else { ?> offline<?php } ?> right mr5"></a>
                            <a class="icon right edit mr5" rel="" title=""></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    </div>

    <!-- Published Comments -->
    <div class="tabcontent">
        <table class="list table-striped" id="publishedCommentsTable">
            <thead>
                <tr>
                    <th><?php echo lang('ionize_label_id'); ?></th>
                    <th axis="string"><?php echo lang('ionize_label_author'); ?></th>
                    <th axis="string"><?php echo lang('ionize_label_email'); ?></th>
                    <th axis="string"><?php echo lang('module_comments_title_website'); ?></th>
                    <th axis="string"><?php echo lang('ionize_label_content'); ?></th>
                    <th><?php echo lang('module_comments_title_ip') ?></th>
                    <th axis="string"><?php echo lang('ionize_label_created') ?></th>
                    <th axis="string"><?php echo lang('ionize_label_updated') ?></th>
                    <th class="right" style="width:100px;"><?php echo lang('ionize_label_actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($comments['published'] as $comment): ?>
                    <tr class="comment">
                        <td><?php echo $comment['id_article_comment']; ?></td>
                        <td><?php echo $comment['author']; ?></td>
                        <td><?php echo $comment['email']; ?></td>
                        <td><?php echo $comment['site']; ?></td>
                        <td><?php echo $comment['content']; ?></td>
                        <td><?php echo $comment['ip']; ?></td>
                        <td><?php echo $comment['created']; ?></td>
                        <td><?php echo $comment['updated']; ?></td>
                        <td>
                            <a data-id_article_comment="<?php echo $comment['id_article_comment']; ?>" data-id_article="<?php echo $comment['id_article']; ?>" class="icon delete right mr5"></a>
                            <a data-id_article_comment="<?php echo $comment['id_article_comment']; ?>" data-id_article="<?php echo $comment['id_article']; ?>" class="icon status<?php if($comment['status'] == 1){ ?> online<?php } else { ?> offline<?php } ?> right mr5"></a>
                            <a class="icon right edit mr5" rel="" title=""></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<script type="text/javascript">

    var module_url = admin_url + 'module/comments/comments/';

    /**
     * Sortable Tables
     */
    new SortableTable('pendingCommentsTable',{sortOn: 0, sortBy: 'ASC'});
    new SortableTable('publishedCommentsTable',{sortOn: 0, sortBy: 'ASC'});

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
     * Delete item
     */
    $$('#commentsTabContent .delete').each(function(item, idx)
    {
        var id_article_comment  = item.getProperty('data-id_article_comment'),
            id_article          =  item.getProperty('data-id_article'),
            confirmDeleteMessage = '<?php echo lang('module_comments_notification_delete_question'); ?>';

        ION.initRequestEvent(
            item,
            module_url + 'delete/' + id_article_comment + '/' + id_article,
            {
                'redirect':true
            },
            {
                'confirm':true, 'message': confirmDeleteMessage
            }
        );
    });

    /**
     * Change item status
     */
    $$('#commentsTabContent .status').each(function(item)
    {
        var id_article_comment  = item.getProperty('data-id_article_comment'),
            id_article          =  item.getProperty('data-id_article');

        ION.initRequestEvent(
            item,
            module_url + 'switch_status/' + id_article_comment + '/' + id_article,
            {},
            {}
        )
    });

</script>