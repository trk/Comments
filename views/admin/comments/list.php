<table class="list table-striped" id="<?php echo $comment_type; ?>CommentsTable">
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
            <th class="center" style="width:100px;"><?php echo lang('ionize_label_actions') ?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($article_comments as $article_comment): ?>
            <tr class="comment">
                <td><?php echo $article_comment['id_article_comment']; ?></td>
                <td><?php echo $article_comment['author']; ?></td>
                <td><?php echo $article_comment['email']; ?></td>
                <td><?php echo $article_comment['site']; ?></td>
                <td><?php echo $article_comment['content']; ?></td>
                <td><?php echo $article_comment['ip']; ?></td>
                <td><?php echo $article_comment['created']; ?></td>
                <td><?php echo $article_comment['updated']; ?></td>
                <td>
                    <a data-id_article_comment="<?php echo $article_comment['id_article_comment']; ?>" data-id_article="<?php echo $article_comment['id_article']; ?>" class="icon delete right mr5"></a>
                    <a data-id_article_comment="<?php echo $article_comment['id_article_comment']; ?>" data-id_article="<?php echo $article_comment['id_article']; ?>" class="icon status<?php if($article_comment['status'] == 1){ ?> online<?php } else { ?> offline<?php } ?> right mr5"></a>
                    <a data-id_article_comment="<?php echo $article_comment['id_article_comment']; ?>" class="icon edit right mr5"></a>
                    <a data-id_article_comment="<?php echo $article_comment['id_article_comment']; ?>" class="icon zoomin right mr5"></a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<script type="text/javascript">

    var module_url = admin_url + 'module/comments/comments/';

    /**
     * Sortable Tables
     */
    new SortableTable('<?php echo $comment_type; ?>CommentsTable',{sortOn: 0, sortBy: 'ASC'});

    /**
     * Preview item
     */
    $$('#<?php echo $comment_type; ?>CommentsTable .zoomin').each(function(item, idx)
    {
        var id_article_comment  = item.getProperty('data-id_article_comment');

        item.addEvent('click', function(e)
        {
            ION.formWindow(
                'comment' + id_article_comment,
                'commentForm' + id_article_comment,
                '<?php echo lang('module_comments_title_window_preview_comment'); ?>',
                module_url + 'view/' + id_article_comment
            );
        });
    });

    /**
     * Edit item
     */
    $$('#<?php echo $comment_type; ?>CommentsTable .edit').each(function(item, idx)
    {
        var id_article_comment  = item.getProperty('data-id_article_comment');

        item.addEvent('click', function(e)
        {
            ION.formWindow(
                'comment' + id_article_comment,
                'commentForm' + id_article_comment,
                '<?php echo lang('module_comments_title_window_edit_comment'); ?>',
                module_url + 'edit/' + id_article_comment
            );
        });
    });

    /**
     * Delete item
     */
    $$('#<?php echo $comment_type; ?>CommentsTable .delete').each(function(item, idx)
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
    $$('#<?php echo $comment_type; ?>CommentsTable .status').each(function(item)
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