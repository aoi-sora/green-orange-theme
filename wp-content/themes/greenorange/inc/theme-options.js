var farbtastic;

(function($){
	
	/* disable color picker for link and color scheme for now
	var pickColor = function(a) {
		farbtastic.setColor(a);
		$('#link-color').val(a);
		$('#link-color-example').css('background-color', a);
	};
	*/

	$(document).ready( function() {
		/* disable color picker for link and color scheme for now
		$('#default-color').wrapInner('<a href="#" />');

		farbtastic = $.farbtastic('#colorPickerDiv', pickColor);

		pickColor( $('#link-color').val() );

		$('.pickcolor').click( function(e) {
			$('#colorPickerDiv').show();
			e.preventDefault();
		});

		$('#link-color').keyup( function() {
			var a = $('#link-color').val(),
				b = a;

			a = a.replace(/[^a-fA-F0-9]/, '');
			if ( '#' + a !== b )
				$('#link-color').val(a);
			if ( a.length === 3 || a.length === 6 )
				pickColor( '#' + a );
		});
		
		

		$(document).mousedown( function() {
			$('#colorPickerDiv').hide();
		});

		$('#default-color a').click( function(e) {
			pickColor( '#' + this.innerHTML.replace(/[^a-fA-F0-9]/, '') );
			e.preventDefault();
		});

		$('.image-radio-option.color-scheme input:radio').change( function() {
			var currentDefault = $('#default-color a'),
				newDefault = $(this).next().val();

			if ( $('#link-color').val() == currentDefault.text() )
				pickColor( newDefault );

			currentDefault.text( newDefault );
		});
		*/
		
		
		
		/* additional for favico field */
		jQuery('#favico_url_button').click(function() {
			formfield = $(this).prev().attr('id');
			tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
			return false;
		});
		
		/* per post option : Portfolio and Sliding Image Post thumbnail upload */
		jQuery('#thumbnail-upload-button').click(function() {
			formfield = $(this).prev().attr('id');
			tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
			return false;
		});		
		

		window.send_to_editor = function(html) {
		console.log(window)
 		
			console.log(html)
			imgurl = $('img', html).attr('src');			
			$('#'+formfield).val(imgurl)
			/* post id */
			var image_post_id
			image_post_id = $('img', html).attr('class')
			if($('#thumbnail-class').length >0 ) {
				var temp = image_post_id.split("-")
				image_post_id = temp.pop()
				$('#thumbnail-class').val(image_post_id)
			}
			tb_remove();
		}
		
		/* upload dialog for post thumbnail  to be saved in post custom fields */
		
		
		
	});
})(jQuery);