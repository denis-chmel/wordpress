<?php
/*
Template Name: Bootstrap Landing
*/
?>
<!DOCTYPE html>
<html lang="en-US">
<head>
	<meta charset="UTF-8"/>
	<title><?php wp_title() ?></title>
	<meta name="viewport" content="width=device-width,initial-scale=1"/>
	<link rel="stylesheet" href="/blog/wp-content/themes/agency-pro/landing/css/bootstrap.css" type="text/css" media="all"/>
	<link rel="stylesheet" href="/blog/wp-content/themes/agency-pro/landing/css/main.css" type="text/css" media="all"/>
</head>
<body>
<?php

the_post();
do_action('genesis_post_content');

?>

<div id="success-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title">Modal title</h4>
			</div>
			<div class="modal-body">
				<p>Curabitur eget mollis neque. Vestibulum fringilla nibh nec mauris interdum porta. Sed lobortis tortor lorem. Quisque eu ligula sem. Cras nisi quam, consectetur nec sodales in, pulvinar id nulla. Nunc placerat lorem urna, at tincidunt leo sollicitudin vitae. Suspendisse potenti.</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript" src="/blog/wp-content/themes/agency-pro/landing/js/jquery-2.1.1.min.js"></script>
<script type="text/javascript" src="/blog/wp-content/themes/agency-pro/landing/js/bootstrap.min.js"></script>
<script type="text/javascript">
	$(function(){
		$('#subscribe-form input').attr('required', true);
		$('#subscribe-form').submit(function(e) {
			e.preventDefault();

			var data = {
				email: $(this.email).val(),
				page_title: $('title').text(),
				page_url: window.location.href
			};

			$.ajax({
				type: "POST",
				url: this.action,
				crossDomain: true,
				data: data,
				success: function (response) {
					// $("#success-modal").modal();
					// Thank you, we'll be in touch asap.
					$('#intro .jumbotron-small').html("<p class='successfully-subscribed'>Thank you, we'll be in touch asap.</p>");
				},
				error: function (jqXHR, textStatus) {
					console.error(jqXHR, textStatus);
				}
			});

			return false;
		});
	});
</script>

<script>
	(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

	ga('create', 'UA-48341855-1', 'auto');
	ga('send', 'pageview');

</script>

</body>
</html>
