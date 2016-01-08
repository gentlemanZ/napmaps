<?php $this->load->view('template/header_view.php');
      echo $map['js'];
      echo $map['html'];
    ?>
 


<section id="page-header" class="clearfix">   
	<div class="wrapper">
		<h1><?php echo $this->lang->line('h1_add_product_production'); ?></h1>
    </div>

</section>


<!-- main content area -->   
<div class="wrapper" id="main"> 

	<!-- content area -->    
	<section id="content" class="wide-content">
		<div class="grid_4">
			<form action="" method="POST">
				<input type="hidden" name="sent" value="yes">
				<div class="label"><?php echo $this->lang->line('product'); ?></div>
				<select name="id">
					<?php foreach ($products as $product) { ?>
						<option value="<?php
						if (isset($product['name'])) {
							echo $product['name'];
						}
						?>">
									<?php
									if (isset($product['name'])) {
										echo $product['name'];
									}
									?>
						</option>
					<?php } ?>
				</select>
                <!-- this is the status drop down. -->
                <div class="label"><?php echo $this->lang->line('h1_status'); ?></div>
				<select name="status">
						<option value="open" selected="true"> Open </option>
                        <option value="close" selected="true"> Close </option>
				</select>

				<div class="label"><?php echo $this->lang->line('amount'); ?></div>
				<textarea name="amount" style="overflow:auto;resize:none" rows="7" cols="42"></textarea><br />
				<input type="submit" value="<?php echo $this->lang->line('submit C'); ?>">
			</form>
		</div>
		<div class="grid_8">
			<table>
				<tr>
					<th><?php echo $this->lang->line('name'); ?></th>
					<th><?php echo $this->lang->line('amount'); ?></th>

				<?php foreach ($reports as $report) { ?>
					<tr>
						<td><?php echo $report['name']; ?></td>
						<td><?php echo $report['desc']; ?></td>
						
					</tr>
				<?php } ?>			
			</table>
		</div>
	</section><!-- #end content area -->

</div><!-- #end div #main .wrapper -->

<?php $this->load->view('template/footer_view.php'); ?>