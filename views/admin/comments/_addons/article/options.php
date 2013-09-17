<dl class="small">
    <dt>
        <label title="<?php echo lang('module_comments_help_if_checked_comments_will_allowed'); ?>" for="comment_allow"><?php echo lang('module_comments_label_allow_comments'); ?></label>
    </dt>
    <dd>
        <input id="comment_allow" name="comment_allow" type="checkbox" class="inputcheckbox" <?php if ($article['comment_allow'] == 1):?> checked="checked" <?php endif;?> value="1">
    </dd>
</dl>
<script type="text/javascript">

    // Indexed XHR & Categories update
    $('comment_allow').addEvent('click', function(e)
    {
        var value = (this.checked) ? '1' : '0';
        ION.JSON('article/update_field', {'field': 'comment_allow', 'value': value, 'id_article': $('id_article').value});
    });

</script>