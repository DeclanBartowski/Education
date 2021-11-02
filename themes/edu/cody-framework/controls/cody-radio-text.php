<?php

if ( ! defined( 'ABSPATH' ) ) exit;


if ( ! class_exists( 'WP_Customize_Control' ) )
    return NULL;


/**
 * Class to create a custom control
 */
class CF_Radio_Text_Control extends WP_Customize_Control{
	
	
	public $type = 'text_radio';
	
	
	/**
	 * Relation to elements with the children class
	 */
	public $relation = '';
	

	public function render_content(){
	?>
		<div class="cf-text-radio <?php echo $this->relation; ?>">
			<span class="customize-control-title">
				<?php echo esc_html($this->label); ?>
				<span class="cody-help" data-title="<?php echo wp_kses_post($this->description); ?>"></span>
			</span>
			<div class="cf-radio-box">
			<?php 
			foreach ( $this->choices as $key => $text ) { ?>
				<label class="scheme-col-<?php echo count( $this->choices ); ?>">
					<input type="radio" name="<?php echo esc_attr($this->id); ?>" value="<?php echo $key; ?>" <?php $this->link(); ?> <?php checked( $key, esc_attr($this->value()) );?>/>
					<?php echo esc_attr( $text ); ?>
				</label>
			<?php }; ?>
			</div>
		</div>
	<?php
	}
}