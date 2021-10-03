<div class="my_form_wrap">

<form  id="custom-form" method="post" action="#" enctype="multipart/form-data"> 
  <label>Title</label>
      <input type="text" name="title" id="title">
  <label>Description</label>
      <textarea  type="text" name="textarea" id="desc">description</textarea>
  <label>UploadImage</label>
      <input type="file" id="image" name="my_file_upload[]" multiple="multiple">
  <label>Size</label>
	  <select multiple="multiple" id="size">
		<?php 
			$size = get_field_object( 'size' );
			foreach ($size['choices'] as $key => $value) {
			echo '<option value="'.$key.'">'.$value.'</option>';
			}
		?>
	  </select>
  <label>Color</label>
	  <select multiple="multiple" id="color">
	    <?php 
			$color = get_field_object( 'color' );
			foreach ($color['choices'] as $key => $value) {
			echo '<option value="'.$key.'">'.$value.'</option>';
			}
		?>
	  </select>
  <label>Sex</label>
	  <select multiple="multiple" id="sex">
	     <?php 
			$sex = get_field_object( 'sex' );
			foreach ($sex['choices'] as $key => $value) {
			echo '<option value="'.$key.'">'.$value.'</option>';
			}
		?>
	  </select>
  <label>Clothes-type</label>
      <select multiple="multiple" id="term">
	     <?php 
			$terms = get_terms( [
				'taxonomy' => 'clothes-type',
				'hide_empty' => false,
			]);

			foreach ($terms as $term) {
			echo '<option value="'.$term->name.'">'.$term->name.'</option>';
			}
		?>
	  </select>
	  <?php wp_nonce_field('nonce_clothes', 'custom_nonce_field'); ?>
	  <br>
  <button type="submit" name="submit" value="Upload">Create</button>

</form>
	
</div>