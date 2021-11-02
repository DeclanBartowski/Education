<?php

if ( ! defined( 'ABSPATH' ) ) exit;


if ( ! class_exists( 'WP_Customize_Control' ) )
    return NULL;


/**
 * Class to create a custom layout control
 */
class CF_Color_Scheme_Control extends WP_Customize_Control{
	
	public $type = 'color-scheme';
	
	
	/**
	 * Relation to elements with the children class
	 */
	public $relation = '';
	

	public function render_content() { ?>
		<div class="customize_image_select customize-color-scheme <?php echo $this->relation; ?>">
			<span class="customize-control-title"><?php echo esc_html($this->label); ?><span class="cody-help" data-title="<?php echo wp_kses_post($this->description); ?>"></span></span>
				<input id="color-scheme" type="hidden" name="<?php echo esc_attr($this->id); ?>" value="<?php echo esc_attr($this->value()); ?>" <?php $this->link(); ?>/>
				<?php 
				foreach ( $this->choices as $key => $colors ) { ?>
					<label class="scheme-col-<?php echo count( $this->choices ); ?>">
						<?php 
						$name = $colors['0'];
						array_shift( $colors );
						$checked = '';
						if ( implode( '|', $colors ) == esc_attr( $this->value() ) ) {
							$checked = 'checked';
						}
						echo '<input type="radio" name="color-scheme" value="' . $key . '" ' . $checked . '/>';
						echo '<div class="scheme">';
						echo '<div>';
						foreach ( $colors as $color ) {
							echo '<span class="scheme-col-' . count( $colors ) . '" title="' . $color . '" style="background-color: ' . $color . ';"></span>';
						}
						echo '</div>';
						echo '<div class="sheme-name" data-color="' . implode( '|', $colors ) . '">' . $name . '</div>';
						?>
						</div>
					</label>
				<?php }; ?>
		</div>
	<?php
	}
}