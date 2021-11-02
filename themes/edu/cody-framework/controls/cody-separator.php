<?php

if ( ! defined( 'ABSPATH' ) ) exit;


if ( ! class_exists( 'WP_Customize_Control' ) )
    return NULL;
/**
 * Class to create a custom tags control
 */
class CF_Separator_Control extends WP_Customize_Control {
	
	
	public $type = 'separator';
	
	
	/**
	 * Relation to elements with the children class
	 */
	public $relation = '';
	
	
	public function render_content(){
		?>
		<div class="<?php echo $this->relation; ?>">
			<p><hr></p>
		</div>
		<?php
	}
}