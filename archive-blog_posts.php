<?php get_header(); ?>

<div class="container mx-auto px-4 py-16 max-w-7xl">
    <div class="text-center mb-12">
        <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-4">Our Latest Blogs</h1>
        <p class="text-lg text-gray-600">Read the best articles written by our amazing community.</p>
    </div>

    <?php if ( have_posts() ) : ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php while ( have_posts() ) : the_post(); ?>
                
                <!-- Single Blog Card -->
                <article class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden flex flex-col transform hover:-translate-y-1">
                    
                    <!-- Thumbnail -->
                    <?php if ( has_post_thumbnail() ) : ?>
                        <a href="<?php the_permalink(); ?>" class="block overflow-hidden h-56">
                            <?php the_post_thumbnail( 'large', ['class' => 'w-full h-full object-cover transition-transform duration-500 hover:scale-105'] ); ?>
                        </a>
                    <?php else: ?>
                        <!-- Fallback Image if no thumbnail -->
                        <div class="w-full h-56 bg-gray-200 flex items-center justify-center text-gray-400">No Image</div>
                    <?php endif; ?>

                    <!-- Content -->
                    <div class="p-6 flex flex-col flex-grow">
                        <div class="text-xs font-semibold text-indigo-600 mb-2 uppercase tracking-wider">
                            <?php echo get_the_date(); ?>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900 mb-3 leading-tight">
                            <a href="<?php the_permalink(); ?>" class="hover:text-indigo-600 transition-colors"><?php the_title(); ?></a>
                        </h2>
                        <div class="text-gray-600 mb-6 flex-grow line-clamp-3">
                            <?php echo wp_trim_words( get_the_excerpt(), 20, '...' ); ?>
                        </div>
                        
                        <!-- Read More Button & Author -->
                        <div class="flex items-center justify-between mt-auto pt-4 border-t border-gray-100">
                            <span class="text-sm font-medium text-gray-700">By <?php the_author(); ?></span>
                            <a href="<?php the_permalink(); ?>" class="text-indigo-600 font-semibold hover:text-indigo-800 flex items-center">
                                Read More 
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </a>
                        </div>
                    </div>
                </article>

            <?php endwhile; ?>
        </div>

        <!-- Pagination -->
        <div class="mt-12 flex justify-center gap-2">
            <?php 
                echo paginate_links( array(
                    'prev_text' => '&laquo; Prev',
                    'next_text' => 'Next &raquo;',
                    'class'     => 'pagination-links' // আপনি চাইলে CSS এ স্টাইল করতে পারেন
                ) ); 
            ?>
        </div>

    <?php else : ?>
        <div class="text-center py-20">
            <h2 class="text-2xl text-gray-500">No blog posts found yet!</h2>
        </div>
    <?php endif; ?>
</div>

<?php get_footer(); ?>