<?php

if ( ! defined( 'ABSPATH' ) ) exit;


if( class_exists( 'WP_Customize_Control' ) ) {
	class CF_Range_Slider_Control extends WP_Customize_Control {
		public $type = 'range';

        public function __construct( $manager, $id, $args = array() ) {
            parent::__construct( $manager, $id, $args );
            $defaults = array(
                'min'  => 0,
                'max'  => 10,
                'step' => 1,
				'unit' => ''
            );
            $args = wp_parse_args( $args, $defaults );

            $this->min = $args['min'];
            $this->max = $args['max'];
            $this->step = $args['step'];
            $this->unit = $args['unit'];
        }
	
	
		/**
		 * Relation to elements with the children class
		 */
		public $relation = '';
		

		public function render_content() {
		?>
		<div class="<?php echo $this->relation; ?>">
			<label>
				<span class="customize-control-title"><?php echo esc_html($this->label); ?><span class="cody-help" data-title="<?php echo wp_kses_post($this->description); ?>"></span></span>
				<input class="range-slider" min="<?php echo $this->min ?>" max="<?php echo $this->max ?>" step="<?php echo $this->step ?>" type="range" <?php $this->link(); ?> value="<?php echo esc_attr( $this->value() ); ?>" oninput="jQuery(this).next('input').val( jQuery(this).val() )">
				<input class="range-result" onKeyUp="jQuery(this).prev('input').val( jQuery(this).val() )" type="text" value="<?php echo esc_attr( $this->value() ); ?>">
				<span class="range-slider-unit"><?php echo esc_attr( $this->unit ); ?></span>
			</label>
		</div>
		<?php
		}
	}
}