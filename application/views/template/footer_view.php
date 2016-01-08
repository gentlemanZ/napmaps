<!-- footer area -->    
<footer>
	<div id="colophon" class="wrapper clearfix">
		<?php echo $this->lang->line('footer_text') . ' ' . VERSION; ?>
    </div>

   
	<div id="attribution" class="wrapper clearfix" style="color:#666; font-size:11px;">
		Site built with <a href="http://www.prowebdesign.ro/simple-responsive-template/" target="_blank" title="Simple Responsive Template is a free software by www.prowebdesign.ro" style="color:#777;">Simple Responsive Template</a>
		<br/>
		<?php
		if ($this->session->userdata('user_id')) {
			echo 'Session user_id: (' . $this->session->userdata('user_id') . ')';
		}
		if ($this->session->userdata('update') && $this->session->userdata('version')) {
			echo ' This version: (' . $this->session->userdata('version') . ') Available version: (' . $this->session->userdata('update') . ')';
		}
		?>
	</div><!--end attribution-->

</footer><!-- #end footer area --> 


<!-- jQuery -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="<?php echo base_url(); ?>js/libs/jquery-1.9.0.min.js">\x3C/script>')</script>

<script defer src="<?php echo base_url(); ?>js/flexslider/jquery.flexslider-min.js"></script>

<!-- fire ups - read this file!  -->   
<script src="<?php echo base_url(); ?>js/main.js"></script>

<!-- tables to CSV -->
<?php if ($this->router->fetch_class() != 'main') { ?>
<script type="text/javascript" src="http://jqueryjs.googlecode.com/files/jquery-1.3.1.min.js" ></script> 
<script type="text/javascript" src="<?php echo base_url(); ?>js/table2CSV.js" ></script>
<?php } ?>
</body>
</html>