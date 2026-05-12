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

$video_count = count( $long_videos ) + count( $short_videos );
?>



<section id="videos-section" class="relative overflow-hidden bg-[#fff9fb] py-16 sm:py-20 dark:bg-slate-950">
	<div class="absolute inset-0 bg-[radial-gradient(circle_at_top,rgba(255,183,197,0.22),transparent_42%),radial-gradient(circle_at_85%_18%,rgba(168,216,234,0.18),transparent_28%),linear-gradient(180deg,#fffdfd_0%,#fff7f9_48%,#f8fbff_100%)] dark:bg-[radial-gradient(circle_at_top,rgba(255,183,197,0.16),transparent_42%),radial-gradient(circle_at_85%_18%,rgba(168,216,234,0.12),transparent_28%),linear-gradient(180deg,#020617_0%,#020617_52%,#0f172a_100%)]"></div>
	<div class="absolute inset-0 bg-[linear-gradient(to_right,rgba(255,255,255,0.22)_1px,transparent_1px),linear-gradient(to_bottom,rgba(255,255,255,0.16)_1px,transparent_1px)] bg-[size:120px_120px] opacity-35 [mask-image:radial-gradient(circle_at_center,black,transparent_82%)] dark:opacity-20"></div>
	<div class="absolute left-[6%] top-24 h-80 w-80 rounded-full bg-[#FFB7C5]/18 blur-3xl"></div>
	<div class="absolute right-[8%] top-40 h-72 w-72 rounded-full bg-[#A8D8EA]/18 blur-3xl"></div>
	<div class="container mx-auto px-4 relative z-10 lg:px-8">
		<div class="mx-auto mb-8 grid  gap-8 rounded-[40px] border border-white/60 bg-white/35 p-5 shadow-[0_18px_50px_rgba(15,23,42,0.05)] backdrop-blur-lg lg:grid-cols-[minmax(0,1.35fr)_minmax(280px,0.65fr)] lg:items-end dark:border-white/10 dark:bg-slate-900/20 lg:p-6">
			<div class="max-w-3xl text-center lg:text-left">
				<span class="inline-flex items-center gap-2 rounded-full border border-[#FFB7C5]/30 bg-white/80 px-4 py-2 text-xs font-black uppercase tracking-[0.25em] text-[#FF93AB] shadow-[0_10px_30px_rgba(255,183,197,0.12)] backdrop-blur dark:border-pink-400/20 dark:bg-slate-900/70 dark:text-pink-300">
				<svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M10 8.64V15.36L15.27 12 10 8.64ZM21 8v8c0 2.21-1.79 4-4 4H7c-2.21 0-4-1.79-4-4V8c0-2.21 1.79-4 4-4h10c2.21 0 4 1.79 4 4Z"/></svg>
				<?php esc_html_e( 'Watch & Learn', 'julias-cartoonery' ); ?>
			</span>
				<h2 class="mt-5 font-['Bubblegum_Sans'] text-4xl leading-[0.95] text-slate-800 dark:text-slate-100 md:text-5xl lg:text-6xl">
					<?php esc_html_e( 'Julia\'s Channel', 'julias-cartoonery' ); ?>
				</h2>
				<p class="mt-4 max-w-2xl text-base leading-relaxed text-slate-500 dark:text-slate-300 md:text-lg">
					<?php esc_html_e( 'Fresh videos and Shorts from Julia\'s Cartoonery, organized by the way kids actually watch them.', 'julias-cartoonery' ); ?>
				</p>
			</div>
			<div class="rounded-[32px] border border-white/70 bg-white/90 p-5 shadow-[0_18px_50px_rgba(15,23,42,0.08)] backdrop-blur dark:border-slate-800/70 dark:bg-slate-900/80">
				<div class="grid gap-3 sm:grid-cols-3 lg:grid-cols-1">
					<div class="rounded-2xl bg-[#FFB7C5]/12 px-4 py-3">
						<p class="text-[11px] font-black uppercase tracking-[0.22em] text-[#FF93AB] dark:text-pink-300"><?php esc_html_e( 'Total Videos', 'julias-cartoonery' ); ?></p>
						<p class="mt-1 font-['Bubblegum_Sans'] text-3xl text-slate-800 dark:text-slate-100"><?php echo esc_html( (string) $video_count ); ?></p>
					</div>
					<div class="rounded-2xl bg-[#A8D8EA]/15 px-4 py-3">
						<p class="text-[11px] font-black uppercase tracking-[0.22em] text-sky-700 dark:text-sky-300"><?php esc_html_e( 'Latest Videos', 'julias-cartoonery' ); ?></p>
						<p class="mt-1 font-['Bubblegum_Sans'] text-3xl text-slate-800 dark:text-slate-100"><?php echo esc_html( (string) count( $long_videos ) ); ?></p>
					</div>
					<div class="rounded-2xl bg-slate-100 px-4 py-3 dark:bg-slate-800">
						<p class="text-[11px] font-black uppercase tracking-[0.22em] text-slate-500 dark:text-slate-400"><?php esc_html_e( 'Shorts', 'julias-cartoonery' ); ?></p>
						<p class="mt-1 font-['Bubblegum_Sans'] text-3xl text-slate-800 dark:text-slate-100"><?php echo esc_html( (string) count( $short_videos ) ); ?></p>
					</div>
				</div>
			</div>
		</div>

		<?php if ( ! empty( $long_videos ) && ! empty( $short_videos ) ) : ?>
			<div class="mx-auto mb-5 flex w-full max-w-2xl rounded-full border border-white/80 bg-white/90 p-1.5 shadow-[0_14px_32px_rgba(15,23,42,0.08)] backdrop-blur dark:border-slate-700 dark:bg-slate-900/90" role="tablist" aria-label="Video categories">
				<button type="button" id="tab-videos-tab" class="js-video-tab flex-1 rounded-full px-4 py-3 text-sm font-black tracking-wide transition-all duration-300" data-target="tab-videos" role="tab" aria-controls="tab-videos" aria-selected="true">
					<?php esc_html_e( 'Latest Videos', 'julias-cartoonery' ); ?>
				</button>
				<button type="button" id="tab-shorts-tab" class="js-video-tab flex-1 rounded-full px-4 py-3 text-sm font-black tracking-wide text-slate-500 transition-all duration-300 hover:text-slate-700 dark:text-slate-400 dark:hover:text-slate-200" data-target="tab-shorts" role="tab" aria-controls="tab-shorts" aria-selected="false">
					<?php esc_html_e( 'Shorts', 'julias-cartoonery' ); ?>
				</button>
			</div>
		<?php endif; ?>

		<div id="tab-videos" class="js-video-content grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-3 <?php echo empty( $long_videos ) && ! empty( $short_videos ) ? 'hidden' : ''; ?>" role="tabpanel" aria-labelledby="tab-videos-tab" aria-hidden="<?php echo empty( $long_videos ) && ! empty( $short_videos ) ? 'true' : 'false'; ?>">
			<?php if ( empty( $long_videos ) ) : ?>
				<div class="col-span-full rounded-[32px] border border-dashed border-slate-200 bg-white/80 p-10 text-center text-slate-500 shadow-sm dark:border-slate-700 dark:bg-slate-900/70 dark:text-slate-300">
					<?php esc_html_e( 'No long-form videos are published yet.', 'julias-cartoonery' ); ?>
				</div>
			<?php else : ?>
				<?php foreach ( $long_videos as $video ) : ?>
					<?php
					$thumb = $video['thumbnail'];
					$video_url = $video['video_url'];
					?>
					<a href="<?php echo esc_url( $video_url ); ?>" class="js-videos-lightbox group overflow-hidden rounded-[32px] border border-white bg-white shadow-[0_12px_40px_rgba(15,23,42,0.08)] transition-all duration-500 hover:-translate-y-2 hover:shadow-[0_18px_50px_rgba(255,183,197,0.18)] dark:border-slate-800 dark:bg-slate-900" data-gallery="home-videos" data-title="<?php echo esc_attr( $video['title'] ); ?>">
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

		<div id="tab-shorts" class="js-video-content <?php echo ! empty( $long_videos ) || empty( $short_videos ) ? 'hidden' : ''; ?> flex gap-4 overflow-x-auto pb-2 pt-1 snap-x scrollbar-hide" role="tabpanel" aria-labelledby="tab-shorts-tab" aria-hidden="<?php echo ! empty( $long_videos ) || empty( $short_videos ) ? 'true' : 'false'; ?>">
			<?php if ( empty( $short_videos ) ) : ?>
				<div class="w-full rounded-[32px] border border-dashed border-slate-200 bg-white/80 p-10 text-center text-slate-500 shadow-sm dark:border-slate-700 dark:bg-slate-900/70 dark:text-slate-300">
					<?php esc_html_e( 'No Shorts are published yet.', 'julias-cartoonery' ); ?>
				</div>
			<?php else : ?>
				<?php foreach ( $short_videos as $video ) : ?>
					<?php $thumb = $video['thumbnail']; ?>
					<a href="<?php echo esc_url( $video['video_url'] ); ?>" class="js-videos-lightbox group w-[220px] shrink-0 snap-start overflow-hidden rounded-[32px] border border-white bg-white shadow-[0_12px_40px_rgba(15,23,42,0.08)] transition-all duration-500 hover:-translate-y-2 hover:shadow-[0_18px_50px_rgba(168,216,234,0.2)] dark:border-slate-800 dark:bg-slate-900" data-gallery="home-videos" data-title="<?php echo esc_attr( $video['title'] ); ?>">
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