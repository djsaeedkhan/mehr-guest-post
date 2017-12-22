<?php
global $wpdb;
	$charset_collate = $wpdb->get_charset_collate();
	if($wpdb->get_var("SHOW TABLES LIKE '$this->tblGpost'") != $this->tblGpost)
	{
		global $jal_db_version;
		$sql = "CREATE TABLE $this->tblGpost (
			id mediumint(9) NOT NULL AUTO_INCREMENT,
			author_id text NOT NULL,
			title text NOT NULL,
			post_type text NOT NULL,
			uinfo text NOT NULL,
			created datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
			UNIQUE KEY id (id)
		) $charset_collate;";
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
		add_option( 'jal_db_version', $jal_db_version );
	}
?>