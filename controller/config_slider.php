<?php
function slider_list(){
	global $slider_view_path;

	$pua_sliders = get_option("pua_sliders");
	if($pua_sliders && !isset($_GET['id']) && !isset($_GET['new'])){
		include(__DIR__.'/../views/slider_list_form.php');
	}else{
		slider();
	}
	
}

function slider(){
	//delete_option( "pua_sliders");
	$pua_sliders = get_option("pua_sliders");
	if(isset($_GET['id'])){
		$id = $_GET['id'];
	}else if(isset($_GET['new'])){
		$id = count($pua_sliders) + 1;
		//echo '2'.$id;
	}

	if($id == ''){$id = 1;}
	
	
	$element_counter = count($pua_sliders[$id]);

	//Save data
	if (isset($_POST["update_settings"])) {

		$id = $_POST['id'];

		unset($pua_sliders[$id]);

		$slides_holder =[];
		$numcontrol = 1;
		foreach ($_POST as $key => $value){
			$item_id = substr(htmlspecialchars($key), -1);

 			if(is_numeric($item_id)){
 				if($numcontrol != $item_id){
 					$slides_holder[] = $sl_holder;
 					unset($sl_holder);
 					$numcontrol++;
 				}

 				$sl_holder[] = $value;
 			}

 			if($key == 'slider_title' || $key == 'id' || $key == 'slider_width' || $key == 'slider_height'){
 				$slides_holder[$key] = $value;
 			}
 		}
 		if($sl_holder){$slides_holder[] = $sl_holder;}
        $pua_sliders[$id] = $slides_holder;
        
        update_option("pua_sliders", $pua_sliders);
        ?>
            <div id="message" class="updated">Slide saved</div>
        <?php
	}

	if ( !function_exists('media_buttons') )
		include(ABSPATH . 'wp-admin/includes/media.php');
		if (is_admin()){
			echo '<div style="display:none">';
			do_action( 'media_buttons');
			echo '</div>';
		}	

	$slide_title = $pua_sliders[$id]['slider_title'];
	$slide_width_value = $pua_sliders[$id]['slider_width'];
	$slide_height_value = $pua_sliders[$id]['slider_height'];

	if(!$slide_width_value){
		$slide_width_value = '100';
		$slide_height_value = '3:1';
	}
	$slide_width = $slide_width_value.'%';
	$slide_height = explode(":",$slide_height_value);
	$slide_height = ($slide_height[1] * $slide_width)/ $slide_height[0].'vh';

	global $slider_view_path;
	
	include(__DIR__.'/../views/slider_form.php');

}


/*Eliminar slide*/

function delete_slide(){
	if($_POST['slide_id']){
		$slide_id = $_POST['slide_id'];
	}else{
		$slide_id = null;
	}
	$cat_slide_id = $_POST['cat_slide_id'];
	$id_slide = 1;
	$id_slide2 = 1;

	$pua_sliders = get_option("pua_sliders");
	$pua_sliders_holder = [];
	$$pua_sliders_tipo  = [];

	if($pua_sliders[$cat_slide_id] && $slide_id != null){
		foreach ($pua_sliders[$cat_slide_id] as $clave => $slide) {
			if(is_numeric($clave)){
				if($id_slide != $slide_id){
					$slide[2] = $id_slide2;
					array_push($pua_sliders_holder, $slide);
					$id_slide2++;
				}
				$id_slide++;
			}else{
				$pua_sliders_tipo[$clave] = $slide;
			}
		}
	
		$pua_sliders[$cat_slide_id] = $pua_sliders_holder;
		foreach ($pua_sliders_tipo as $clave => $tipo) {
			$pua_sliders[$cat_slide_id][$clave] = $tipo;
		}

		$resp = 'slide';
	}else{
		$pua_sliders_holder[0] = '';
		foreach ($pua_sliders as $slide) {
			if($slide['slider_title'] != $pua_sliders[$cat_slide_id]['slider_title']){
				$slide['id'] = $id_slide;
				array_push($pua_sliders_holder, $slide);
				$id_slide++;
			}

		}
		unset($pua_sliders_holder[0]);

		$pua_sliders = $pua_sliders_holder;

		$resp = 'cat';
	}
	update_option("pua_sliders", $pua_sliders);

	echo $resp;
}


add_action('wp_ajax_delete_puaslide', 'delete_slide');
add_action('wp_ajax_nopriv_delete_puaslide', 'delete_slide');