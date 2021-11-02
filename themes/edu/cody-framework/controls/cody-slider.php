<?php

if ( ! defined( 'ABSPATH' ) ) exit;


if ( ! class_exists( 'WP_Customize_Control' ) )
    return NULL;
/**
 * Class to create a custom tags control
 */
class CF_Slider_Control extends WP_Customize_Control{

	/**
	 * Relation to elements with the children class
	 */
	public $relation = '';
	
	/**
	 * Enable image
	 */
	public $img = '';
	
	/**
	 * Enable title
	 */
	public $title = '';
	
	/**
	 * Enable link
	 */
	public $link = '';
	
	/**
	 * Enable desc
	 */
	public $desc = '';
	
	/**
	 * Enable check
	 */
	public $check = '';
	

	public function render_content(){
		global $cody_l18n;
		?>
		<div class="slider-arr <?php echo $this->relation; ?>">
			<label>
				<span class="customize-control-title"><?php echo esc_html($this->label); ?><span class="cody-help" data-title="<?php echo wp_kses_post($this->description); ?>"></span></span>
				<input type="hidden" id="slider-arr" <?php $this->link(); ?> value="<?php echo $this->value(); ?>" >
			</label>
			<div class="slides-box">
				<div class="slide-default">
					<div class="slide-expand"><span class="slide-name"></span><span class="dashicons dashicons-arrow-down"></span></div>
					<div class="slide-content">
						<?php if ( $this->img == true ) : ?>
						<span class="slide-img">
							<img src="data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTguMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgdmlld0JveD0iMCAwIDI5NyAyOTciIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDI5NyAyOTc7IiB4bWw6c3BhY2U9InByZXNlcnZlIiB3aWR0aD0iMjU2cHgiIGhlaWdodD0iMjU2cHgiPgo8Zz4KCTxwYXRoIGQ9Ik0yOTQuMDYxLDEwMS4zOTVjLTEuODUxLTEuODQ5LTQuMzU5LTIuODg3LTYuOTc2LTIuODg3bC04OC42MTcsMC4wMTJsMC4wMTMtODguNjU1YzAtMi42MTctMS4wMzgtNS4xMjYtMi44ODgtNi45NzcgICBDMTkzLjc0MiwxLjAzOCwxOTEuMjMzLDAsMTg4LjYxNiwwbC04MC4xODgsMC4wMTJjLTUuNDQ1LDAuMDAyLTkuODU5LDQuNDE1LTkuODYsOS44NmwtMC4wMTYsODguNjYyTDkuOTI2LDk4LjU0OCAgIGMtNS40NDYsMC05Ljg2LDQuNDE1LTkuODYxLDkuODZMMC4wNTEsMTg4LjYzYzAsMi42MTgsMS4wMzgsNS4xMjYsMi44ODksNi45NzdjMS44NSwxLjg1LDQuMzU5LDIuODg4LDYuOTc2LDIuODg4bDg4LjYyMS0wLjAxMiAgIGwtMC4wMTQsODguNjUzYzAsMi42MTcsMS4wNCw1LjEyNiwyLjg4OSw2Ljk3N2MxLjg1MSwxLjg1LDQuMzYsMi44OSw2Ljk3NywyLjg4OGw4MC4xODctMC4wMTZjNS40NDUsMCw5Ljg1OS00LjQxNSw5Ljg2LTkuODYgICBsMC4wMTQtODguNjU4bDg4LjYyOS0wLjAxNmM1LjQ0NSwwLDkuODU5LTQuNDE1LDkuODYtOS44NmwwLjAxMi04MC4yMkMyOTYuOTQ5LDEwNS43NTQsMjk1LjkxMSwxMDMuMjQ2LDI5NC4wNjEsMTAxLjM5NXoiIGZpbGw9IiNiZGJkYmQiLz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8L3N2Zz4K" data-id=""/>
						</span>
						<?php endif; ?>
						<div class="slide-info">
						<?php if ( $this->title == true ) : ?>
							<span class="slide-title"><input type="text" value="" placeholder="<?php _e( 'Title', $cody_l18n ); ?>" /></span>
						<?php endif; ?>
						<?php if ( $this->link == true ) : ?>
							<span class="slide-link"><input type="text" value="" placeholder="<?php _e( 'Link', $cody_l18n ); ?>" /></span>
						<?php endif; ?>
						<?php if ( $this->desc == true ) : ?>
							<span class="slide-desc"><textarea placeholder="<?php _e( 'Description', $cody_l18n ); ?>"></textarea></span>
						<?php endif; ?>
						<?php if ( $this->check == true ) : ?>
							<span class="slide-check"><input type="checkbox" /></span>
						<?php endif; ?>
							<span class="slide-remove dashicons dashicons-trash"></span>
						</div>
					</div>
				</div>
				<?php 
				$slides = '';
				if ( $this->value() != '' ) {
					$slides = json_decode( '[' . $this->value() . ']', true );
				}
				if ( $slides ) {					
					foreach ( $slides as $slide ) {
						foreach ( $slide as $sl ) {
						if ( $this->title == true ) {
							if ( isset($sl['title']) && $sl['title'] ) {
								$title = $sl['title'];
							} else {
								$title = __( 'Title', $cody_l18n );
							}
						}
						echo '<div class="slide-box">
								<div class="slide-expand"><span class="slide-name">' . $title . '</span><span class="dashicons dashicons-arrow-down"></span></div>
								<div class="slide-content">';
									if ( $this->img == true ) {
										if ( $sl['img'] ) {
											echo '<span class="slide-img">
												<img src="' . wp_get_attachment_image_url( $sl['img'], 'thumbnail' ) . '" data-id="' . $sl['img'] . '"/>
											</span>';
										} else {
											echo '<span class="slide-img">
												<img src="data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTguMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgdmlld0JveD0iMCAwIDI5NyAyOTciIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDI5NyAyOTc7IiB4bWw6c3BhY2U9InByZXNlcnZlIiB3aWR0aD0iMjU2cHgiIGhlaWdodD0iMjU2cHgiPgo8Zz4KCTxwYXRoIGQ9Ik0yOTQuMDYxLDEwMS4zOTVjLTEuODUxLTEuODQ5LTQuMzU5LTIuODg3LTYuOTc2LTIuODg3bC04OC42MTcsMC4wMTJsMC4wMTMtODguNjU1YzAtMi42MTctMS4wMzgtNS4xMjYtMi44ODgtNi45NzcgICBDMTkzLjc0MiwxLjAzOCwxOTEuMjMzLDAsMTg4LjYxNiwwbC04MC4xODgsMC4wMTJjLTUuNDQ1LDAuMDAyLTkuODU5LDQuNDE1LTkuODYsOS44NmwtMC4wMTYsODguNjYyTDkuOTI2LDk4LjU0OCAgIGMtNS40NDYsMC05Ljg2LDQuNDE1LTkuODYxLDkuODZMMC4wNTEsMTg4LjYzYzAsMi42MTgsMS4wMzgsNS4xMjYsMi44ODksNi45NzdjMS44NSwxLjg1LDQuMzU5LDIuODg4LDYuOTc2LDIuODg4bDg4LjYyMS0wLjAxMiAgIGwtMC4wMTQsODguNjUzYzAsMi42MTcsMS4wNCw1LjEyNiwyLjg4OSw2Ljk3N2MxLjg1MSwxLjg1LDQuMzYsMi44OSw2Ljk3NywyLjg4OGw4MC4xODctMC4wMTZjNS40NDUsMCw5Ljg1OS00LjQxNSw5Ljg2LTkuODYgICBsMC4wMTQtODguNjU4bDg4LjYyOS0wLjAxNmM1LjQ0NSwwLDkuODU5LTQuNDE1LDkuODYtOS44NmwwLjAxMi04MC4yMkMyOTYuOTQ5LDEwNS43NTQsMjk1LjkxMSwxMDMuMjQ2LDI5NC4wNjEsMTAxLjM5NXoiIGZpbGw9IiNiZGJkYmQiLz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8L3N2Zz4K" data-id=""/>
											</span>';
										}
									}
								echo '<div class="slide-info">';
									if ( $this->title == true ) {
										if ( isset($sl['title']) && $sl['title'] ) {
											echo '<span class="slide-title"><input type="text" value="' . $sl['title'] . '" /></span>';
										} else {
											echo '<span class="slide-title"><input type="text" value="" placeholder="' . __( 'Title', $cody_l18n ) . '" /></span>';
										}
									}
									if ( $this->link == true ) {
										if ( $sl['url'] ) {
											echo '<span class="slide-link"><input type="text" value="' . $sl['url'] . '" /></span>';
										} else {
											echo '<span class="slide-link"><input type="text" value="" placeholder="' . __( 'Link', $cody_l18n ) . '" /></span>';
										}
									}
									if ( $this->desc == true ) {
										if ( $sl['desc'] ) {
											echo '<span class="slide-desc"><textarea>' . $sl['desc'] . '</textarea></span>';
										} else {
											echo '<span class="slide-desc"><textarea placeholder="' . __( 'Description', $cody_l18n ) . '"></textarea></span>';
										}
									}
									if ( $this->check == true ) {
										if ( $sl['check'] ) {
											echo '<span class="slide-check"><input type="checkbox" checked="checked" /></span>';
										} else {
											echo '<span class="slide-check"><input type="checkbox" /></span>';
										}
									}
									echo '<span class="slide-remove dashicons dashicons-trash"></span>
									</div>
								</div>
							</div>';
						}
					}
				} else {
					echo __( 'Slides not found. Please, create them.', $cody_l18n );
				}
			echo '</div>
			<input type="button" class="button button-primary slide-adding" value="' . __( 'Add', $cody_l18n ) . '">
		</div>';
	}
}