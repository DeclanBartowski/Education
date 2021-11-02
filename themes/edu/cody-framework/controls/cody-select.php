<?php

if ( ! class_exists( 'WP_Customize_Control' ) )
    return NULL;

/**
 * A class to create a dropdown for custom select
 */
class CF_Select_Control extends WP_Customize_Control {


	/**
	 * Relation to elements with the children class
	 */
	public $relation = '';
	
	
	/**
	 * Multiselect
	 */
	public $multi = 0;
	
	
	/**
	 * Items of select
	 */
	public $choices = array();
	

    /**
     * Render the content of the category dropdown
     *
     * @return HTML
     */
    public function render_content() {
		
		$multiple = '';
		if ( $this->multi == 1 ) {
			$multiple = 'multiple';
		}
		
		if( $this->choices ) {
			?>
			<div class="<?php echo $this->relation; ?>">
				<label>
				  <span class="customize-control-title"><?php echo esc_html($this->label); ?><span class="cody-help" data-title="<?php echo wp_kses_post($this->description); ?>"></span></span>
				  <select <?php $this->link(); echo $multiple; ?>>
					   <?php
							foreach ( $this->choices as $key=>$val ) {
								printf( '<option value="%s" %s>%s</option>', $key, selected( $this->value(), $val, false ), $val );
							}
					   ?>
				  </select>
				</label>
			</div>
			<?php
		} else { ?>
			<div class="<?php echo $this->relation; ?>">
				<label>
				  <span class="customize-control-title">
					<?php echo esc_html($this->label); ?>
					<span class="cody-help" data-title="<?php echo wp_kses_post($this->description); ?>"></span>
				</span>
				  <?php echo esc_html( 'Items not found' ); ?>
				</label>
			</div>
		<?php }
    }
}