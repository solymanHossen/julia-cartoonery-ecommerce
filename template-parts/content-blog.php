<article <?php post_class( 'group h-full' ); ?>>
    <a
        href="<?php the_permalink(); ?>"
        class="flex h-full flex-col overflow-hidden rounded-[2rem] border border-gray-100 bg-white shadow-sm transition duration-300 ease-out hover:-translate-y-1 hover:shadow-2xl focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#FFB7C5] focus-visible:ring-offset-2 dark:border-slate-700 dark:bg-slate-900 dark:focus-visible:ring-offset-slate-950"
        aria-label="<?php echo esc_attr( sprintf( __( 'Read more about %s', 'julias-cartoonery' ), get_the_title() ) ); ?>"
    >
        <div class="relative aspect-[4/3] overflow-hidden bg-gradient-to-br from-[#FFB7C5]/20 via-white to-[#A8D8EA]/20 dark:from-pink-500/15 dark:via-slate-900 dark:to-sky-500/10">
            <?php if ( has_post_thumbnail() ) : ?>
                <?php the_post_thumbnail( 'large', array( 'class' => 'h-full w-full object-cover transition duration-500 group-hover:scale-105' ) ); ?>
            <?php else : ?>
                <div class="flex h-full w-full items-center justify-center px-6 text-center text-sm font-semibold text-gray-400 dark:text-gray-500">
                    <?php esc_html_e( 'Featured image coming soon', 'julias-cartoonery' ); ?>
                </div>
            <?php endif; ?>

            <?php
            $categories = get_the_category();
            if ( ! empty( $categories ) ) :
                ?>
                <span class="absolute left-4 top-4 inline-flex rounded-full bg-white/95 px-3 py-1 text-xs font-semibold text-[#5F9DB3] shadow-sm backdrop-blur dark:bg-slate-950/80 dark:text-sky-300">
                    <?php echo esc_html( $categories[0]->name ); ?>
                </span>
            <?php endif; ?>
        </div>

        <div class="flex flex-1 flex-col p-6">
            <div class="flex items-center gap-3 text-sm text-gray-500 dark:text-gray-400">
                <time datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>">
                    <?php echo esc_html( get_the_date() ); ?>
                </time>
                <span aria-hidden="true">•</span>
                <span><?php echo esc_html( get_the_author() ); ?></span>
            </div>

            <h2 class="mt-4 text-2xl font-semibold leading-tight text-gray-900 transition-colors group-hover:text-[#FF7F9C] dark:text-gray-50 dark:group-hover:text-pink-300">
                <?php the_title(); ?>
            </h2>

            <div class="mt-4 line-clamp-3 text-sm leading-7 text-gray-600 dark:text-gray-300">
                <?php echo esc_html( wp_trim_words( get_the_excerpt(), 24, '...' ) ); ?>
            </div>

            <div class="mt-6 inline-flex items-center gap-2 text-sm font-semibold text-[#FF7F9C] dark:text-pink-300">
                <span><?php esc_html_e( 'Read article', 'julias-cartoonery' ); ?></span>
                <span aria-hidden="true" class="transition-transform duration-300 group-hover:translate-x-1">&rarr;</span>
            </div>
        </div>
    </a>
</article>