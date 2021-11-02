<?php

/* 
 * @author :http://braadmartin.com/alpha-color-picker-control-for-the-wordpress-customizer/
 */

if ( ! defined( 'ABSPATH' ) ) exit;


if ( ! class_exists( 'WP_Customize_Control' ) )
    return NULL;
/**
 * Class to create a custom tags control
 */
class CF_Color_Control extends WP_Customize_Control {
	/**
	 * Official control name.
	 */
	public $type = 'alpha-color';
	/**
	 * Add support for palettes to be passed in.
	 *
	 * Supported palette values are true, false, or an array of RGBa and Hex colors.
	 */
	public $palette;
	/**
	 * Add support for showing the opacity value on the slider handle.
	 */
	public $show_opacity;
	
	
	/**
	 * Relation to elements with the children class
	 */
	public $relation = '';

	
	public function enqueue() {
		wp_enqueue_script( 'wp-color-picker' );
		wp_enqueue_style( 'wp-color-picker' );
	}
	

	/**
	 * Render the control.
	 */
	public function render_content() {
		// Process the palette
		if ( is_array( $this->palette ) ) {
			$palette = implode( '|', $this->palette );
		} else {
			// Default to true.
			$palette = ( false === $this->palette || 'false' === $this->palette ) ? 'false' : 'true';
		}
		// Support passing show_opacity as string or boolean. Default to true.
		$show_opacity = ( false === $this->show_opacity || 'false' === $this->show_opacity ) ? 'false' : 'true';
		// Begin the output. ?>
		<div id="cody-select-color" class="<?php echo $this->relation; ?>">
			<label>
				<span class="customize-control-title">
					<?php 
						if ( isset( $this->label ) && '' !== $this->label ) {
							echo sanitize_text_field( $this->label );
						}
					?>
					<span class="cody-help" data-title="<?php
						if ( isset( $this->description ) && '' !== $this->description ) {
							echo sanitize_text_field( $this->description );
						}
					?>"></span>
				</span>
			</label>
			<input class="alpha-color-control" type="text" data-show-opacity="<?php echo $show_opacity; ?>" data-palette="<?php echo esc_attr( $palette ); ?>" data-default-color="<?php echo esc_attr( $this->settings['default']->default ); ?>" <?php $this->link(); ?>  />
		</div>
		<?php
	}
}