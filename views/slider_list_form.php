
<h2>Sliders</h2>
<a href="admin.php?page=slider_settings&new=new">New</a><br><br>
<?php 
	foreach ($pua_sliders as $slider) {
		echo '<a href="admin.php?page=slider_settings&id='.$slider['id'].'">'.$slider['slider_title'].'</a><br>
		<a href="#" id="remove'.$slider['id'].'" onclick=" get_delete_data(null, '.$slider['id'].')">Remove</a>
		<hr>';
	}

?>

<div id="display"></div>
<script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
<script type="text/javascript">
	var slider_activate = true;
	var adminUrl = '<?= admin_url(); ?>';

	var imported = document.createElement('script');
	imported.src = '<?= $slider_view_path ?>js/slider.js';
	document.head.appendChild(imported);
</script>