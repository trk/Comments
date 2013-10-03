<ion:comments>
    <div class="comments">
        <ion:lang key="module_comments_title_comments_form" tag="h3" />
        <hr />
        <div class="clearfix"></div>
        <div>
            <ion:can role="manage">
                <label class="label label-success"><ion:lang key="module_comments_label_published" /></label> <span class="label label-success"><ion:count /></span>
                <label class="label label-danger"><ion:lang key="module_comments_label_pending" /></label> <span class="label label-danger"><ion:count field="pending" /></span>
                <label class="label label-info"><ion:lang key="module_comments_label_pending" /></label> <span class="label label-info"><ion:count field="all" /></span>
            </ion:can>
            <ion:can role="manage" is="false">
                <ion:count lang="module_comments_label_total_comments" />
            </ion:can>
        </div>
        <hr />
        <ion:list order_by="created DESC">
            <div class="media comment p10">
                <div class="media-body">
                    <div class="<ion:status expression='status==0'>alert alert-danger</ion:status>">
                        <div class="pl10 pr10">
                            <span><i class="glyphicon glyphicon-user"></i> <ion:author /></span>
                            <ion:admin expression="==1"><span><i class="glyphicon glyphicon-star"></i> <ion:lang key="module_comments_label_admin" /></span></ion:admin>
                            <span class="ml10"><i class="glyphicon glyphicon-calendar"></i> <ion:created /></span>
                            <ion:site expression="!=''"><span class="ml10"><i class="glyphicon glyphicon-new-window"></i> <a href="<ion:site />" target="_blank"><ion:site /></a></span></ion:site>
                            <ion:can role="manage">
                                <div>
                                    <span><i class="glyphicon glyphicon-envelope"></i> <a href="mailto:<ion:email />"><ion:email /></a></span>
                                    <span class="ml10"><i class="glyphicon glyphicon-qrcode"></i> <ion:ip /></span>
                                </div>
                            </ion:can>
                        </div>
                        <hr />
                        <div class="pl10 pr10">
                            <ion:content />
                        </div>
                    </div>
                </div>
            </div>
        </ion:list>
    </div>
</ion:comments>