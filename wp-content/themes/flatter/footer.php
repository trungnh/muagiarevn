<div id="footer">
	<div class="panel">

		<div class="panel-holder">

		<?php if ( ! dynamic_sidebar( 'sidebar_footer' ) ) : ?>

		<!-- no dynamic sidebar so don't do anything -->
		<div id="widgetized-area">

			<?php if ( ! dynamic_sidebar( 'widgetized-area' ) ) : ?>

				<div class="pre-widget">

					<p><strong><?php _e( 'Widgetized Area', APP_TD ); ?></strong></p>
					<p><?php _e( 'The footer is active and ready for you to add some widgets via the Clipper admin panel.', APP_TD ); ?></p>

				</div>

			<?php endif; ?>

		</div> <!-- widgetized-area -->

		<?php endif; ?>

		</div> <!-- panel-holder -->

	</div> <!-- panel -->

	<div class="bar">

		<div class="bar-holder">

			<?php wp_nav_menu( array( 'theme_location' => 'secondary', 'container' => '', 'depth' => 1, 'fallback_cb' => false ) ); ?>
			<p><?php _e( 'Copyright &copy;', APP_TD ); ?> <?php echo date('Y'); ?> | <?php _e( 'Mua Giá Rẻ', APP_TD ); ?></p>

		</div>

	</div>
</div> <!-- #footer -->
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-99582061-1', 'auto');
  ga('send', 'pageview');

</script>