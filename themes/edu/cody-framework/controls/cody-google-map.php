<?php
if ( ! class_exists( 'WP_Customize_Control' ) )
    return NULL;

/**
 * Class to create a custom post control
 */
class CF_Google_Map_Control extends WP_Customize_Control{
	
	
	/**
	 * Enqueue control related scripts/styles.
	 * Get key into: https://console.developers.google.com/apis/credentials
	 */
	public function enqueue() {
		$array = json_decode( $this->value() );
		$key = array_slice( $array, 0, 1 );
		$key = (array)$key[0];
		wp_enqueue_script( 'googlemap', 'https://maps.googleapis.com/maps/api/js?key=' . $key['key'] . '&callback=initMap' ,'' ,'' , true );
	}
	
	
	/**
	 * Relation to elements with the children class
	 */
	public $relation = '';
	
	
	/**
	 * Start point for edit map
	 */
	public $start_point = '';

	
	/**
	 * Render element
	 */
	public function render_content() {
		$array = json_decode( $this->value() );
		$key = array_slice( $array, 0, 1 );
		$key = (array)$key[0];
		$key = $key != '' ? $key['key'] : '';
		?>
		<div id="google-map" class="<?php echo $this->relation; ?>">
			<label class="google-map-control">
				<span class="customize-control-title"><?php echo esc_html($this->label); ?><span class="cody-help" data-title="<?php echo wp_kses_post($this->description); ?>"></span></span>
				<input type="hidden" id="<?php echo esc_attr($this->id); ?>" class="google-map-markers" name="<?php echo esc_attr($this->id); ?>" value="<?php echo esc_attr($this->value()); ?>" <?php $this->link(); ?>/>
				<input class="google-map-key" value="<?php echo $key; ?>"/>
				<span class="button button-primary create-map"><?php _e( 'Add' ); ?></span>
			</label>
			<div class="google-map">
				<div class="google-map-head"><?php _e( 'Edit map' ); ?><span class="close-google-map dashicons dashicons-no-alt"></span></div>
				<div class="google-map-editor">
					<div class="google-map-marks">
						<?php
						if ( $this->value() != '' ) {
							$i = 0;
							$datas = (array)json_decode( $this->value() );
							//print_r( $datas );
							foreach ( $datas as $data ) {
								$data = (array)$data;
								if ( $i == 1 ) {
									echo sprintf( '<div class="google-map-center"><span class="latitude">%s</span><span class="longitude">%s</span><span class="name">%d</span></div>', $data['lat'], $data['lng'], $data['title'] );
								} elseif ( $i > 1 ) {
									echo sprintf( '<div class="marker" data-id="%d" onclick="setMarkerIcon(%d);"><span class="latitude">%s</span><span class="longitude">%s</span><span class="name">%s</span><span class="desc">%s</span><span class="rel">%d</span><span class="delete dashicons dashicons-no-alt" data-id="%d" onclick="removeMarker(%d);"></span></div>', $data['id'], $data['id'], $data['lat'], $data['lng'], $data['title'], $data['desc'], $data['rel'], $data['id'], $data['id'] );
								}
								$i++;
							}
						} else {
							echo '<div class="google-map-center"><span class="latitude"></span><span class="longitude"></span><span class="name"></span></div>';
						}
						?>
					</div>
					<div class="google-map-button">
						<span class="google-map-save button button-primary"><?php _e( 'Save' ); ?></span>
					</div>
				</div>
				<div id="google-map-box" class="google-map-box">
				</div>
			</div>
			<?php 
			echo '<pre>';
			$array = json_decode( $this->value() );
			$center = array_slice( $array, 1, 2 );
			$point = (array)$center[0];
			if ( isset( $point ) ) {
				$point = array(
					'lat' => '55.45',
					'lng' => '37.36',
				);
			}
			$markers = json_encode( array_slice( $array, 2 ) );
			//print_r( $array );
			//print_r( (array)$center[0] );
			//print_r( $markers );
			echo '</pre>';
			?>
			<script type="text/javascript">
			var markersData = <?php echo $markers; ?>;
			var map, infoWindow, marker;
			var uniqueId = 9999;
			var markers = [];
			 
			function initMap() {
				var centerLatLng = new google.maps.LatLng(<?php echo $point['lat']; ?>, <?php echo $point['lng']; ?>);
				var mapOptions = {
					center: centerLatLng,
					zoom: <?php echo $point['title'] != '' && $point['title'] != 0 ? (int) $point['title'] : '11'; ?>
				};

				map = new google.maps.Map(document.getElementById("google-map-box"), mapOptions);
			 
				infoWindow = new google.maps.InfoWindow();
			 
				google.maps.event.addListener(map, "click", function() {
					infoWindow.close();
				});
			 
				for (var i = 0; i < markersData.length; i++){
			 
					var latLng = new google.maps.LatLng(markersData[i].lat, markersData[i].lng);
					var title = markersData[i].title;
					var desc = markersData[i].desc;
					var rel = markersData[i].rel;
					var id = markersData[i].id;
			 
					initMarker(latLng, title, desc, rel, id);
				}
				
				// Adding new marker
				google.maps.event.addListener(map, 'click', function(e) {
					var location = e.latLng;
					var marker = new google.maps.Marker({
						position: {lat: location.lat(), lng: location.lng()},
						map: map,
						draggable:true,
						id: id,
						title: "<?php _e( 'Place' ); ?>",
						lat: location.lat(),
						lng: location.lng(),
						desc: "<?php _e( 'Description' ); ?>",
						rel: "",
					});
					
					marker.id = uniqueId;
					uniqueId++;
					
					google.maps.event.addListener(marker, "click", function() {
						var contentString = '<div class="google-map-baloon">' +
												'<h3 class="name"><input data-id="' + marker.id + '" class="google-edit-name" value="' + marker.title + '"></h3>' +
												'<p class="desc"><textarea class="google-edit-desc">' + marker.desc + '</textarea></p>' +
												'<p class="rel"></p>' +
												'<p><span class="latitude">' + location.lat() + '</span>    <span class="longitude">' + location.lng() + '</span>' +
												'<span class="dashicons dashicons-trash" onclick="removeMarker(' + marker.id + ');"></span></p>' + 
											'</div>';
						infoWindow.setContent(contentString);
						//infoWindow.setPosition(location);
						infoWindow.open(map, marker);
					});
					

					// dragend new marker
					google.maps.event.addListener(marker, "dragend", function (e) {
						var lat = marker.getPosition().lat();
						var lng = marker.getPosition().lng();
						for (var i = 0; i < markers.length; i++) {
							if (markers[i].id == marker.id) {
								markers[i].lat = lat;
								markers[i].lng = lng;
							}
						}
						//console.log(marker);
						var contentString = '<div class="google-map-baloon">' +
												'<h3 class="name"><input data-id="' + marker.id + '" class="google-edit-name" value="' + marker.title + '"></h3>' +
												'<p class="desc"><textarea class="google-edit-desc">' + marker.desc + '</textarea></p>' +
												'<p class="rel"><span class="latitude">' + lat + '</span>    <span class="longitude">' + lng + '</span>' +
												'<span class="dashicons dashicons-trash" title="<?php _e( 'Delete' ); ?>" onclick="removeMarker(' + marker.id + ');"></span></p>' + 
											'</div>';
						infoWindow.setContent(contentString);
						//infoWindow.open(map, marker);
					});
					
					$('.google-map .google-map-editor .google-map-marks').append('<div class="marker" data-id="' + marker.id + '" onclick="setMarkerIcon(' + marker.id + ');"><span class="latitude">'+location.lat()+'</span><span class="longitude">'+location.lng()+'</span><span class="name"><?php _e( 'Place' ); ?></span><span class="desc"><?php _e( 'Description' ); ?></span><span class="rel"></span><span class="delete dashicons dashicons-no-alt" title="<?php _e( 'Delete' ); ?>" onclick="removeMarker(' + marker.id + ');"></span></div>');
					
					
					//Add marker to the array.
					markers.push(marker);
				});
				
				// add center of map dragend
				google.maps.event.addListener(map, 'dragend', function(event) {
					var g = map.getCenter();

					$('.google-map-center .latitude').html(g.lat());
					$('.google-map-center .longitude').html(g.lng());
					coords = new google.maps.LatLng(g.lat(), g.lng());
				});
				
				// get zoom level
				google.maps.event.addListener(map, 'zoom_changed', function() {
					var z = map.getZoom();
					$('.google-map-center .name').html(z);
				});
			}
			google.maps.event.addDomListener(window, "load", initMap);

			
			function initMarker(latLng, title, desc, rel, id) {
				var marker = new google.maps.Marker({
					position: latLng,
					map: map,
					title: title,
					draggable:true,
					animation: google.maps.Animation.DROP,
					id: id,
					lat: latLng.lat(),
					lng: latLng.lng(),
					desc: desc,
					rel: rel
				});
				
				markers.push(marker);
				
				// click to marker
				google.maps.event.addListener(marker, "click", function (e) {
					var contentString = '<div class="google-map-baloon">' +
											'<h3 class="name"><input data-id="' + marker.id + '" class="google-edit-name" value="' + marker.title + '"></h3>' +
											'<p class="desc"><textarea class="google-edit-desc">' + marker.desc + '</textarea></p>' +
											'<p class="rel"><span class="latitude">' + latLng.lat() + '</span>    <span class="longitude">' + latLng.lng() + '</span>' +
											'<span class="dashicons dashicons-trash" title="<?php _e( 'Delete' ); ?>" onclick="removeMarker(' + marker.id + ');"></span></p>' + 
										'</div>';
					
					infoWindow.setContent(contentString);
					infoWindow.open(map, marker);
				});
				
				// dragend existing marker
				google.maps.event.addListener(marker, "dragend", function (e) {
 					var lat = marker.getPosition().lat();
					var lng = marker.getPosition().lng();
					for (var i = 0; i < markers.length; i++) {
						if (markers[i].id == marker.id) {
							markers[i].lat = lat;
							markers[i].lng = lng;
						}
					}
					//console.log(marker);
					var contentString = '<div class="google-map-baloon">' +
											'<h3 class="name"><input data-id="' + marker.id + '" class="google-edit-name" value="' + marker.title + '"></h3>' +
											'<p class="desc"><textarea class="google-edit-desc">' + marker.desc + '</textarea></p>' +
											'<p class="rel"><span class="latitude">' + lat + '</span>    <span class="longitude">' + lng + '</span>' +
											'<span class="dashicons dashicons-trash" title="<?php _e( 'Delete' ); ?>" onclick="removeMarker(' + marker.id + ');"></span></p>' + 
										'</div>';
					infoWindow.setContent(contentString);
					//infoWindow.open(map, marker);
				});
			}
			
			// from https://www.aspsnippets.com/Articles/Google-Maps-V3-Remove-specific-single-selected-marker.aspx
			// remove new marker
			function removeMarker(id) {
				//Find and remove the marker from the Array
				for (var i = 0; i < markers.length; i++) {
					if (markers[i].id == id) {
						//Remove the marker from Map                   
						markers[i].setMap(null);
						
						$('.google-map-marks').children('.marker').each(function (i) {
							var data_id = $(this).children('.delete').attr('data-id');
							if ( data_id == id ) {
								$(this).remove();
							}
						});

						//Remove the marker from array.
						markers.splice(i, 1);
						return;
					}
				}
			};
			
			function setMarkerIcon(id) {
				for (var i = 0; i < markers.length; i++) {
					if (markers[i].id == id) {                
						markers[i].setIcon('http://maps.google.com/mapfiles/ms/icons/blue-dot.png');
					} else {
						markers[i].setIcon();
					}
				}
			}
			
			
			/* Google map */
			$('.create-map').click(function(){
				jQuery(this).parent().next().fadeIn();
			});
			$('.close-google-map').click(function(){
				jQuery(this).parent().parent().fadeOut();
			});
			// save all markers
			$('.google-map-save').click(function(){
				var json = [];
				json.push({
					key: jQuery('#google-map .google-map-key').val()
				});
				var e = $('.google-map-center span');
				json.push({
					lat: e[0].textContent,
					lng: e[1].textContent,
					title: e[2].textContent
				});
				for (i=0;i<markers.length;i++) {
					json.push({
						id: i,
						lat: markers[i].lat,
						lng: markers[i].lng,
						title: markers[i].title,
						desc: markers[i].desc,
						rel: markers[i].rel
					});
				}
				json = JSON.stringify(json);
				var _this = $(this);
				console.log( json );
				_this.parents('#google-map').children('label').children('.google-map-markers').val(json).change();
				_this.parent().parent().parent().fadeOut();
			});

			// change name
			$('#google-map-box').on('keyup', '.google-map-baloon .name input', function(){
				var _this = jQuery(this);
					content = _this.val(),
					id = _this.attr('data-id');
				for (var i = 0; i < markers.length; i++) {
					if (markers[i].id == id) {
						markers[i].title = content;
					}
				}
				//console.log( markers );
				$('.google-map-marks').children('.marker').each(function (i) {
					var anch = $(this).attr('data-id');
					if ( anch == id ) {
						$(this).children('.name').html(content);
					}
				});
			});
			// change description
			$('#google-map-box').on('input keyup keypress', '.google-map-baloon .desc textarea', function(){
				var content = jQuery(this).val(),
					id = jQuery(this).parents('.google-map-baloon').children('.name').children('input').attr('data-id');
				for (var i = 0; i < markers.length; i++) {
					if (markers[i].id == id) {
						markers[i].desc = content;
					}
				}
				//console.log( markers );
			});
			</script>
		</div>
		<?php
	}
}