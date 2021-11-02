<?php

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Позволяет использовать контрол textarea на странице настройки темы
 */
class CF_Textarea_Control extends WP_Customize_Control {
	
	
	/**
	 * Relation to elements with the children class
	 */
	public $relation = '';
	
	
	public function render_content() {
		if ( $this->type == 'textarea' || $this->type == '' ) { ?>
		<div class="<?php echo $this->relation; ?>">
            <label>
                <span class="customize-control-title"><?php echo esc_html($this->label); ?><span class="cody-help" data-title="<?php echo esc_html($this->description); ?>"></span></span>
                <textarea rows="5" style="width:100%;" <?php $this->link(); ?>><?php echo esc_textarea($this->value()); ?></textarea>
            </label>
		</div>
        <?php
		} elseif ( $this->type == 'wp_editor' ) {
			?>
		<div class="<?php echo $this->relation; ?>">
            <label>
            <span class="customize-control-title"><?php echo esc_html($this->label); ?><span class="cody-help" data-title="<?php echo wp_kses_post($this->description); ?>"></span></span>
            <?php $settings = array(
                      'textarea_name' => $this->id
                  );
                  wp_editor($this->value(), $this->id, $settings ); ?>
            </label>
		</div>
        <?php
		}
    }
}