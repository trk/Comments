<?php
    $title = $article[Settings::get_lang('default')]['title'];
    if ($title == '') $title = $name;
?>
<div id="maincolumn">

    <h2 class="main comments" id="main-title"><?php echo lang('module_comments_title_comments', $title); ?></h2>

    <div class="main subtitle">
        <p class="lite">
            <a id="btnBackToArticle" class="button light plus" title="<?php echo lang('module_comments_help_click_here_for_go_back_to_article'); ?>">
                <i class="icon arrow-left"></i><?php echo lang('module_comments_button_back_to_article'); ?>
            </a>
        </p>
    </div>

    <hr />

    <div class="mainTabs">

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

                <table class="list" id="offlineCommentsTable">
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
                                    <a class="icon right delete" rel="" title=""></a>
                                    <a class="icon right edit mr5" rel="" title=""></a>
                                    <a class="icon right status offline mr5" data-id="6"></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

            </div>

            <!-- Published Comments -->
            <div class="tabcontent">
                <table class="list" id="onlineCommentsTable">
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
                                    <a class="icon right delete" rel="" title=""></a>
                                    <a class="icon right edit mr5" rel="" title=""></a>
                                    <a class="icon right status online mr5" rel="" title=""></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</div>
<script type="text/javascript">

    /**
     * Panel toolbox
     */
    ION.initToolbox('empty_toolbox');

    /**
     * Back to article button
     * Edit article link
     */
    var articleButton = $('btnBackToArticle');
    articleButton.addEvent('click', function(e) {
        e.stop();
        ION.splitPanel({
            'urlMain': admin_url + 'article/edit/<?php echo $rel; ?>',
            'urlOptions': admin_url + 'article/get_options/<?php echo $rel; ?>',
            'title': Lang.get('ionize_title_edit_article') + ' : <?php echo $title; ?>'
        });
    });

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

</script>