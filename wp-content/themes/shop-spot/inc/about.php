<?php

/**
 * Shop_Spot Theme page
 *
 * @package Shop_Spot
 */

function shop_spot_about_admin_style($hook)
{
	if ('appearance_page_shop-spot-about' === $hook) {
		wp_enqueue_style('shop-spot-about-admin', get_theme_file_uri('assets/css/about-admin.css'), null, '1.0');
	}
}
add_action('admin_enqueue_scripts', 'shop_spot_about_admin_style');

/**
 * Add theme page
 */
function shop_spot_menu()
{
	add_theme_page(esc_html__('About Theme', 'shop-spot'), esc_html__('About Theme', 'shop-spot'), 'edit_theme_options', 'shop-spot-about', 'shop_spot_about_display');
}
add_action('admin_menu', 'shop_spot_menu');

/**
 * Display About page
 */
function shop_spot_about_display()
{
	$theme = wp_get_theme();
?>
	<div class="wrap about-wrap full-width-layout">
		<h1><?php echo esc_html($theme); ?></h1>
		<div class="about-theme">
			<div class="theme-description">
				<p class="about-text">
					<?php
					// Remove last sentence of description.
					$description = explode('. ', $theme->get('Description'));

					array_pop($description);

					$description = implode('. ', $description);

					echo esc_html($description . '.');
					?></p>
				<p class="actions">
					<a href="<?php echo esc_url('https://catchthemes.com/themes/shop-spot'); ?>" class="button button-secondary" target="_blank"><?php esc_html_e('Theme Info', 'shop-spot'); ?></a>

					<a href="<?php echo esc_url('https://catchthemes.com/demo/shop-spot'); ?>" class="button button-secondary" target="_blank"><?php esc_html_e('View Demo', 'shop-spot'); ?></a>

					<a href="<?php echo esc_url('https://catchthemes.com/themes/shop-spot/#theme-instructions'); ?>" class="button button-primary" target="_blank"><?php esc_html_e('Theme Instructions', 'shop-spot'); ?></a>

					<a href="<?php echo esc_url('https://wordpress.org/support/theme/shop-spot/reviews/#new-post'); ?>" class="button button-secondary" target="_blank"><?php esc_html_e('Rate this theme', 'shop-spot'); ?></a>

					<a href="<?php echo esc_url('https://catchthemes.com/themes/shop-spot/#compare'); ?>" class="button button-primary" target="_blank"><?php esc_html_e('Compare free Vs Pro',  'shop-spot'); ?></a>

					<a href="<?php echo esc_url('https://catchthemes.com/themes/shop-spot-pro'); ?>" class="green button button-secondary" target="_blank"><?php esc_html_e('Upgrade to pro', 'shop-spot'); ?></a>
				</p>
			</div>

			<div class="theme-screenshot">
				<img src="<?php echo esc_url($theme->get_screenshot()); ?>" />
			</div>

		</div>

		<nav class="nav-tab-wrapper wp-clearfix" aria-label="<?php esc_attr_e('Secondary menu', 'shop-spot'); ?>">
			<a href="<?php echo esc_url(admin_url(add_query_arg(array('page' => 'shop-spot-about'), 'themes.php'))); ?>" class="nav-tab<?php echo (isset($_GET['page']) && 'shop-spot-about' === $_GET['page'] && !isset($_GET['tab'])) ? ' nav-tab-active' : ''; ?>"><?php esc_html_e('About', 'shop-spot'); ?></a>

			<a href="<?php echo esc_url(admin_url(add_query_arg(array('page' => 'shop-spot-about', 'tab' => 'import_demo'), 'themes.php'))); ?>" class="nav-tab<?php echo (isset($_GET['tab']) && 'import_demo' === $_GET['tab']) ? ' nav-tab-active' : ''; ?>"><?php esc_html_e('Import Demo', 'shop-spot'); ?></a>
		</nav>

		<?php
		shop_spot_main_screen();

		shop_spot_import_demo();
		?>

		<div class="return-to-dashboard">
			<?php if (current_user_can('update_core') && isset($_GET['updated'])) : ?>
				<a href="<?php echo esc_url(self_admin_url('update-core.php')); ?>">
					<?php is_multisite() ? esc_html_e('Return to Updates', 'shop-spot') : esc_html_e('Return to Dashboard &rarr; Updates', 'shop-spot'); ?>
				</a> |
			<?php endif; ?>
			<a href="<?php echo esc_url(self_admin_url()); ?>"><?php is_blog_admin() ? esc_html_e('Go to Dashboard &rarr; Home', 'shop-spot') : esc_html_e('Go to Dashboard', 'shop-spot'); ?></a>
		</div>
	</div>
	<?php
}

/**
 * Output the main about screen.
 */
function shop_spot_main_screen()
{
	if (isset($_GET['page']) && 'shop-spot-about' === $_GET['page'] && !isset($_GET['tab'])) {
	?>
		<div class="feature-section two-col">
			<div class="col card">
				<h2 class="title"><?php esc_html_e('Theme Customizer', 'shop-spot'); ?></h2>
				<p><?php esc_html_e('All Theme Options are available via Customize screen.', 'shop-spot') ?></p>
				<p><a href="<?php echo esc_url(admin_url('customize.php')); ?>" class="button button-primary"><?php esc_html_e('Customize', 'shop-spot'); ?></a></p>
			</div>

			<div class="col card">
				<h2 class="title"><?php esc_html_e('Got theme support question?', 'shop-spot'); ?></h2>
				<p><?php esc_html_e('Get genuine support from genuine people. Whether it\'s customization or compatibility, our seasoned developers deliver tailored solutions to your queries.', 'shop-spot') ?></p>
				<p><a href="<?php echo esc_url('https://catchthemes.com/support-forum'); ?>" class="button button-primary"><?php esc_html_e('Support Forum', 'shop-spot'); ?></a></p>
			</div>
		</div>
	<?php
	}
}

/**
 * Import Demo data for theme using catch themes demo import plugin
 */
function shop_spot_import_demo()
{
	if (isset($_GET['tab']) && 'import_demo' === $_GET['tab']) {
	?>
		<div class="wrap about-wrap demo-import-wrap">
			<div class="feature-section one-col">
				<?php if (class_exists('CatchThemesDemoImportPlugin')) { ?>
					<div class="col card">
						<h2 class="title"><?php esc_html_e('Import Demo', 'shop-spot'); ?></h2>
						<p><?php esc_html_e('You can easily import the demo content using the Catch Themes Demo Import Plugin.', 'shop-spot') ?></p>
						<p><a href="<?php echo esc_url(admin_url('themes.php?page=catch-themes-demo-import')); ?>" class="button button-primary"><?php esc_html_e('Import Demo', 'shop-spot'); ?></a></p>
					</div>
				<?php } else {
					$action = 'install-plugin';
					$slug   = 'catch-themes-demo-import';
					$install_url = wp_nonce_url(
						add_query_arg(
							array(
								'action' => $action,
								'plugin' => $slug
							),
							admin_url('update.php')
						),
						$action . '_' . $slug
					); ?>
					<div class="col card">
						<h2 class="title"><?php esc_html_e('Install Catch Themes Demo Import Plugin', 'shop-spot'); ?></h2>
						<p><?php esc_html_e('You can easily import the demo content using the Catch Themes Demo Import Plugin.', 'shop-spot') ?></p>
						<p><a href="<?php echo esc_url($install_url); ?>" class="button button-primary"><?php esc_html_e('Install Plugin', 'shop-spot'); ?></a></p>
					</div>
				<?php } ?>
			</div>
		</div>
<?php
	}
}
