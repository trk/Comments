<form name="commentForm<?php echo $id_article_comment; ?>" id="commentForm<?php echo $id_article_comment; ?>">

    <!-- IP -->
    <dl class="small">
        <dt>
            <label><b><?php echo lang('module_comments_title_ip'); ?></b></label>
        </dt>
        <dd>
            <?php echo $ip; ?>
        </dd>
    </dl>

    <!-- Author -->
    <dl class="small">
        <dt>
            <label><b><?php echo lang('ionize_label_author'); ?></b></label>
        </dt>
        <dd>
            <?php echo $author; ?>
        </dd>
    </dl>

    <!-- Email -->
    <dl class="small">
        <dt>
            <label><b><?php echo lang('ionize_label_email'); ?></b></label>
        </dt>
        <dd>
            <?php echo $email; ?>
        </dd>
    </dl>

    <!-- Site -->
    <dl class="small">
        <dt>
            <label><b><?php echo lang('module_comments_title_website'); ?></b></label>
        </dt>
        <dd>
            <?php echo $site; ?>
        </dd>
    </dl>

    <!-- Content -->
    <dl class="small">
        <dt>
            <label><b><?php echo lang('module_comments_title_comment'); ?></b></label>
        </dt>
        <dd>
            <?php echo $content; ?>
        </dd>
    </dl>

</form>

<div class="buttons">
	<button id="bCancelcomment<?php echo $id_article_comment; ?>"  type="button" class="button no right"><?php echo lang('ionize_button_cancel'); ?></button>
</div>

<script type="text/javascript">

    /**
     * Resize Form Window
     */
    ION.windowResize(
        'comment<?php echo $id_article_comment; ?>',
        {
            width:500,
            height:300
        }
    );

</script>
