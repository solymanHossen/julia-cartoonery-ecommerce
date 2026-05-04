<?php get_header(); ?>

<div class="bg-gray-50 min-h-screen py-12">
    <div class="container mx-auto px-4">
        <?php while ( have_posts() ) : the_post(); ?>
            
            <article class="max-w-4xl mx-auto bg-white rounded-3xl shadow-xl overflow-hidden">
                
                <!-- Post Thumbnail -->
                <?php if ( has_post_thumbnail() ) : ?>
                    <div class="w-full h-[400px] md:h-[500px]">
                        <?php the_post_thumbnail( 'full', ['class' => 'w-full h-full object-cover'] ); ?>
                    </div>
                <?php endif; ?>

                <div class="p-8 md:p-14">
                    <!-- Categories -->
                    <div class="mb-4">
                        <?php the_category( ' <span class="mx-2 text-gray-300">|</span> ' ); ?>
                    </div>

                    <!-- Post Title -->
                    <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-6 leading-tight">
                        <?php the_title(); ?>
                    </h1>

                    <!-- Author and Date Meta -->
                    <div class="flex items-center text-gray-600 text-sm mb-10 pb-8 border-b border-gray-200">
                        <div class="flex items-center mr-6">
                            <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            <span class="font-medium"><?php the_author(); ?></span>
                        </div>
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <span><?php echo get_the_date(); ?></span>
                        </div>
                    </div>

                    <!-- Post Content -->
                    <!-- 'prose' class is from Tailwind Typography plugin. It auto-styles HTML content inside it -->
                    <div class="prose prose-lg prose-indigo max-w-none text-gray-800 leading-relaxed">
                        <?php the_content(); ?>
                    </div>
                    
                    <!-- Tags -->
                    <div class="mt-10 pt-6 border-t border-gray-100">
                        <?php the_tags( '<span class="font-semibold text-gray-700">Tags: </span> <span class="inline-block bg-gray-100 rounded-full px-3 py-1 text-sm font-semibold text-gray-600 mr-2 mb-2">', '</span><span class="inline-block bg-gray-100 rounded-full px-3 py-1 text-sm font-semibold text-gray-600 mr-2 mb-2">', '</span>' ); ?>
                    </div>
                </div>
            </article>

            <!-- Comments Section -->
            <div class="max-w-4xl mx-auto mt-12 bg-white rounded-3xl shadow-xl p-8 md:p-14">
                <?php 
                    if ( comments_open() || get_comments_number() ) :
                        comments_template();
                    endif;
                ?>
            </div>

        <?php endwhile; ?>
    </div>
</div>

<?php get_footer(); ?>