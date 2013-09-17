<div class="commentsToolbox">
    <div class="toolbox divider">
        <input type="button" class="toolbar-button module-comments btn-setting" data-url="setting" value="<?php echo lang('module_comments_title_settings'); ?>" />
    </div>
    <div class="toolbox divider active">
        <input type="button" class="toolbar-button module-comments btn-comments" data-url="comments" value="<?php echo lang('module_comments_title_root'); ?>" />
    </div>
</div>
<script type="text/javascript">

    var toolboxMenu = '.commentsToolbox div';

    $$(toolboxMenu + ' input').addEvent('click', function(e)
    {
        $$(toolboxMenu).removeClass('active');
        this.getParent().addClass('active');
    });


    $$('.toolbar-button').each(function(item, idx)
    {
        var dataURL = item.getProperty('data-url'),
            dataTITLE = item.value;

        item.addEvent('click', function(e)
        {
            ION.contentUpdate({
                element: $('mainPanel'),
                title:  '<?php echo lang('module_comments_title'); ?> &raquo; ' + dataTITLE,
                url : admin_url + 'module/comments/' + dataURL
            });
        });
    });

</script>