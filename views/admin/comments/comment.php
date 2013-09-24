<form name="commentForm<?php echo $id_article_comment; ?>" id="commentForm<?php echo $id_article_comment; ?>" action="<?php echo admin_url(); ?>module/comments/comments/save">

	<!-- Hidden fields -->
	<input id="id_article_comment" type="hidden" name="id_article_comment" value="<?php echo $id_article_comment; ?>" />
    <input id="id_article" type="hidden" name="id_article" value="<?php echo $id_article; ?>" />
    <input id="ip" type="hidden" name="ip" value="<?php echo $ip; ?>" />
    <input id="status" type="hidden" name="status" value="<?php echo $status; ?>" />

    <!-- Author -->
    <dl class="small">
        <dt>
            <label for="author"><?php echo lang('ionize_label_author'); ?></label>
        </dt>
        <dd>
            <input id="author" type="text" name="author" class="inputtext" value="<?php echo $author; ?>" />
        </dd>
    </dl>

    <!-- Email -->
    <dl class="small">
        <dt>
            <label for="email"><?php echo lang('ionize_label_email'); ?></label>
        </dt>
        <dd>
            <input id="email" type="text" name="email" class="inputtext" value="<?php echo $email; ?>" />
        </dd>
    </dl>

    <!-- Site -->
    <dl class="small">
        <dt>
            <label for="site"><?php echo lang('module_comments_title_website'); ?></label>
        </dt>
        <dd>
            <input id="site" type="text" name="site" class="inputtext" value="<?php echo $site; ?>" />
        </dd>
    </dl>

    <!-- Content -->
    <dl class="small">
        <dt>
            <label for="content"><?php echo lang('module_comments_title_website'); ?></label>
        </dt>
        <dd>
            <textarea id="content" name="content" class="textarea"><?php echo $content; ?></textarea>
        </dd>
    </dl>

</form>

<div class="buttons">
	<button id="bSavecomment<?php echo $id_article_comment; ?>" type="button" class="button yes right mr40"><?php echo lang('ionize_button_save_close'); ?></button>
	<button id="bCancelcomment<?php echo $id_article_comment; ?>"  type="button" class="button no right"><?php echo lang('ionize_button_cancel'); ?></button>
</div>

<script type="text/javascript">

	// Window resize
	ION.windowResize(
        'comment<?php echo $id_article_comment; ?>',
        {
            width:640,
            height:450
        }
    );

</script>
