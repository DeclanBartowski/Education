<?php

if ( ! class_exists( 'WP_Customize_Control' ) )
    return NULL;

/**
 * A class to create a dropdown for all google fonts
 */
class CF_Google_Font_Dropdown_Control extends WP_Customize_Control {
	
	
    private $fonts = false;

	
    public function __construct($manager, $id, $args = array(), $options = array()) {
        $this->fonts = $this->get_fonts();
        parent::__construct( $manager, $id, $args );
    }
	
	
	/**
	 * Relation to elements with the children class
	 */
	public $relation = '';
	
	
	/**
	 * Multiselect
	 */
	public $subsets = '';
	

    /**
     * Render the content of the category dropdown
     *
     * @return HTML
     */
    public function render_content() {
		
        if(!empty($this->fonts)) {
            ?>
			<div class="<?php echo $this->relation; ?>">
                <label>
                    <span class="customize-control-title"><?php echo esc_html($this->label); ?><span class="cody-help" data-title="<?php echo wp_kses_post($this->description); ?>"></span></span>
                    <select <?php $this->link(); ?>>
                        <?php
                            foreach ( $this->fonts as $k => $v ) {
                                printf('<option value="%s" %s>%s</option>', $k, selected($this->value(), $k, false), $v->family);
                            }
                        ?>
                    </select>
                </label>
			</div>
            <?php
        }
    }

    /**
     * Get the google fonts from the API or in the cache
     *
     * @param  integer $amount
     *
     * @return String
     */
    public function get_fonts( $amount = 'all' ) {
        $selectDirectory = get_stylesheet_directory().'/cody-framework/controls/';
        $selectDirectoryInc = get_stylesheet_directory().'/cody-framework/controls/';

        $finalselectDirectory = '';

        if(is_dir($selectDirectory)) {
            $finalselectDirectory = $selectDirectory;
        }

        if(is_dir($selectDirectoryInc)) {
            $finalselectDirectory = $selectDirectoryInc;
        }

        $fontFile = $finalselectDirectory . '/cache/google-web-fonts.txt';

        //Total time the file will be cached in seconds, set to a week
        $cachetime = 86400 * 7;

        if(file_exists($fontFile) && $cachetime < filemtime($fontFile)) {
            $content = json_decode(file_get_contents($fontFile));
			asort( $content->items );
			
			echo '<pre>';
			print_r( $this->subsets );
			echo '</pre>';
			
        } else {
            $googleApi = 'https://www.googleapis.com/webfonts/v1/webfonts?sort=popularity&key={API_KEY}';
            $fontContent = wp_remote_get( $googleApi, array('sslverify'   => false) );
            $fp = fopen($fontFile, 'w');
            fwrite($fp, $fontContent['body']);
            fclose($fp);
            $content = json_decode($fontContent['body']);
        }

        if($amount == 'all') {
            return $content->items;
        } else {
            return array_slice($content->items, 0, $amount);
        }
    }
}