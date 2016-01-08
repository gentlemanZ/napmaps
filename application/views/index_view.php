
<?php echo $map['js'];?>
<?php echo $map['html'];?>

<!-- hero area (the grey one with a slider -->
<section id="hero" class="clearfix">    


<!-- main content area -->   
<div class="wrapper" id="main"> 

	<!-- content area -->    
	<section id="content" class="wide-content">
		<h1>Welcome to Napmaps!</h1>
		<ul>
			<li>Need sleep for the busy peeps? </li>
			<li>Wanna stay away from your daily creeps? </li>
            <li>Getaway in one of these couches in only one leap. 
                Only minutes away from counting sheep. </li>


		</ul>
		<h1>Upcoming changes</h1>
		<ul>
            <li>multi language translation (translating one file translates whole Napmaps)</li>
            <li>Add column location and make name for usernames. </li>
            <li>Add column timestamp.</li>
            <li>empty comments? vs. just changing the status</li>
            <li>Picture uploads</li>
            <li>users can edit and delete comments</li>
            <li>differentiate admin versus student users.</li>
            <li>Description of project</li>
		</ul>
	</section><!-- #end content area -->
</div>


<div class="wrapper" id="demo"> 

	<!-- content area -->    
	<section id="content" class="wide-content">
		<h1>Demo</h1>
        <p>Funcitons you can use:</p>
		<ul>
            <li>user authentication (BU student or guest)</li>
			<li>user management (login, register)</li>
			<li>adding Locations and comments in flow (Location -> Add comment -> update map info -> display)</li>
			<li>action log (who?, when?, what?)</li>
        </ul>
		<p>To signin please use following administrator's data.</p>
		<ul>
			<li>login: <b>root</b></li>
			<li>password: <b>root</b></li>
		</ul>
        <p>You can also sign up with your own infomation</p>
        <p>For how to use our map, you can view the video below or click <?php echo anchor("https://www.youtube.com/watch?v=WAy3XHcquCs&feature=youtu.be", "here"); ?></p>
        <iframe width="1280" height="720" src="https://www.youtube.com/embed/WAy3XHcquCs" frameborder="0" allowfullscreen></iframe>
	</section><!-- #end content area -->
</div><!-- #end div #main .wrapper -->

<?php $this->load->view('template/footer_view.php'); ?>