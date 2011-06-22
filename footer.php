	</div><!-- Main end -->

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
	window.Whiteboard = {
		theme_dir: "<?php echo WB_THEME_DIR;?>"
	}
	
	if(!window.jQuery){		
		console.warn("Notice: Can't load jQuery from the Google CDN. Falling back to local copy.");
		document.write("<script src='<?php echo WB_JS_DIR;?>library/jquery.min.js'>\x3C/script>")
	}
</script>
<script src="<?php echo WB_JS_DIR;?>all.min.js" type="text/javascript" charset="utf-8"></script>

</body>

</html>