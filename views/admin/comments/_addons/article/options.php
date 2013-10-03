<?php if(Authority::can('access', 'module/comments/admin')): ?>
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
                    <label title="<?php echo lang('module_comments_help_if_checked_comments_will_auto_valide'); ?>" for="comment_autovalid"><?php echo lang('module_comments_label_auto_validate_comments'); ?></label>
                </dt>
                <dd>
                    <input id="comment_autovalid" name="comment_autovalid" type="checkbox" class="inputcheckbox" <?php if ($article['comment_autovalid'] == 1):?> checked="checked" <?php endif;?> value="1">
                </dd>
            </dl>
            <dl class="small compact">
                <dt>
                    <label for="comment_expire" title="<?php echo lang('module_comments_help_comment_expire'); ?>"><?php echo lang('module_comments_label_comment_expire'); ?></label>
                </dt>
                <dd>
                    <input id="comment_expire" name="comment_expire" type="text" class="inputtext w120 date"  value="<?php echo humanize_mdate($article['comment_expire'], Settings::get('date_format'). ' %H:%i:%s'); ?>" />
                    <a class="icon clearfield date" data-id="comment_expire"></a>
                </dd>
            </dl>
            <!-- Submit button  -->
            <dl class="small compact mb10">
                <dt>&#160;</dt>
                <dd>
                    <a class="button submit" id="comment_expire_save">
                        <?php echo lang('module_comments_button_save_date'); ?>
                    </a>
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
            <dl class="small compact last">
                <dt>
                    <label></label>
                </dt>
                <dd>
                    <a id="btnManageComments" class="button light plus" title="<?php echo lang('module_comments_help_click_here_for_manage_comments'); ?>">
                        <i class="icon arrow-right"></i> <?php echo lang('module_comments_title_manage_comments'); ?>
                    </a>
                </dd>
            </dl>

        </div>
    </div>


    <script type="text/javascript">

        var id_article = <?php echo $article['id_article']; ?>;

        /**
         * XHR update : Comment Allowed
         */
        $('comment_allow').addEvent('click', function(e)
        {
            var value = (this.checked) ? '1' : '0';
            ION.JSON('article/update_field', {'field': 'comment_allow', 'value': value, 'id_article': id_article });
        });

        $('comment_autovalid').addEvent('click', function(e)
        {
            var value = (this.checked) ? '1' : '0';
            ION.JSON('article/update_field', {'field': 'comment_autovalid', 'value': value, 'id_article': id_article });
        });

        $('comment_expire_save').addEvent('click', function(e)
        {
//            e.stop();
            var value = $('comment_expire').value;
            ION.JSON('article/update_field', {'field': 'comment_expire', 'value': value, type: 'date', 'id_article': id_article });
        });

        /**
         * button : Comment management
         */
        $('btnManageComments').addEvent('click', function(e)
        {
            var options = {
                element: $('mainPanel'),
                title: '<?php echo lang('module_comments_title_comment_management'); ?>',
                url : admin_url + 'module/comments/comments/article_comments/' + id_article + '/' + $('rel').value
            };

            ION.contentUpdate(options);
        });

    </script>
<?php endif; ?>