<?php get_header(); ?>

<main class="relative overflow-hidden py-12 sm:py-16">
    <div class="pointer-events-none absolute inset-x-0 top-0 -z-10 h-80 bg-[radial-gradient(circle_at_top,_rgba(255,183,197,0.25),_transparent_55%)] dark:bg-[radial-gradient(circle_at_top,_rgba(255,127,156,0.12),_transparent_55%)]"></div>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <?php while ( have_posts() ) : the_post(); ?>
            <?php get_template_part( 'template-parts/components/button-back', null, array( 'url' => get_post_type_archive_link( 'blog_posts' ), 'text' => __( 'Back to Blog', 'julias-cartoonery' ) ) ); ?>

            <article class="overflow-hidden rounded-[2.5rem] border border-gray-100 bg-white shadow-[0_20px_60px_rgba(15,23,42,0.08)] dark:border-slate-800 dark:bg-slate-900">
                <header class="relative isolate overflow-hidden">
                    <div class="aspect-[16/9] bg-gradient-to-br from-[#FFB7C5]/20 via-white to-[#A8D8EA]/20 dark:from-pink-500/15 dark:via-slate-900 dark:to-sky-500/10 md:aspect-[21/9]">
                        <?php if ( has_post_thumbnail() ) : ?>
                            <?php the_post_thumbnail( 'full', array( 'class' => 'h-full w-full object-cover' ) ); ?>
                        <?php endif; ?>
                    </div>

                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/85 via-slate-950/35 to-transparent"></div>

                    <div class="absolute inset-x-0 bottom-0 p-6 sm:p-10 lg:p-12">
                        <?php
                        $categories = get_the_category();
                        if ( ! empty( $categories ) ) :
                            ?>
                            <div class="mb-4 flex flex-wrap gap-2">
                                <span class="inline-flex rounded-full bg-white/95 px-3 py-1 text-xs font-semibold text-[#5F9DB3] shadow-sm backdrop-blur dark:bg-slate-950/85 dark:text-sky-300">
                                    <?php echo esc_html( $categories[0]->name ); ?>
                                </span>
                            </div>
                        <?php endif; ?>

                        <h1 class="font-['Bubblegum_Sans'] text-4xl leading-tight text-white sm:text-5xl lg:text-6xl">
                            <?php the_title(); ?>
                        </h1>

                        <div class="mt-5 flex flex-wrap items-center gap-4 text-sm text-white/80">
                            <span><?php echo esc_html( get_the_author() ); ?></span>
                            <span aria-hidden="true">•</span>
                            <time datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
                        </div>
                    </div>
                </header>

                <div class="px-6 py-8 sm:px-10 sm:py-12 lg:px-12 lg:py-14">
                    <div class="prose prose-lg max-w-none text-gray-700 prose-headings:text-gray-900 prose-a:text-[#FF7F9C] hover:prose-a:text-pink-500 dark:prose-invert dark:text-gray-300 dark:prose-headings:text-gray-50">
                        <?php the_content(); ?>
                    </div>

                    <?php $tags = get_the_tags(); ?>
                    <?php if ( $tags ) : ?>
                        <div class="mt-10 flex flex-wrap gap-3 border-t border-gray-100 pt-8 dark:border-slate-800">
                            <?php foreach ( $tags as $tag ) : ?>
                                <span class="inline-flex rounded-full bg-gray-100 px-4 py-2 text-sm font-medium text-gray-600 dark:bg-slate-800 dark:text-gray-300">
                                    <?php echo esc_html( $tag->name ); ?>
                                </span>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </article>

            <?php if ( comments_open() || get_comments_number() ) : ?>
                <section class="mt-10 rounded-[2rem] border border-gray-100 bg-white px-6 py-8 shadow-sm dark:border-slate-800 dark:bg-slate-900 sm:px-8 sm:py-10 lg:px-10">
                    <?php comments_template(); ?>
                </section>
            <?php endif; ?>
        <?php endwhile; ?>
    </div>
</main>

<?php get_footer(); ?>