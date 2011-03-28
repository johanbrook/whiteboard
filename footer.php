	</section><!-- Main end -->

	<footer role="contentinfo">

		<p>
			<small>
				&copy; Copyright Your Name Here 2010. All Rights Reserved.
			</small>
		</p>
		
	</footer>

	
		
<?php wp_footer(); ?>
<script type="text/javascript">
	// Sets a window variable to the theme's absolute path
	window.THEME_DIR = "<?php echo JB_THEME_DIR;?>";
	
	if(!window.jQuery){		
		console.log("Notice: Whiteboard can't load jQuery from the Google CDN. Falling back to local copy.");
		document.write("<script src='<?php echo JB_JS_DIR;?>library/jquery-1.5.1.min.js'>\x3C/script>")
	}
</script>
<script src="<?php echo JB_JS_DIR;?>library/jquery.smoothscroll.min.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo JB_JS_DIR;?>whiteboard.js" type="text/javascript" charset="utf-8"></script>

</body>

</html>