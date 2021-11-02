<?php

if ( ! defined( 'ABSPATH' ) ) exit;


if ( ! class_exists( 'WP_Customize_Control' ) )
    return NULL;
/**
 * Class to create a custom tags control
 */
class CF_Notice_Control extends WP_Customize_Control{
	
	
	public $type = 'info';
	
	
	/**
	 * Relation to elements with the children class
	 */
	public $relation = '';
	
	
	public function render_content(){
		?>
		<div class="cody-info <?php echo $this->relation; ?>">
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<p><?php echo wp_kses_post($this->description); ?></p>
		</div>
		<?php
	}
}