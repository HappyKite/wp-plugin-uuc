<?php
/**
 * Activate the Under Construction Page via WP CLI.
 */

class UUC_Cli extends WP_CLI_Command {

	/**
	 * Enables the Under Construction Page.
	 *
	 * ## EXAMPLES
	 *
	 *     wp uuc enable
	 *
	 * @when after_wp_load
	 */
	public function enable() {

		$uuc_options = get_option('uuc_settings');
		$enabled = $uuc_options['enable'];

		if ( !$enabled ) {
			$uuc_options['enable'] = 1;

			update_option( 'uuc_settings', $uuc_options );

			WP_CLI::success( 'Under Construction page Activated. If you want to see a list of User Roles that can still visit the site then use "wp uuc user display"' );
		} else {
			WP_CLI::error( 'Under Construction page is already active. If you want to deactivate then use "wp uuc disable".' );
		}

		return;

	}

	/**
	 * Disables the Under Construction Page.
	 *
	 * ## EXAMPLES
	 *
	 *     wp uuc disable
	 *
	 * @when after_wp_load
	 */
	public function disable() {

		$uuc_options = get_option('uuc_settings');
		$enabled = $uuc_options['enable'];

		if ( $enabled ) {
			$uuc_options['enable'] = 0;

			update_option( 'uuc_settings', $uuc_options );

			WP_CLI::success( 'Under Construction page Deactivated.' );
		} else {
			WP_CLI::error( 'Under Construction page is already deactivated. If you want to activate then use "wp uuc enable".' );
		}

		return;

	}

	/**
	 * Check the status of the Under Construction Page.
	 *
	 * ## EXAMPLES
	 *
	 *     wp uuc status
	 *
	 * @when after_wp_load
	 */
	public function status() {

		$uuc_options = get_option('uuc_settings');
		$enabled = $uuc_options['enable'];

		if ( $enabled ) {
			WP_CLI::log( 'Your site is currently Under Construction. Once logged in as the specified roles you will be able to see your website.' );
		} else if ( !$enabled ) {
			WP_CLI::log( 'The Under Construction page is currently disabled, and as such is visible to everyone. If you wish to change this run "wp uuc enable"' );
		}

		return;
	}
}

WP_CLI::add_command( 'uuc', 'UUC_Cli' );