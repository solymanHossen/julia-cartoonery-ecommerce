<?php
/**
 * The template for displaying 404 (Page Not Found) errors
 */
get_header(); ?>

<main class="min-h-screen bg-gradient-to-br from-indigo-50 via-white to-pink-50 dark:from-slate-900 dark:via-slate-800 dark:to-slate-900 py-16 lg:py-24 relative overflow-hidden">
    
    <!-- Decorative background elements -->
    <div class="absolute top-20 left-10 w-64 h-64 bg-pink-300/20 dark:bg-pink-900/20 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-20 right-10 w-80 h-80 bg-blue-300/20 dark:bg-blue-900/20 rounded-full blur-3xl pointer-events-none"></div>

    <div class="container mx-auto px-4 lg:px-8 relative z-10 max-w-2xl text-center">
        
        <!-- 404 Illustration -->
        <div class="mb-12">
            <div class="text-9xl font-['Bubblegum_Sans'] text-[#FFB7C5] dark:text-pink-400 drop-shadow-xl">404</div>
        </div>

        <!-- Heading -->
        <h1 class="font-['Bubblegum_Sans'] text-5xl lg:text-6xl text-slate-800 dark:text-white mb-6 drop-shadow-sm">
            <?php esc_html_e( "Oops! Page Not Found", 'julias-cartoonery' ); ?>
        </h1>

        <!-- Description -->
        <p class="text-lg lg:text-xl text-gray-600 dark:text-gray-300 mb-10 max-w-xl mx-auto leading-relaxed">
            <?php esc_html_e( "The page you're looking for seems to have wandered off into the cartoon world. Let's get you back on track!", 'julias-cartoonery' ); ?>
        </p>

        <!-- Search Form -->
        <div class="mb-12">
            <?php get_search_form(); ?>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
            <a 
                href="<?php echo esc_url( home_url( '/' ) ); ?>" 
                class="inline-flex items-center gap-2 px-8 py-4 bg-[#FFB7C5] dark:bg-pink-500 text-white font-bold rounded-full hover:bg-pink-400 dark:hover:bg-pink-600 transition-colors shadow-lg hover:shadow-xl"
            >
                <?php esc_html_e( 'Back to Home', 'julias-cartoonery' ); ?> ←
            </a>
            <a 
                href="<?php echo esc_url( home_url( '/blog/' ) ); ?>" 
                class="inline-flex items-center gap-2 px-8 py-4 bg-[#A8D8EA] dark:bg-sky-500 text-white font-bold rounded-full hover:bg-sky-400 dark:hover:bg-sky-600 transition-colors shadow-lg hover:shadow-xl"
            >
                <?php esc_html_e( 'Visit Blog', 'julias-cartoonery' ); ?> →
            </a>
        </div>

        <!-- Popular Links -->
        <div class="mt-16 pt-12 border-t border-gray-200 dark:border-slate-700">
            <h3 class="text-sm font-bold text-gray-500 dark:text-gray-400 uppercase tracking-widest mb-6"><?php esc_html_e( 'Explore', 'julias-cartoonery' ); ?></h3>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="<?php echo esc_url( home_url( '/stories/' ) ); ?>" class="text-[#A8D8EA] dark:text-sky-400 hover:text-sky-600 dark:hover:text-sky-300 font-bold transition-colors">
                    <?php esc_html_e( 'Stories', 'julias-cartoonery' ); ?>
                </a>
                <span class="text-gray-300 dark:text-slate-600">•</span>
                <a href="<?php echo esc_url( home_url( '/characters/' ) ); ?>" class="text-[#FFB7C5] dark:text-pink-400 hover:text-pink-600 dark:hover:text-pink-300 font-bold transition-colors">
                    <?php esc_html_e( 'Characters', 'julias-cartoonery' ); ?>
                </a>
                <span class="text-gray-300 dark:text-slate-600">•</span>
                <a href="<?php echo esc_url( home_url( '/games/' ) ); ?>" class="text-[#A8D8EA] dark:text-sky-400 hover:text-sky-600 dark:hover:text-sky-300 font-bold transition-colors">
                    <?php esc_html_e( 'Games', 'julias-cartoonery' ); ?>
                </a>
            </div>
        </div>
    </div>
</main>

<?php get_footer(); ?>
