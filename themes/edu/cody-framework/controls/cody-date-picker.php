<?php

if ( ! defined( 'ABSPATH' ) ) exit;



if ( ! class_exists( 'WP_Customize_Control' ) )
    return NULL;


/**
 * Class to create a custom date picker
 */
class CF_Date_Picker_Control extends WP_Customize_Control {
    /**
    * Enqueue the styles and scripts
    */
    public function enqueue() {
        wp_enqueue_style( 'jquery-ui-datepicker' );
    }
	
	
	/**
	 * Relation to elements with the children class
	 */
	public $relation = '';
	
	
    /**
    * Render the content on the theme customizer page
    */
    public function render_content() {
        ?>
		<div class="<?php echo $this->relation; ?>">
            <label>
			  <span class="customize-control-title"><?php echo esc_html($this->label); ?><span class="cody-help" data-title="<?php echo esc_html($this->description); ?>"></span></span>
              <input type="date" id="<?php echo $this->id; ?>" name="<?php echo $this->id; ?>" value="<?php echo $this->value(); ?>" class="datepicker" <?php $this->link(); ?>/>
            </label>
		</div>
        <?php
    }
}