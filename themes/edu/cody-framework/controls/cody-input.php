<?php

if ( ! defined( 'ABSPATH' ) ) exit;


class CF_Input_Text_Control extends WP_Customize_Control {
	
	
	/**
	 * Relation to elements with the children class
	 */
	public $relation = '';
	
	
	/**
	 * Html of control
	 */
	public function render_content() {
		?>
		<div class="<?php echo $this->relation; ?>">
            <label>
                <span class="customize-control-title"><?php echo esc_html($this->label); ?><span class="cody-help" data-title="<?php echo esc_html($this->description); ?>"></span></span>
                <input type="text" <?php $this->link(); ?> value="<?php $this->value(); ?>">
            </label>
		</div>
        <?php
    }
}