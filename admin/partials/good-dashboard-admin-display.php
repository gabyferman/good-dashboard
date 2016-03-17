<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link http://github.com/gabyferman/
 * @since 1.0.0
 *
 * @package Good_Dashboard
 * @subpackage Good_Dashboard/admin/partials
 */
?>

	<div class="wrap good-dashboard-wrap">

		<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>

		<form method="post" action="options.php">

			<?php settings_fields( $this->plugin_name . '-options' ); ?>

			<?php do_settings_sections( $this->plugin_name ); ?>

			<?php submit_button(); ?>

		</form>

	</div>
