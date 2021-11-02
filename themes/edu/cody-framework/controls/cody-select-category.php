<?php

if ( ! class_exists( 'WP_Customize_Control' ) )
    return NULL;

/**
 * A class to create a dropdown for all categories in your wordpress site
 */
class CF_Category_Dropdown_Control extends WP_Customize_Control {
	
	
    private $cats = false;

    public function __construct($manager, $id, $args = array(), $options = array()) {
        $this->cats = get_categories($options);

        parent::__construct( $manager, $id, $args );
    }
	
	
	/**
	 * Relation to elements with the children class
	 */
	public $relation = '';
	
	
	/**
	 * Multiselect
	 */
	public $multi = 0;
	

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
		
		if(!empty($this->cats)) {
			?>
			<div class="<?php echo $this->relation; ?>">
				<label>
				  <span class="customize-control-title"><?php echo esc_html($this->label); ?><span class="cody-help" data-title="<?php echo wp_kses_post($this->description); ?>"></span></span>
				  <select <?php $this->link(); echo $multiple; ?>>
					   <?php
							foreach ( $this->cats as $cat ) {
								printf('<option value="%s" %s>%s</option>', $cat->term_id, selected($this->value(), $cat->term_id, false), $cat->name);
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
				  <?php echo esc_html( 'No categories found.' ); ?>
				</label>
			</div>
		<?php }
    }
}