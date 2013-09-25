<ion:comments>
    <hr />
    <div class="clearfix"></div>
    <div class="center">
        <label class="label label-success">Published Comments</label> <span class="label label-success"><ion:count /></span>
        <label class="label label-danger">Pending Comments</label> <span class="label label-danger"><ion:count field="pending" /></span>
        <label class="label label-info">Total Comments</label> <span class="label label-info"><ion:count field="all" /></span>
    </div>
    <hr />
    <ion:comments>
        <div class="media">
            <a class="pull-left" href="#">
                <img class="media-object" data-src="holder.js/64x64" alt="64x64" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEAAAABACAYAAACqaXHeAAACDUlEQVR4Xu2Yz6/BQBDHpxoEcfTjVBVx4yjEv+/EQdwa14pTE04OBO+92WSavqoXOuFp+u1JY3d29rvfmQ9r7Xa7L8rxY0EAOAAlgB6Q4x5IaIKgACgACoACoECOFQAGgUFgEBgEBnMMAfwZAgaBQWAQGAQGgcEcK6DG4Pl8ptlsRpfLxcjYarVoOBz+knSz2dB6vU78Lkn7V8S8d8YqAa7XK83ncyoUCjQej2m5XNIPVmkwGFC73TZrypjD4fCQAK+I+ZfBVQLwZlerFXU6Her1eonreJ5HQRAQn2qj0TDukHm1Ws0Ix2O2260RrlQqpYqZtopVAoi1y+UyHY9Hk0O32w3FkI06jkO+74cC8Dh2y36/p8lkQovFgqrVqhFDEzONCCoB5OSk7qMl0Gw2w/Lo9/vmVMUBnGi0zi3Loul0SpVKJXRDmphvF0BOS049+n46nW5sHRVAXMAuiTZObcxnRVA5IN4DJHnXdU3dc+OLP/V63Vhd5haLRVM+0jg1MZ/dPI9XCZDUsbmuxc6SkGxKHCDzGJ2j0cj0A/7Mwti2fUOWR2Km2bxagHgt83sUgfcEkN4RLx0phfjvgEdi/psAaRf+lHmqEviUTWjygAC4EcKNEG6EcCOk6aJZnwsKgAKgACgACmS9k2vyBwVAAVAAFAAFNF0063NBAVAAFAAFQIGsd3JN/qBA3inwDTUHcp+19ttaAAAAAElFTkSuQmCC" style="width: 64px; height: 64px;">
            </a>
            <div class="media-body">
                <ion:id_article_comment prefix="lang('module_comments_label_id_article_comment'). : " /><br />
                <ion:id_article prefix="lang('module_comments_label_id_article'). : " /><br />
                <ion:author  prefix="lang('module_comments_label_author'). : " /><br />
                <ion:email prefix="lang('module_comments_label_email'). : " /><br />
                <ion:site prefix="lang('module_comments_label_site'). : " /><br />
                <ion:content prefix="lang('module_comments_label_content'). : " /><br />
                <ion:ip prefix="lang('module_comments_label_ip'). : " /><br />
                <ion:status prefix="lang('module_comments_label_status'). : " /><br />
                <ion:created format="d-m-Y" prefix="lang('module_comments_label_created'). : " /><br />
                <ion:updated format="d-m-Y" prefix="lang('module_comments_label_updated'). : " /><br />
                <ion:admin prefix="lang('module_comments_label_admin'). : " />
            </div>
        </div>
        <hr />
    </ion:comments>
</ion:comments>