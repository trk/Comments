<div class="row">

    <div class="col-xs-12 col-sm-12">

        <hr />
        <div class="clearfix"></div>

        <ion:form:comment:validation:success is="true">
            <div class="alert alert-success">
                <ion:lang key="module_comments_form_success_title" tag="h4" />
                <ion:lang key="module_comments_form_success_message" tag="p" />
            </div>
        </ion:form:comment:validation:success>

        <ion:form:comment:validation:error is="true" >
            <div class="alert alert-danger">
                <ion:lang key="module_comments_form_error_title" tag="h4" />
                <ion:lang key="module_comments_form_error_message" tag="p" />
                <p>
                    <ion:form:comment:validation:error delimeter="p" />
                </p>
            </div>
        </ion:form:comment:validation:error>

        <form class="form-horizontal" id="comment-reply" role="form" action="<ion:url/>#comment-reply" method="post">

            <input type="hidden" name="form" value="comment" />
            <input type="hidden" name="id_article" value="<ion:article:get key='id_article' />" />

            <fieldset>


                <ion:user>
                    <ion:logged is="true">
                        <!-- Input::Hidden : Author -->
                        <input type="hidden" name="author" value="<ion:firstname /> <ion:lastname />" />
                        <!-- Input::Hidden : Email -->
                        <input type="hidden" name="email" value="<ion:email />" />

                        <!-- Input : Author -->
                        <div class="form-group">
                            <label for="author" class="col-lg-3 control-label"><ion:lang key="module_comments_label_author" /></label>
                            <div class="col-lg-8 pt7">
                                <ion:firstname /> <ion:lastname />
                            </div>
                        </div>

                        <!-- Input : Email -->
                        <div class="form-group">
                            <label for="email" class="col-lg-3 control-label"><ion:lang key="module_comments_label_email" /></label>
                            <div class="col-lg-8 pt7">
                                <ion:email />
                            </div>
                        </div>
                    </ion:logged>
                    <ion:logged is="false">
                        <!-- Input : Author -->
                        <div class="form-group<ion:form:comment:error:author is='true'> has-error</ion:form:comment:error:author>">
                            <label for="author" class="col-lg-3 control-label"><ion:lang key="module_comments_label_author" /></label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" id="author" name="author" placeholder="<ion:lang key="module_comments_label_author" />" value="<ion:form:comment:field:author />" />
                                <ion:form:comment:error:author tag="span" class="help-block" />
                            </div>
                        </div>

                        <!-- Input : Email -->
                        <div class="form-group<ion:form:comment:error:email is='true'> has-error</ion:form:comment:error:email>">
                            <label for="email" class="col-lg-3 control-label"><ion:lang key="module_comments_label_email" /></label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" id="email" name="email" placeholder="<ion:lang key="module_comments_label_email" />" value="<ion:form:comment:field:email />" />
                                <ion:form:comment:error:email tag="span" class="help-block" />
                            </div>
                        </div>
                    </ion:logged>
                </ion:user>

                <!-- Input : Site -->
                <div class="form-group<ion:form:comment:error:site is='true'> has-error</ion:form:comment:error:site>">
                    <label for="site" class="col-lg-3 control-label"><ion:lang key="module_comments_label_site" /></label>
                    <div class="col-lg-8">
                        <input type="text" class="form-control" id="site" name="site" placeholder="<ion:lang key="module_comments_label_site" />" value="<ion:form:comment:field:site />" />
                        <ion:form:comment:error:site tag="span" class="help-block" />
                    </div>
                </div>

                <!-- Input : Content -->
                <div class="form-group<ion:form:comment:error:content is='true'> has-error</ion:form:comment:error:content>">
                    <label for="content" class="col-lg-3 control-label"><ion:lang key="module_comments_label_content" /></label>
                    <div class="col-lg-8">
                        <textarea class="form-control" id="content" name="content" rows="7" placeholder="<ion:lang key="module_comments_label_content" />"><ion:form:comment:field:content /></textarea>
                        <ion:form:comment:error:content tag="span" class="help-block" />
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="form-group">
                    <label for="submit" class="col-lg-3 control-label"></label>
                    <div class="col-lg-8">
                        <button type="submit" class="btn btn-default"><ion:lang key="module_comments_label_submit_comment" /></button>
                    </div>
                </div>

            </fieldset>

        </form>

    </div>

</div>