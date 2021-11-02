<?php
/**
 * Customize for taxonomy with dropdown, extend the WP customizer
 */

if ( ! class_exists( 'WP_Customize_Control' ) )
	return NULL;

class CF_Taxonomy_Control extends WP_Customize_Control {
	private $options = false;

    public function __construct($manager, $id, $args = array(), $options = array()) {
        $this->options = $options;

        parent::__construct( $manager, $id, $args );
    }
	
	public $tax = 'category';
	
	
	/**
	 * Relation to elements with the children class
	 */
	public $relation = '';
	
	
	/**
	 * Multiselect
	 */
	public $multi = 0;
	
	

	/**
	 * Render the control's content.
	 *
	 * Allows the content to be overriden without having to rewrite the wrapper.
	 *
	 * @since   11/14/2012
	 * @return  void
	 */
	public function render_content() {
        // call wp_dropdown_cats to get data and add to select field
        add_action( 'wp_dropdown_cats', array( $this, 'wp_dropdown_cats' ) );

		// Set defaults
		$this->defaults = array(
			'orderby'          => 'name',
			'hide_empty'       => 0,
			'id'               => $this->id,
			'selected'         => $this->value(),
			'taxonomy'         => $this->tax
		);

		// parse defaults and user data
		$cats = wp_parse_args(
			$this->options,
			$this->defaults
		);
		
		$multiple = '';
		if ( $this->multi == 1 ) {
			$multiple = 'multiple';
		}

		?>
		<div class="<?php echo $this->relation; ?>">
			<label>
				<span class="customize-control-title"><?php echo esc_html($this->label); ?><span class="cody-help" data-title="<?php echo wp_kses_post($this->description); ?>"></span></span>
				<?php wp_dropdown_categories( $cats ); ?>
			</label>
		</div>
		<?php
	}

    /**
     * Replace WP default dropdown
     *
     * @since   11/14/2012
     * @return  String $output
     */
    public function wp_dropdown_cats( $output ) {
        $output = str_replace( '<select', '<select ' . $this->get_link() , $output );

        return $output;
    }
}