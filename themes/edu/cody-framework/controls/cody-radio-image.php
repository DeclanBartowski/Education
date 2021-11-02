<?php

if ( ! defined( 'ABSPATH' ) ) exit;


if ( ! class_exists( 'WP_Customize_Control' ) )
    return NULL;


/**
 * Class to create a custom layout control
 */
class CF_Radio_Image_Control extends WP_Customize_Control{
	
	
	public $type = 'image_select';
	
	
	/**
	 * Relation to elements with the children class
	 */
	public $relation = '';
	

	public function render_content(){
	?>
		<div class="customize_image_select <?php echo $this->relation; ?>">
			<span class="customize-control-title"><?php echo esc_html($this->label); ?><span class="cody-help" data-title="<?php echo wp_kses_post($this->description); ?>"></span></span>
				<?php 
				foreach ( $this->choices as $key => $img ) { ?>
					<label>
						<input type="radio" name="<?php echo esc_attr($this->id); ?>" value="<?php echo $key; ?>" <?php $this->link(); ?> <?php checked( $key, esc_attr($this->value()) );?>/>
						<img src="<?php echo get_template_directory_uri() . '/cody-framework/img/' . $img ?>" />
					</label>
				<?php }; ?>
		</div>
	<?php
	}
}