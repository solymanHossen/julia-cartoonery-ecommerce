<?php get_header(); ?>

<main class="relative overflow-hidden">
    <div class="pointer-events-none absolute inset-x-0 top-0 -z-10 h-72 bg-gradient-to-b from-[#FFB7C5]/20 via-transparent to-transparent dark:from-pink-500/10"></div>

    <section class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8 lg:py-16">
        <div class="mx-auto max-w-3xl text-center">
            <span class="mb-4 inline-flex items-center rounded-full bg-[#A8D8EA]/20 px-4 py-1 text-sm font-semibold text-[#5F9DB3] dark:bg-sky-500/15 dark:text-sky-300">
                <?php esc_html_e( 'Parenting & Play', 'julias-cartoonery' ); ?>
            </span>
            <h1 class="font-['Bubblegum_Sans'] text-5xl leading-tight text-gray-900 dark:text-gray-50 md:text-6xl">
                <?php esc_html_e( 'Our Latest Blogs', 'julias-cartoonery' ); ?>
            </h1>
            <p class="mx-auto mt-5 max-w-2xl text-base leading-8 text-gray-600 dark:text-gray-300 md:text-lg">
                <?php esc_html_e( 'Read practical tips, playful stories, and thoughtful notes from the world of Julia’s Cartoonery.', 'julias-cartoonery' ); ?>
            </p>
        </div>

        <?php if ( have_posts() ) : ?>
            <div class="mt-12 grid grid-cols-1 gap-8 md:grid-cols-2 xl:grid-cols-3">
                <?php
                while ( have_posts() ) : the_post();
                    get_template_part( 'template-parts/content', 'blog' );
                endwhile;
                ?>
            </div>

            <nav class="mt-14 flex justify-center" aria-label="<?php esc_attr_e( 'Blog pagination', 'julias-cartoonery' ); ?>">
                <?php
                the_posts_pagination( array(
                    'mid_size'           => 2,
                    'prev_text'          => '<span class="sr-only">' . esc_html__( 'Previous page', 'julias-cartoonery' ) . '</span><span aria-hidden="true">&larr;</span>',
                    'next_text'          => '<span class="sr-only">' . esc_html__( 'Next page', 'julias-cartoonery' ) . '</span><span aria-hidden="true">&rarr;</span>',
                    'screen_reader_text' => esc_html__( 'Blog navigation', 'julias-cartoonery' ),
                ) );
                ?>
            </nav>
        <?php else : ?>
            <div class="mt-16 rounded-[2rem] border border-dashed border-gray-200 bg-white/70 px-8 py-16 text-center shadow-sm backdrop-blur dark:border-slate-700 dark:bg-slate-900/70">
                <h2 class="text-2xl font-semibold text-gray-900 dark:text-gray-50">
                    <?php esc_html_e( 'No blog posts found yet.', 'julias-cartoonery' ); ?>
                </h2>
                <p class="mt-3 text-gray-600 dark:text-gray-300">
                    <?php esc_html_e( 'Check back soon for new stories, advice, and updates.', 'julias-cartoonery' ); ?>
                </p>
            </div>
        <?php endif; ?>
    </section>
</main>

<?php get_footer(); ?>