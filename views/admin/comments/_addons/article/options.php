<h3 class="toggler toggler-options"><?php echo lang('module_comments_title'); ?></h3>

<div class="element element-options">

    <div class="element-content">

        <dl class="small compact">
            <dt>
                <label title="<?php echo lang('module_comments_help_if_checked_comments_will_allowed'); ?>" for="comment_allow"><?php echo lang('module_comments_label_allow_comments'); ?></label>
            </dt>
            <dd>
                <input id="comment_allow" name="comment_allow" type="checkbox" class="inputcheckbox" <?php if ($article['comment_allow'] == 1):?> checked="checked" <?php endif;?> value="1">
            </dd>
        </dl>
        <dl class="small compact">
            <dt>
                <label><span class="label label-success"><?php echo lang('module_comments_label_published'); ?></span></label>
            </dt>
            <dd>
                <span class="badge badge-success"><?php echo $count['published']; ?></span>
            </dd>
        </dl>
        <dl class="small compact">
            <dt>
                <label><span class="label label-danger"><?php echo lang('module_comments_label_pending'); ?></span></label>
            </dt>
            <dd>
                <span class="badge badge-danger"><?php echo $count['pending']; ?></span>
            </dd>
        </dl>
        <dl class="small compact">
            <dt>
                <label><span class="label label-info"><?php echo lang('module_comments_label_total'); ?></span></label>
            </dt>
            <dd>
               <span class="badge badge-info"><?php echo $count['all']; ?></span>
            </dd>
        </dl>
        <dl class="small compact">
            <dt>
                <label></label>
            </dt>
            <dd>
                <a id="btnManageComments" class="button light plus" data-id="<?php echo $article['id_article']; ?>" data-url="comments/article_comments/" title="<?php echo lang('module_comments_help_click_here_for_manage_comments'); ?>">
                    <i class="icon arrow-right"></i> <?php echo lang('module_comments_title_manage_comments'); ?>
                </a>
            </dd>
        </dl>

    </div>
</div>


<script type="text/javascript">

    /**
     * XHR update : Comment Allowed
     */
    $('comment_allow').addEvent('click', function(e)
    {
        var value = (this.checked) ? '1' : '0';
        ION.JSON('article/update_field', {'field': 'comment_allow', 'value': value, 'id_article': $('id_article').value});
    });

    /**
     * button : Comment management
     */
    $('btnManageComments').addEvent('click', function(e)
    {
        var options = {
            element: $('mainPanel'),
            title: '<?php echo lang('module_comments_title_comment_management'); ?>',
            url : admin_url + 'module/comments/' + $(this).getProperty('data-url') + $(this).getProperty('data-id') + '/' + $('rel').value
        };

        ION.contentUpdate(options);
    });

</script>