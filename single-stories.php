<?php
/**
 * The template for displaying a Single Story
 */
get_header(); 

// Helper function to get exact URL for pagination
function get_story_page_url($i) {
    global $post;
    if ( 1 == $i ) return get_permalink();
    if ( '' == get_option('permalink_structure') || in_array($post->post_status, array('draft', 'pending')) )
        return add_query_arg( 'page', $i, get_permalink() );
    return trailingslashit(get_permalink()) . user_trailingslashit($i, 'single_paged');
}
?>

<main class="min-h-[80vh] bg-[#fdfbf7] dark:bg-slate-900 py-12 animate-in fade-in transition-colors">
    <div class="container mx-auto px-4 lg:px-8">
        
        <!-- Back to Library Link -->
        <a href="<?php echo get_post_type_archive_link('stories'); ?>" class="inline-flex items-center gap-2 mb-8 text-gray-600 dark:text-gray-400 hover:text-[#FFB7C5] dark:hover:text-pink-400 font-semibold transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
            Back to Library
        </a>

        <?php while ( have_posts() ) : the_post(); 
            global $page, $numpages;
            $current_page = $page ? $page : 1;
            $total_pages  = $numpages ? $numpages : 1;
        ?>
            <!-- Main Content Card with Thick Pink Border -->
            <div class="max-w-4xl mx-auto bg-white dark:bg-slate-800 rounded-t-3xl rounded-b-md shadow-2xl border-x-8 border-t-8 border-[#FFB7C5] dark:border-pink-600 overflow-hidden transition-colors relative">
                
                <!-- Hero Image & Page Badge -->
                <div class="w-full h-[40vh] bg-gray-100 dark:bg-slate-700 relative">
                    <?php if(has_post_thumbnail()): ?>
                        <img src="<?php the_post_thumbnail_url('large'); ?>" class="w-full h-full object-cover mix-blend-multiply dark:mix-blend-normal" alt="<?php the_title_attribute(); ?>" />
                    <?php endif; ?>
                    
                    <!-- Dynamic Page Badge -->
                    <div class="absolute top-4 right-4 z-10 bg-white/90 dark:bg-slate-800/90 backdrop-blur px-4 py-1.5 rounded-full text-xs font-bold text-gray-600 dark:text-gray-300 shadow-sm">
                        Page <?php echo $current_page; ?> of <?php echo $total_pages; ?>
                    </div>
                </div>

                <!-- Story Text Area -->
                <div class="p-8 md:p-16 text-center bg-[#fffcf5] dark:bg-slate-800 transition-colors">
                    <h1 class="font-['Bubblegum_Sans'] text-3xl text-gray-300 dark:text-gray-600 mb-8 border-b-2 border-dashed border-gray-200 dark:border-slate-700 pb-4 inline-block">
                        <?php the_title(); ?>
                    </h1>
                    
                    <div class="font-['Lora'] text-xl md:text-2xl leading-relaxed text-gray-800 dark:text-gray-200">
                        <?php 
                        $content = get_the_content();
                        $content = apply_filters('the_content', $content);
                        echo $content;
                        ?>
                    </div>
                </div>

                <!-- Custom Pagination -->
                <div class="flex items-center justify-between p-6 bg-gray-50 dark:bg-slate-800/50 border-t border-gray-100 dark:border-slate-700 transition-colors">
                    
                    <!-- Previous Button -->
                    <?php if ( $current_page > 1 ) : ?>
                        <a href="<?php echo get_story_page_url($current_page - 1); ?>" class="px-6 py-2 bg-gray-200 dark:bg-slate-700 text-gray-800 dark:text-gray-200 rounded-lg hover:bg-gray-300 dark:hover:bg-slate-600 font-semibold transition-colors">
                            &larr; Previous Page
                        </a>
                    <?php else : ?>
                        <button disabled class="px-6 py-2 bg-gray-100 dark:bg-slate-800 text-gray-400 dark:text-gray-600 rounded-lg font-semibold cursor-not-allowed opacity-50">
                            &larr; Previous Page
                        </button>
                    <?php endif; ?>
                    
                    <!-- Next / Finish Button -->
                    <?php if ( $current_page < $total_pages ) : ?>
                        <a href="<?php echo get_story_page_url($current_page + 1); ?>" class="px-6 py-2 bg-[#B5EAD7] dark:bg-emerald-600 text-emerald-900 dark:text-white rounded-lg hover:bg-emerald-300 dark:hover:bg-emerald-500 font-semibold transition-colors">
                            Next Page &rarr;
                        </a>
                    <?php else : ?>
                        <a href="<?php echo get_post_type_archive_link('stories'); ?>" class="px-6 py-2 bg-[#FFB7C5] dark:bg-pink-600 text-white rounded-lg hover:bg-pink-400 dark:hover:bg-pink-500 font-semibold transition-colors">
                            Finish Book
                        </a>
                    <?php endif; ?>

                </div>

            </div>
        <?php endwhile; ?>
        
    </div>
</main>

<?php get_footer(); ?>