<?php
/**
 * Activate the Under Construction Page via WP CLI.
 */

class UUC_Cli_User extends WP_CLI_Command {

	public function display( $args, $assoc_args ) {
		WP_CLI::success( 'Below is a list of all user roles. The active roles are able to see your website with the Under Construction page active.' );
		global $wp_roles;
		$query_args = $wp_roles->get_names();
		$formatter  = $this->get_formatter( $assoc_args );

		foreach( $query_args as $role ) {
			$query[] = $role;
		}
		$items = $this->format_posts_to_items( $query );
		$formatter->display_items( $items );

	}

	protected function get_formatter( $assoc_args ) {
		$args = $this->get_format_args( $assoc_args );
		return new \WP_CLI\Formatter( $args );
	}

	/**
	 * Get format args that will be passed into CLI Formatter.
	 *
	 * @since  2.5.0
	 * @param  array $assoc_args Associative args from CLI
	 * @return array Formatter args
	 */
	protected function get_format_args( $assoc_args ) {
		$format_args = array(
			'fields' => array( 'role', 'active' ),
			'field'  => null,
			'format' => 'table',
		);

		if ( isset( $assoc_args['fields'] ) ) {
			$format_args['fields'] = $assoc_args['fields'];
		}

		if ( isset( $assoc_args['field'] ) ) {
			$format_args['field'] = $assoc_args['field'];
		}

		if ( ! empty( $assoc_args['format'] ) && in_array( $assoc_args['format'], array( 'count', 'ids', 'table', 'csv', 'json' ) ) ) {
			$format_args['format'] = $assoc_args['format'];
		}

		return $format_args;
	}

	/**
	 * Get default fields for formatter.
	 *
	 * Class that extends WC_CLI_Command should override this method.
	 *
	 * @since  2.5.0
	 * @return null|string|array
	 */
	protected function get_default_format_fields() {
		return 'role,active';
	}

	/**
	 * Get query args for list subcommand.
	 *
	 * @since  2.5.0
	 * @param  array $args Args from command line
	 * @return array
	 */
	protected function get_list_query_args( $args ) {
		$query_args = array(
			'post_type'      => 'shop_order',
			'post_status'    => array_keys( wc_get_order_statuses() ),
			'posts_per_page' => -1,
		);

		if ( ! empty( $args['status'] ) ) {
			$statuses                  = 'wc-' . str_replace( ',', ',wc-', $args['status'] );
			$statuses                  = explode( ',', $statuses );
			$query_args['post_status'] = $statuses;
		}

		if ( ! empty( $args['customer_id'] ) ) {
			$query_args['meta_query'] = array(
				array(
					'key'   => '_customer_user',
					'value' => (int) $args['customer_id'],
					'compare' => '='
				)
			);
		}
	}

	protected function merge_wp_query_args( $base_args, $assoc_args ) {
		$args = array();

		// date
		if ( ! empty( $assoc_args['created_at_min'] ) || ! empty( $assoc_args['created_at_max'] ) || ! empty( $assoc_args['updated_at_min'] ) || ! empty( $assoc_args['updated_at_max'] ) ) {

			$args['date_query'] = array();

			// resources created after specified date
			if ( ! empty( $assoc_args['created_at_min'] ) ) {
				$args['date_query'][] = array( 'column' => 'post_date_gmt', 'after' => $this->parse_datetime( $assoc_args['created_at_min'] ), 'inclusive' => true );
			}

			// resources created before specified date
			if ( ! empty( $assoc_args['created_at_max'] ) ) {
				$args['date_query'][] = array( 'column' => 'post_date_gmt', 'before' => $this->parse_datetime( $assoc_args['created_at_max'] ), 'inclusive' => true );
			}

			// resources updated after specified date
			if ( ! empty( $assoc_args['updated_at_min'] ) ) {
				$args['date_query'][] = array( 'column' => 'post_modified_gmt', 'after' => $this->parse_datetime( $assoc_args['updated_at_min'] ), 'inclusive' => true );
			}

			// resources updated before specified date
			if ( ! empty( $assoc_args['updated_at_max'] ) ) {
				$args['date_query'][] = array( 'column' => 'post_modified_gmt', 'before' => $this->parse_datetime( $assoc_args['updated_at_max'] ), 'inclusive' => true );
			}
		}

		// Search.
		if ( ! empty( $assoc_args['q'] ) ) {
			$args['s'] = $assoc_args['q'];
		}

		// Number of post to show per page.
		if ( ! empty( $assoc_args['limit'] ) ) {
			$args['posts_per_page'] = $assoc_args['limit'];
		}

		// Number of post to displace or pass over.
		if ( ! empty( $assoc_args['offset'] ) ) {
			$args['offset'] = $assoc_args['offset'];
		}

		// order (ASC or DESC, DESC by default).
		if ( ! empty( $assoc_args['order'] ) ) {
			$args['order'] = $assoc_args['order'];
		}

		// orderby.
		if ( ! empty( $assoc_args['orderby'] ) ) {
			$args['orderby'] = $assoc_args['orderby'];

			// allow sorting by meta value
			if ( ! empty( $assoc_args['orderby_meta_key'] ) ) {
				$args['meta_key'] = $assoc_args['orderby_meta_key'];
			}
		}

		// allow post status change
		if ( ! empty( $assoc_args['post_status'] ) ) {
			$args['post_status'] = $assoc_args['post_status'];
			unset( $assoc_args['post_status'] );
		}

		// filter by a list of post ids
		if ( ! empty( $assoc_args['in'] ) ) {
			$args['post__in'] = explode( ',', $assoc_args['in'] );
			unset( $assoc_args['in'] );
		}

		// exclude by a list of post ids
		if ( ! empty( $assoc_args['not_in'] ) ) {
			$args['post__not_in'] = explode( ',', $assoc_args['not_in'] );
			unset( $assoc_args['not_in'] );
		}

		// posts page.
		$args['paged'] = ( isset( $assoc_args['page'] ) ) ? absint( $assoc_args['page'] ) : 1;

		$args = apply_filters( 'woocommerce_cli_query_args', $args, $assoc_args );

		return array_merge( $base_args, $args );
	}

	protected function format_posts_to_items( $posts ) {
		$uuc_options = get_option('uuc_settings');
		$items = array();
		foreach ( $posts as $post ) {

			$active = 0;

			$settings_role[] = 'user_role_' . $post;

			foreach( $settings_role as $role ) {
				$allowed_role = $uuc_options[$role];
				if ( $allowed_role == 1 ){
					$allowed[] = strtolower( str_replace( 'user_role_', '', $role ) );
				}

			}

			if ( in_array( strtolower( $post ), $allowed ) ) {
				$active = 1;
			}

			$items[] = array(
				'role' => $post,
				'active' => $active
			);
		}

		return $items;
	}
}

WP_CLI::add_command( 'uuc user', 'UUC_Cli_User' );
