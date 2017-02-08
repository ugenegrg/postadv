<?php
	if( $_POST ) {

		// bail early if nonce is not verified
		if( ! wp_verify_nonce( $_POST['_panonce'], 'pa_adminset' ) ) {

			die( 'No script kidding please !' );

		} else {

			$pa_val_script 		= Postadv::pa_sanitize( $_POST[ 'pa_ip_script' ] );
			$pa_val_latency 	= ( isset( $_POST['pa_ip_latency'] ) ) ? $_POST[ 'pa_ip_latency' ] : 'off';
			$pa_val_latency_day = ( isset( $_POST['pa_ip_latency_day'] ) ) ? $_POST[ 'pa_ip_latency_day' ] : 0;

			// save options
			update_option( '_pa_script', $pa_val_script );
			update_option( '_pa_latency', $pa_val_latency );
			update_option( '_pa_latency_day', $pa_val_latency_day );
		}

	}
?>
<div class="wrap">
	<h1><?php _e( 'Postadv Settings', 'postadv' ); ?></h1>
	<form name="" method="post" action="">
		<table class="form-table">
			<tbody>
				<tr>
					<th scope="row">
						<label> AdSense script</label>
					</th>
					<td>
						<?php $pa_script = get_option( '_pa_script' ); ?>
						<textarea name="pa_ip_script" cols="80" rows="10"><?php echo $pa_script; ?></textarea>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label> Enable latency</label>
					</th>
					<td>
						<?php
							$pa_latency = get_option( '_pa_latency' );
							$checked = ( $pa_latency == 'on' ) ? 'checked' : '';
						?>
						<input type="checkbox" name="pa_ip_latency" onchange="pa_toggle_day(this);" <?php echo $checked; ?>> Enable this checkbox to use latency of adv in posts.
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label id="latency_day"> Enter days in number</label>
					</th>
					<td>
						<?php
							$pa_latency_day = get_option( '_pa_latency_day' );
							$pa_latency_day = ( $pa_latency_day ) ? $pa_latency_day : '';
						?>
						<input type="number" name="pa_ip_latency_day" id="pa_ip_latency_day" <?php echo ( $pa_latency == 'on' ) ? '' : 'disabled'; ?> value="<?php echo $pa_latency_day; ?>">
					</td>
				</tr>
			</tbody>
		</table>
		<?php wp_nonce_field( 'pa_adminset', '_panonce' ); ?>
		<?php submit_button( 'Save Changes', 'primary', 'pa_ip_submit' ); ?>
	</form>
	<script type="text/javascript">
		function pa_toggle_day( ele ) {
			
			if( ele.checked ) {
				document.getElementById( 'pa_ip_latency_day' ).disabled = false;
				document.getElementById( 'latency_day' ).style.color = '#000';
			} else {
				document.getElementById( 'pa_ip_latency_day' ).disabled = true;
				document.getElementById( 'latency_day' ).style.color = '#ccc';
			}
		}
	</script>
</div>