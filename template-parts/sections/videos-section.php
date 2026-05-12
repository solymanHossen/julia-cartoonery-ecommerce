<?php
/**
 * Home Videos Section
 */

$videos = function_exists( 'julias_get_home_videos' ) ? julias_get_home_videos() : array();

if ( empty( $videos ) ) {
	return;
}

$long_videos = array_values(
	array_filter(
		$videos,
		function ( $video ) {
			return isset( $video['type'] ) && 'short' !== $video['type'];
		}
	)
);

$short_videos = array_values(
	array_filter(
		$videos,
		function ( $video ) {
			return isset( $video['type'] ) && 'short' === $video['type'];
		}
)
);
?>

<section id="videos-section" class="relative overflow-hidden bg-gradient-to-b from-white via-[#fff8fa] to-[#f8fbff] py-20 dark:from-slate-950 dark:via-slate-950 dark:to-slate-900">
	<div class="absolute inset-x-0 top-0 h-40 bg-[radial-gradient(circle_at_top,rgba(255,183,197,0.18),transparent_65%)]"></div>
	<div class="container mx-auto px-4 lg:px-8 relative z-10">
		<div class="mx-auto mb-12 max-w-3xl text-center">
			<span class="inline-flex items-center gap-2 rounded-full border border-[#FFB7C5]/30 bg-white/80 px-4 py-2 text-xs font-black uppercase tracking-[0.25em] text-[#FF93AB] shadow-[0_10px_30px_rgba(255,183,197,0.12)] backdrop-blur dark:border-pink-400/20 dark:bg-slate-900/70 dark:text-pink-300">
				<svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M10 8.64V15.36L15.27 12 10 8.64ZM21 8v8c0 2.21-1.79 4-4 4H7c-2.21 0-4-1.79-4-4V8c0-2.21 1.79-4 4-4h10c2.21 0 4 1.79 4 4Z"/></svg>
				<?php esc_html_e( 'Watch & Learn', 'julias-cartoonery' ); ?>
			</span>
			<h2 class="mt-5 font-['Bubblegum_Sans'] text-4xl text-slate-800 dark:text-slate-100 md:text-5xl">
				<?php esc_html_e( 'Julia\'s Channel', 'julias-cartoonery' ); ?>
			</h2>
			<p class="mt-4 text-base leading-relaxed text-slate-500 dark:text-slate-300 md:text-lg">
				<?php esc_html_e( 'Fresh videos and Shorts from Julia\'s Cartoonery, organized by the way kids actually watch them.', 'julias-cartoonery' ); ?>
			</p>
		</div>

		<?php if ( ! empty( $long_videos ) && ! empty( $short_videos ) ) : ?>
			<div class="mx-auto mb-8 flex max-w-fit rounded-full border border-slate-200 bg-white p-1 shadow-[0_10px_30px_rgba(15,23,42,0.06)] dark:border-slate-700 dark:bg-slate-900">
				<button type="button" class="js-video-tab rounded-full px-6 py-2 text-sm font-black text-[#FF93AB] transition-all duration-300" data-target="tab-videos">
					<?php esc_html_e( 'Latest Videos', 'julias-cartoonery' ); ?>
				</button>
				<button type="button" class="js-video-tab rounded-full px-6 py-2 text-sm font-black text-slate-500 transition-all duration-300 hover:text-slate-700 dark:text-slate-400 dark:hover:text-slate-200" data-target="tab-shorts">
					<?php esc_html_e( 'Shorts', 'julias-cartoonery' ); ?>
				</button>
			</div>
		<?php endif; ?>

		<div id="tab-videos" class="js-video-content grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-3 <?php echo empty( $long_videos ) && ! empty( $short_videos ) ? 'hidden' : ''; ?>">
			<?php if ( empty( $long_videos ) ) : ?>
				<div class="col-span-full rounded-[28px] border border-dashed border-slate-200 bg-white/80 p-10 text-center text-slate-500 shadow-sm dark:border-slate-700 dark:bg-slate-900/70 dark:text-slate-300">
					<?php esc_html_e( 'No long-form videos are published yet.', 'julias-cartoonery' ); ?>
				</div>
			<?php else : ?>
				<?php foreach ( $long_videos as $video ) : ?>
					<?php
					$thumb = $video['thumbnail'];
					$video_url = $video['video_url'];
					?>
					<a href="<?php echo esc_url( $video_url ); ?>" class="js-videos-lightbox group overflow-hidden rounded-[28px] border border-white bg-white shadow-[0_12px_40px_rgba(15,23,42,0.08)] transition-all duration-500 hover:-translate-y-2 hover:shadow-[0_18px_50px_rgba(255,183,197,0.18)] dark:border-slate-800 dark:bg-slate-900" data-gallery="home-videos" data-title="<?php echo esc_attr( $video['title'] ); ?>">
						<div class="relative aspect-video overflow-hidden bg-slate-100 dark:bg-slate-800">
							<?php if ( ! empty( $thumb['url'] ) ) : ?>
								<?php echo wp_get_attachment_image( $thumb['id'], 'large', false, array( 'class' => 'h-full w-full object-cover transition-transform duration-700 group-hover:scale-105', 'alt' => $thumb['alt'], 'loading' => 'lazy', 'decoding' => 'async' ) ); ?>
							<?php else : ?>
								<div class="flex h-full w-full items-center justify-center bg-gradient-to-br from-[#FFB7C5]/20 to-[#A8D8EA]/20 text-sm font-bold text-slate-500 dark:text-slate-300">
									<?php esc_html_e( 'Video preview', 'julias-cartoonery' ); ?>
								</div>
							<?php endif; ?>

							<div class="absolute inset-0 bg-gradient-to-t from-slate-950/60 via-slate-950/10 to-transparent"></div>
							<div class="absolute inset-0 flex items-center justify-center">
								<div class="flex h-16 w-16 items-center justify-center rounded-full bg-white/90 text-[#FF93AB] shadow-[0_14px_40px_rgba(255,183,197,0.35)] transition-transform duration-300 group-hover:scale-110">
									<svg class="ml-1 h-7 w-7" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M8 5v14l11-7-11-7Z"/></svg>
								</div>
							</div>
							<?php if ( ! empty( $video['duration'] ) ) : ?>
								<span class="absolute bottom-3 right-3 rounded-full bg-black/75 px-2.5 py-1 text-[11px] font-bold tracking-wide text-white backdrop-blur">
									<?php echo esc_html( $video['duration'] ); ?>
								</span>
							<?php endif; ?>
							<?php if ( ! empty( $video['label'] ) ) : ?>
								<span class="absolute left-3 top-3 rounded-full bg-white/90 px-3 py-1 text-[10px] font-black uppercase tracking-[0.2em] text-[#FF93AB] shadow-sm backdrop-blur">
									<?php echo esc_html( $video['label'] ); ?>
								</span>
							<?php endif; ?>
						</div>
						<div class="space-y-2 p-5">
							<h3 class="line-clamp-2 font-['Bubblegum_Sans'] text-2xl leading-tight text-slate-800 transition-colors group-hover:text-[#FF93AB] dark:text-slate-100">
								<?php echo esc_html( $video['title'] ); ?>
							</h3>
							<?php if ( ! empty( $video['description'] ) ) : ?>
								<p class="line-clamp-2 text-sm leading-relaxed text-slate-500 dark:text-slate-400">
									<?php echo esc_html( $video['description'] ); ?>
								</p>
							<?php endif; ?>
						</div>
					</a>
				<?php endforeach; ?>
			<?php endif; ?>
		</div>

		<div id="tab-shorts" class="js-video-content <?php echo ! empty( $long_videos ) || empty( $short_videos ) ? 'hidden' : ''; ?> flex gap-4 overflow-x-auto pb-2 pt-1 snap-x scrollbar-hide">
			<?php if ( empty( $short_videos ) ) : ?>
				<div class="w-full rounded-[28px] border border-dashed border-slate-200 bg-white/80 p-10 text-center text-slate-500 shadow-sm dark:border-slate-700 dark:bg-slate-900/70 dark:text-slate-300">
					<?php esc_html_e( 'No Shorts are published yet.', 'julias-cartoonery' ); ?>
				</div>
			<?php else : ?>
				<?php foreach ( $short_videos as $video ) : ?>
					<?php $thumb = $video['thumbnail']; ?>
					<a href="<?php echo esc_url( $video['video_url'] ); ?>" class="js-videos-lightbox group w-[210px] shrink-0 snap-start overflow-hidden rounded-[28px] border border-white bg-white shadow-[0_12px_40px_rgba(15,23,42,0.08)] transition-all duration-500 hover:-translate-y-2 hover:shadow-[0_18px_50px_rgba(168,216,234,0.2)] dark:border-slate-800 dark:bg-slate-900" data-gallery="home-videos" data-title="<?php echo esc_attr( $video['title'] ); ?>">
						<div class="relative aspect-[9/16] overflow-hidden bg-slate-100 dark:bg-slate-800">
							<?php if ( ! empty( $thumb['url'] ) ) : ?>
								<?php echo wp_get_attachment_image( $thumb['id'], 'large', false, array( 'class' => 'h-full w-full object-cover transition-transform duration-700 group-hover:scale-105', 'alt' => $thumb['alt'], 'loading' => 'lazy', 'decoding' => 'async' ) ); ?>
							<?php else : ?>
								<div class="flex h-full w-full items-center justify-center bg-gradient-to-br from-[#FFB7C5]/20 to-[#A8D8EA]/20 text-sm font-bold text-slate-500 dark:text-slate-300">
									<?php esc_html_e( 'Short preview', 'julias-cartoonery' ); ?>
								</div>
							<?php endif; ?>
							<div class="absolute inset-0 bg-gradient-to-t from-slate-950/75 via-slate-950/10 to-transparent"></div>
							<div class="absolute inset-0 flex items-center justify-center opacity-0 transition-opacity duration-300 group-hover:opacity-100">
								<div class="flex h-14 w-14 items-center justify-center rounded-full bg-white/90 text-[#A8D8EA] shadow-[0_14px_40px_rgba(168,216,234,0.35)]">
									<svg class="ml-1 h-6 w-6" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M8 5v14l11-7-11-7Z"/></svg>
								</div>
							</div>
							<div class="absolute inset-x-0 bottom-0 p-4">
								<h3 class="line-clamp-2 font-['Bubblegum_Sans'] text-xl leading-tight text-white drop-shadow">
									<?php echo esc_html( $video['title'] ); ?>
								</h3>
								<?php if ( ! empty( $video['duration'] ) ) : ?>
									<p class="mt-1 text-[11px] font-bold uppercase tracking-[0.2em] text-white/75"><?php echo esc_html( $video['duration'] ); ?></p>
								<?php endif; ?>
							</div>
						</div>
					</a>
				<?php endforeach; ?>
			<?php endif; ?>
		</div>
	</div>
</section>