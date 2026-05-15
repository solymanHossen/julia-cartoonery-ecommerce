<?php
/**
 * Story reader markup used by the full template and the async partial endpoint.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$current_page = isset( $args['current_page'] ) ? (int) $args['current_page'] : 1;
$total_pages  = isset( $args['total_pages'] ) ? (int) $args['total_pages'] : 1;
$has_cover    = isset( $args['has_cover'] ) ? (bool) $args['has_cover'] : false;
?>
<article
    class="story-book-frame story-book-fade-in max-w-6xl mx-auto rounded-[34px] md:rounded-[42px] p-2 md:p-4"
    data-story-reader
    data-current-page="<?php echo esc_attr( $current_page ); ?>"
    data-total-pages="<?php echo esc_attr( $total_pages ); ?>"
    data-story-title="<?php echo esc_attr( wp_get_document_title() ); ?>"
    aria-label="Story reader"
    tabindex="-1">
    <div class="story-book-shell overflow-hidden rounded-[30px] md:rounded-[38px] relative">
        <div class="story-book-spine" aria-hidden="true"></div>

        <div class="story-book-stage" data-story-stage>
            <div class="px-6 sm:px-10 pt-6 sm:pt-8 pb-2 border-b border-white/20 dark:border-slate-700/50">
                <div class="flex flex-wrap items-center justify-between gap-3">
                    <span class="inline-flex items-center gap-2 rounded-full bg-white/90 dark:bg-slate-900/80 backdrop-blur-md px-4 py-2 shadow-lg text-[11px] sm:text-xs font-bold uppercase tracking-[0.22em] text-slate-600 dark:text-slate-300">
                        <span class="w-2 h-2 rounded-full <?php echo $has_cover ? 'bg-[#FFB7C5] shadow-[0_0_0_4px_rgba(255,183,197,0.18)]' : 'bg-[#A8D8EA] shadow-[0_0_0_4px_rgba(168,216,234,0.16)]'; ?>"></span>
                        <?php echo $has_cover ? 'Cover Page' : 'Reading Mode'; ?>
                    </span>
                    <span data-story-page-badge class="bg-white/90 dark:bg-slate-900/80 backdrop-blur-md px-4 py-2 rounded-full text-xs font-bold text-slate-600 dark:text-slate-300 shadow-lg">
                        Page <?php echo esc_html( $current_page ); ?> of <?php echo esc_html( $total_pages ); ?>
                    </span>
                </div>
            </div>

            <section
                class="story-book-cover-crop border-b border-white/25 dark:border-slate-700/50 relative<?php echo $has_cover ? '' : ' is-hidden'; ?>"
                data-story-cover-crop
                aria-hidden="<?php echo $has_cover ? 'false' : 'true'; ?>">
                <?php if ( $has_cover ) : ?>
                    <div class="story-book-cover h-[42vh] min-h-[280px] max-h-[460px] bg-slate-100 dark:bg-slate-800 relative">
                        <?php echo wp_get_attachment_image(
                            get_post_thumbnail_id(),
                            'large',
                            false,
                            array(
                                'class'     => 'w-full h-full object-cover object-center mix-blend-multiply dark:mix-blend-normal',
                                'alt'       => the_title_attribute( array( 'echo' => false ) ),
                                'loading'    => 'eager',
                                'decoding'   => 'async',
                                'data-story-cover-image' => 'true',
                            )
                        ); ?>

                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/20 via-transparent to-white/15 pointer-events-none"></div>
                        <div class="absolute inset-0 bg-[radial-gradient(circle_at_50%_18%,rgba(255,255,255,0.28),transparent_36%)] pointer-events-none"></div>
                        <div class="absolute inset-x-0 bottom-0 h-24 bg-gradient-to-t from-black/24 to-transparent pointer-events-none"></div>
                    </div>
                <?php endif; ?>
            </section>

            <div class="story-book-content px-6 sm:px-10 md:px-14 lg:px-20 py-8 md:py-12 text-center relative" data-story-content>
                <div class="absolute inset-x-6 top-0 h-px bg-gradient-to-r from-transparent via-[#FFB7C5]/40 to-transparent"></div>

                <h1 class="font-['Bubblegum_Sans'] text-3xl sm:text-4xl lg:text-5xl text-slate-700 dark:text-slate-200 mb-6 sm:mb-8 pb-4 inline-block border-b-2 border-dashed border-[#FFB7C5]/35 dark:border-slate-600/80">
                    <?php the_title(); ?>
                </h1>

                <div class="mx-auto max-w-4xl font-['Lora'] text-lg sm:text-xl lg:text-2xl leading-relaxed text-slate-800 dark:text-slate-200 prose prose-slate dark:prose-invert prose-p:my-5 prose-p:text-inherit prose-headings:text-inherit prose-a:text-[#FF9CB0] dark:prose-a:text-pink-300 prose-img:rounded-3xl prose-img:shadow-2xl prose-strong:text-inherit">
                    <?php
                    $content = get_the_content();
                    $content = apply_filters( 'the_content', $content );
                    echo $content;
                    ?>
                </div>
            </div>

            <div class="story-book-actions px-5 sm:px-6 md:px-8 pb-6 md:pb-8 pt-2 sm:pt-4 border-t border-white/30 dark:border-slate-700/50 bg-white/40 dark:bg-slate-950/20 backdrop-blur-sm" data-story-actions>
                <div class="flex items-center justify-between gap-3 sm:gap-4 flex-wrap sm:flex-nowrap">
                    <?php if ( $current_page > 1 ) : ?>
                        <a href="<?php echo esc_url( get_story_page_url( $current_page - 1 ) ); ?>"
                            rel="prev"
                            data-story-nav="prev"
                            aria-label="Go to the previous page of this story"
                            class="group inline-flex min-h-12 items-center justify-center rounded-full bg-[#A8D8EA] px-5 sm:px-8 py-3 text-sm sm:text-base font-bold text-white shadow-[0_14px_34px_rgba(168,216,234,0.35)] hover:bg-[#8BCCE6] dark:bg-sky-500 dark:hover:bg-sky-400 active:scale-[0.98]">
                            <span class="mr-2 transition-transform duration-300 group-hover:-translate-x-1">&larr;</span>
                            <span class="hidden sm:inline">Previous Page</span>
                        </a>
                    <?php else : ?>
                        <button type="button" disabled aria-disabled="true" aria-label="You are already on the first page"
                            class="inline-flex min-h-12 items-center justify-center rounded-full bg-slate-100 px-5 sm:px-8 py-3 text-sm sm:text-base font-bold text-slate-400 dark:bg-slate-800 dark:text-slate-500 cursor-not-allowed opacity-70">
                            <span class="mr-2">&larr;</span>
                            <span class="hidden sm:inline">Previous Page</span>
                        </button>
                    <?php endif; ?>

                    <div class="hidden sm:flex items-center gap-2 text-[11px] font-bold uppercase tracking-[0.22em] text-slate-500 dark:text-slate-400">
                        <span class="w-2 h-2 rounded-full bg-[#FFB7C5]"></span>
                        <span>Touch or arrow keys to turn pages</span>
                    </div>

                    <?php if ( $current_page < $total_pages ) : ?>
                        <a href="<?php echo esc_url( get_story_page_url( $current_page + 1 ) ); ?>"
                            rel="next"
                            data-story-nav="next"
                            aria-label="Go to the next page of this story"
                            class="group inline-flex min-h-12 items-center justify-center rounded-full bg-[#FF9CB0] px-5 sm:px-8 py-3 text-sm sm:text-base font-bold text-white shadow-[0_14px_34px_rgba(255,156,176,0.35)] hover:bg-[#FF86A0] dark:bg-pink-500 dark:hover:bg-pink-400 active:scale-[0.98]">
                            <span class="hidden sm:inline">Next Page</span>
                            <span class="ml-2 transition-transform duration-300 group-hover:translate-x-1">&rarr;</span>
                        </a>
                    <?php else : ?>
                            <a href="<?php echo esc_url( get_post_type_archive_link( 'stories' ) ); ?>"
                            aria-label="Finish the story and return to the story library"
                            data-story-exit="true"
                            class="group inline-flex min-h-12 items-center justify-center rounded-full bg-[#FF9CB0] px-5 sm:px-8 py-3 text-sm sm:text-base font-bold text-white shadow-[0_14px_34px_rgba(255,156,176,0.35)] hover:bg-[#FF86A0] dark:bg-pink-500 dark:hover:bg-pink-400 active:scale-[0.98]">
                            Finish Book
                            <span class="ml-2 transition-transform duration-300 group-hover:translate-x-1">✨</span>
                        </a>
                    <?php endif; ?>
                </div>
            </div>

            <p class="sr-only" data-story-live-region aria-live="polite"></p>
        </div>
    </div>
</article>
