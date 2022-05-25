<?php
add_action( 'woocommerce_email_order_meta', 'woo_add_order_notes_to_email' );
function woo_add_order_notes_to_email() {
	global $woocommerce, $post;
	$args = array(
		'post_id' 	=> $post->ID,
		'approve' 	=> 'approve',
		'type' 		=> 'order_note'
	);
	$notes = get_comments( $args );
	
	echo '<h2>' . __( 'Order Notes', 'woocommerce' ) . '</h2>';
	echo '<ul class="order_notes">';
	if ( $notes ) {
		foreach( $notes as $note ) {
			$note_classes = get_comment_meta( $note->comment_ID, 'is_customer_note', true ) ? array( 'customer-note', 'note' ) : array( 'note' );
			?>
			<li rel="<?php echo absint( $note->comment_ID ) ; ?>" class="<?php echo implode( ' ', $note_classes ); ?>">
				<div class="note_content">
					(<?php printf( __( 'added %s ago', 'woocommerce' ), human_time_diff( strtotime( $note->comment_date_gmt ), current_time( 'timestamp', 1 ) ) ); ?>) <?php echo wpautop( wptexturize( wp_kses_post( $note->comment_content ) ) ); ?>
				</div>
			</li>
			<?php
		}
	} else {
		echo '<li>' . __( '(We only charging activity costs online. For the Support costs we will send you invoice manually question ? sunil@bang.com.au )', 'woocommerce' ) . '</li>';
        
	}
    echo '</ul>';
}	