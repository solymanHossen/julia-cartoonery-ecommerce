<?php
/**
 * The template for displaying Stories Archive (Rupkothar Gollpo)
 */
get_header(); ?>

<!-- Hexagon/Cubes Background Pattern -->
<main class="min-h-screen container mx-auto px-4 lg:px-8 py-12 animate-in fade-in bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] dark:bg-blend-multiply">
    
    <!-- Header Section (Icon & Titles) -->
    <div class="flex flex-col items-center text-center mb-16">
        <div class="w-20 h-20 bg-[#FFDAC1] dark:bg-orange-900/40 rounded-full flex items-center justify-center mb-4 shadow-inner">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-orange-400 dark:text-orange-300 w-10 h-10">
                <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/>
            </svg>
        </div>
        <h1 class="font-['Bubblegum_Sans'] text-5xl text-[#1e293b] dark:text-gray-100 mb-4">Rupkothar Gollpo</h1>
        <p class="text-gray-500 dark:text-gray-400">Magical stories for bedtime and beyond.</p>
    </div>

    <!-- 3D Bookshelf Section -->
    <div class="relative mt-12">
        <!-- The White translucent background & Wooden Shelf -->
        <div class="bg-white/60 dark:bg-slate-800/50 backdrop-blur-sm rounded-t-3xl pt-16 pb-4 px-8 border-b-[16px] border-[#d4a373] dark:border-[#8b5a2b] shadow-[0_15px_30px_rgba(0,0,0,0.1)] flex justify-center gap-8 lg:gap-16 flex-wrap">
            
            <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                
                <!-- 3D Book Card -->
                <div class="relative group cursor-pointer perspective-1000 -mt-8" onclick="window.location.href='<?php the_permalink(); ?>'">
                    <!-- Book Drop Shadow -->
                    <div class="absolute inset-0 bg-black/20 translate-x-2 translate-y-2 rounded-r-lg blur-sm group-hover:translate-x-4 group-hover:translate-y-4 transition-transform"></div>
                    
                    <!-- Book Body (Pink Left Border matches the spine) -->
                    <div class="relative w-44 h-64 lg:w-48 lg:h-72 bg-white dark:bg-slate-800 rounded-r-xl border-l-[12px] border-[#FFB7C5] dark:border-pink-600 shadow-sm transform group-hover:-translate-y-4 group-hover:rotate-[-4deg] transition-all duration-300 overflow-hidden flex flex-col">
                        
                        <?php if(has_post_thumbnail()): ?>
                            <img src="<?php the_post_thumbnail_url('medium'); ?>" alt="<?php the_title_attribute(); ?>" class="w-full h-[65%] object-cover" />
                        <?php else: ?>
                            <div class="w-full h-[65%] bg-gray-100 dark:bg-slate-700"></div>
                        <?php endif; ?>
                        
                        <!-- Book Title Area -->
                        <div class="p-4 bg-white dark:bg-slate-800 flex-grow flex flex-col justify-center text-center border-t border-gray-100 dark:border-slate-700">
                            <h3 class="font-['Bubblegum_Sans'] text-base leading-tight text-gray-800 dark:text-gray-200"><?php the_title(); ?></h3>
                        </div>
                    </div>
                </div>

            <?php endwhile; else: ?>
                <p class="text-gray-500 dark:text-gray-400">No stories found. Please add some from the dashboard!</p>
            <?php endif; ?>

        </div>
    </div>
</main>

<?php get_footer(); ?>