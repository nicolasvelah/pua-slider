<link rel="stylesheet" href="<?php echo $slider_view_path ?>css/slider.css">
<div class="slide_visor" style=" min-width:<?php echo $slide_width?>; min-height:<?php echo $slide_height?>;">
	<div class="slide_group">
	<?php
		if($slides[$id]){
			foreach ($slides[$id] as $clave => $slide) {
				if(is_numeric($clave)){
					echo '
						<div class="slide_image_front" id="slide-element-front-'.$frond_counter.'">
							<img src="'.$slide[1].'" class="image-front" id="image_item-'.$frond_counter.'" image-id="'.$frond_counter.'" style="top:'.$slide[3].'; left:'.$slide[4].';">
						</div>							
					';
					$frond_counter++;
				}
			}
		}
	?>
	</div>
</div>