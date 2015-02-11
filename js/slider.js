 /*SLIDER ADMIN*/

/*BORRAR IMAGEN*/
function get_delete_data(id_slide, id_cat_slide){
    cat_id = id_cat_slide;

    if(id_slide == null){
        slide_id = "";
    }else{
        slide_id = "&slide_id=" + id_slide;
    }
    jQuery("#display").empty();
    jQuery.ajax({
        url: adminUrl + "admin-ajax.php",
        type:"POST",
        data:"action=delete_puaslide&cat_slide_id=" + cat_id + slide_id,
         
        success:function(results){
            if(results == 'cat0'){
                location.reload();
            }else{
                window.location.href = adminUrl + "admin.php?page=slider_settings&id=" + cat_id;
            }
        }
    });
}


/*ADD LATER TO SLIDE*/
layer_id = 0;
slider_id = '';
function add_layer(id){
    if(slider_id == ''){slider_id = id;}
    else if(slider_id != id){layer_id = 0;slider_id = id;}
    contend_image = jQuery('#slide-element-' + id);
    var newId = "slide-layer-"+ layer_id;

    var d = jQuery('#display').clone();
    d.attr("id", newId);
    d.text(contend_image.children('.title').attr('value'));

    contend_image.children('.slide_image').append(d);

    d.draggable();
    layer_id++;
}

jQuery(document).ready(function() { 

    /*Drag and drop order*/
    contenedor = jQuery( "#duplicate-list" );
    item_order = jQuery( ".postbox" );
    contenedor.sortable({
        update: function(event, ui) {
          contenedor.children('div').each(function(index){
            jQuery(this).attr('id', 'slide-element-' + (index + 1));

            jQuery(this).find("input.title").attr('name', 'img_title-'+ (index + 1));

            jQuery(this).find("input.url").attr('name', 'img_url-'+ (index + 1));

            jQuery(this).find("input.order").attr('value', index + 1);
            jQuery(this).find("input.order").attr('name', 'img_order-'+ (index + 1));

            jQuery(this).find("input.img_top").attr('name', 'img_top-'+ (index + 1));
            jQuery(this).find("input.img_left").attr('name', 'img_left-'+ (index + 1));

          });
        }
    });
    contenedor.disableSelection();

    /*Drag and drop slide*/
    jQuery(".image").click(function(e){
        var image_id = jQuery(this).attr('image-id');
        var curimg = jQuery(this);
        alto = jQuery(this).height();
        cur_pos = jQuery(this).position().top;
        jQuery(this).draggable({
            axis: "y",
            start: function() {
                
            },
            drag: function() {
               
            },
            stop: function() {
                imgleft = curimg.css('left');
                imgtop = curimg.css('top');

                jQuery('#img_top-'+image_id).attr('value', imgtop);
                jQuery('#img_left-'+image_id).attr('value', imgleft);
            }
        });
    });

    /*INSERT SLIDE*/
    var t=jQuery;
    jQuery("#insert-image").click(function(e){
        e.preventDefault();
        var i,l;
        return t.uploader?(t.uploader.open(),void 0):(l=window.slideshow_jquery_image_gallery_backend_script_editSlideshow,i="","object"==typeof l&&"object"==typeof l.localization&&void 0!==l.localization.uploaderTitle&&l.localization.uploaderTitle.length>0&&(i=l.localization.uploaderTitle),t.uploader=wp.media.frames.slideshow_jquery_image_galler_uploader=wp.media({frame:"select",title:i,multiple:!0,library:{type:"image"}}),
        t.uploader.on("select",function(){
            var e,i,l=t.uploader.state().get("selection").toJSON();
            for(i in l)l.hasOwnProperty(i)&&(e=l[i],insertImageSlide(e))
        }),
        t.uploader.open(),void 0)
    });

    function insertImageSlide(e){
        var d = jQuery('#slide_item').clone();
        var newId = "slide-element-"+ counter;
                            
        d.attr("id", newId);
        d.show();

        d.find(".imagen").attr("src",e.url),
        d.find(".imagen").attr("title",e.title),
        d.find(".imagen").attr("alt",e.alt),
        d.find(".title").attr("value",e.title),
        d.find(".title").attr("name",'img_title-'+counter),
        d.find(".url").attr("value",e.url),
        d.find(".url").attr("name",'img_url-'+counter)
        d.find(".order").attr("value",counter),
        d.find(".order").attr("name",'img_order-'+counter),
        d.find(".img_top").attr("name",'img_top-'+counter),
        d.find(".img_left").attr("name",'img_left-'+counter),
        d.find(".img_top").attr("id",'img_top-'+counter),
        d.find(".img_left").attr("id",'img_left-'+counter)

        var removeLink = jQuery("a", d).click(function() {
            jQuery(d).remove();
            counter--;  
            return false;
        });
        jQuery("#duplicate-list").append(d);
        jQuery("#element-max-id").attr("value",counter);
        counter++;
    }
});


