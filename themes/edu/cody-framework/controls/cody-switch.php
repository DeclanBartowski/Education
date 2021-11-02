<?php

if ( ! defined( 'ABSPATH' ) ) exit;


if ( ! class_exists( 'WP_Customize_Control' ) )
    return NULL;


/**
 * Class to create a custom layout control
 */
class CF_Switch_Control extends WP_Customize_Control {
	
	public $type = 'switch';
	
	
	/**
	 * Relation to elements with the children class
	 */
	public $relation = '';

	
	/**
	 * The output of the control
	 */
	public function render_content(){
		?>
		<div class="checkbox_switch <?php echo $this->relation; ?>">
			<div class="onoffswitch">
			    <input type="checkbox" id="<?php echo esc_attr($this->id); ?>" name="<?php echo esc_attr($this->id); ?>" class="onoffswitch-checkbox" value="<?php echo esc_attr( $this->value() ); ?>" <?php $this->link(); checked( $this->value() ); ?>>
			    <label class="onoffswitch-label" for="<?php echo esc_attr($this->id); ?>"></label>
			</div>
			<span class="customize-control-title onoffswitch_label"><?php echo esc_html( $this->label ); ?></span>
			<p><?php echo wp_kses_post($this->description); ?></p>
		</div>
		<?php
	}
}