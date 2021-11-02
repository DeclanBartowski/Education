<?php
if ( ! class_exists( 'WP_Customize_Control' ) )
    return NULL;

/**
 * Class to create a custom post control
 */
class CF_Multi_Input_Control extends WP_Customize_Control{
	
	
	public $type = 'multi_input';
	
	
	/**
	 * Relation to elements with the children class
	 */
	public $relation = '';
	

	
	
	public function render_content() {
		global $cody_l18n;	
		?>
		<div class="<?php echo $this->relation; ?>">
			<label class="customize_multi_input">
				<span class="customize-control-title"><?php echo esc_html($this->label); ?><span class="cody-help" data-title="<?php echo wp_kses_post($this->description); ?>"></span></span>
				<input type="hidden" id="<?php echo esc_attr($this->id); ?>" name="<?php echo esc_attr($this->id); ?>" value="<?php echo esc_attr($this->value()); ?>" class="customize_multi_value_field" <?php $this->link(); ?>/>
				<div class="customize_multi_fields">
					<?php $vals = explode( '|', esc_attr( $this->value() ) );
					foreach ( $vals as $val ) { ?>
					<div class="set">
						<input type="text" value="<?php echo $val; ?>" class="customize_multi_single_field"/>
						<a href="#" class="customize_multi_remove_field"></a>
					</div>
					<?php } ?>
				</div>
				<a href="#" class="button button-primary customize_multi_add_field"><?php _e( 'Add', $cody_l18n ); ?></a>
			</label>
		</div>
		<?php
	}
}