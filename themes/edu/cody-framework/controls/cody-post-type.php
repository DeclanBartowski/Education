<?php
if ( ! class_exists( 'WP_Customize_Control' ) )
    return NULL;
/**
 * Class to create a custom post type control
 */
class CF_Post_Type_Control extends WP_Customize_Control {
    private $postTypes = false;

    public function __construct($manager, $id, $args = array(), $options = array()) {
        $postargs = wp_parse_args($options, array('public' => true));
        $this->postTypes = get_post_types($postargs, 'object');

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
    * Render the content on the theme customizer page
    */
    public function render_content() {
		
		$multiple = '';
		if ( $this->multi == 1 ) {
			$multiple = 'multiple';
		}
		
        if(empty($this->postTypes)) {
            return false;
        }
        ?>
		<div class="<?php echo $this->relation; ?>">
            <label>
                <span class="customize-control-title"><?php echo esc_html($this->label); ?><span class="cody-help" data-title="<?php echo wp_kses_post($this->description); ?>"></span></span>
                <select name="<?php echo $this->id; ?>" id="<?php echo $this->id; ?>" <?php $this->link(); echo $multiple; ?>>
                <?php
                    foreach ( $this->postTypes as $k => $post_type ) {
                        printf('<option value="%s" %s>%s</option>', $k, selected($this->value(), $k, false), $post_type->labels->name);
                    }
                ?>
                </select>
            </label>
		</div>
        <?php
    }
}
?>