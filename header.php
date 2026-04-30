<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class( 'bg-slate-50 text-slate-900 transition-colors duration-300 dark:bg-slate-950 dark:text-slate-100' ); ?>>
<?php wp_body_open(); ?>

<header class="sticky top-0 z-40 border-b border-slate-200/70 bg-white/90 backdrop-blur dark:border-slate-800/80 dark:bg-slate-950/90">
	<div class="mx-auto flex max-w-6xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
		<a class="text-lg font-semibold tracking-tight text-slate-900 dark:text-white" href="<?php echo esc_url( home_url( '/' ) ); ?>">
			<?php bloginfo( 'name' ); ?>
		</a>

		<div class="flex items-center gap-3">
			<nav class="hidden text-sm font-medium text-slate-600 dark:text-slate-300 md:block">
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'primary',
						'container'      => false,
						'fallback_cb'    => false,
						'depth'          => 1,
						'items_wrap'     => '<ul class="flex items-center gap-6">%3$s</ul>',
					)
				);
				?>
			</nav>

			<button id="jc-theme-toggle" type="button" class="inline-flex items-center rounded-full border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-700 shadow-sm transition hover:border-slate-300 hover:bg-slate-50 dark:border-slate-800 dark:bg-slate-900 dark:text-slate-200 dark:hover:border-slate-700 dark:hover:bg-slate-800" aria-label="Toggle color theme" aria-pressed="false">
				<span data-theme-toggle-label>Dark mode</span>
			</button>
		</div>
	</div>
</header>
