# Comments Module For [Ionize CMS](http://ionizecms.com "Ionize CMS") #
> Module allowing you to manage comments.


**Author :** [İskender TOTOĞLU](http://altivebir.com.tr "ALTI ve BIR IT.")

**Version :** 0.9.1

**Ionize Version :** 1.0.4

For manage comments for article you can use admin panel, You can see comment manage section in article edit mode.

## Ionize Tags ##
>Base Tag

	<ion:comments>
		.......
	</ion:comments>
>Listing Comments

	<ion:comments>
		<ion:list>
			<ion:id_article_comment />
            <ion:id_article />
            <ion:author />
            <ion:email />
            <ion:site />
            <ion:content />
            <ion:ip />
            <ion:status />
			<ion:time_ago />
            <ion:created />
            <ion:updated />
            <ion:admin />
			<ion:gravatar />
		</ion:list>
	</ion:comments>
>Comment Count Tag

	<ion:comments>
		<ion:count /> <!-- Display "Published" comments count result -->
		<ion:count field="pending" /> <!-- Display "Pending" comments result -->
		<ion:count field="all" /> <!-- Display "(Pending + Published)" comments result  -->
	</ion:comments>

>Comment Authority

	<ion:comments>
		<ion:can role="manage"> <!-- Roles : view, manage, create, delete, status -->
			<!-- If user have permission show content -->
			You have permission to see this section!
		</ion:can>
	</ion:comments>
>View Tag (Prepared 2 Example view file, you can use)

	<ion:comments>
		<!--
			Attributes :
				allowed = "TRUE | FALSE" If comment allowed show view file
				show	= "TRUE | FALSE" If allowed return "false" and ' show="TRUE" ' show view file
				error	= "TRUE | FALSE" If TRUE show error message
		-->
		<ion:view file="article_comments" allowed="true" show="true" />
		<ion:view file="article_comment_form" allowed="true" error="true" />
	</ion:comments>

>You will see **"files_for_your_template"** folder copy folders to your theme folder, under this folder.
>**config, libraries**

Theese folders for form validation and database save action, also you can send mail to user and admin by using **Comment** library