<!DOCTYPE html>
<html <?php language_attributes(); ?> class="scroll-smooth">
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Bubblegum+Sans&family=Nunito:wght@400;600;700;800&family=Lora:ital,wght@0,400;0,600;1,400&display=swap" rel="stylesheet">
    <?php wp_head(); ?>
</head>
<body <?php body_class('bg-[#fafafc] dark:bg-slate-900 transition-colors duration-500'); ?>>

    <header class="sticky top-0 z-40 bg-white/80 dark:bg-slate-900/80 backdrop-blur-md shadow-sm border-b border-pinkBrand/20 dark:border-slate-800 transition-colors duration-500">
        <div class="container mx-auto px-4 lg:px-8 py-4 flex items-center justify-between">
            
            <!-- LOGO -->
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="flex items-center gap-3">
                <div class="w-12 h-12 bg-pinkBrand dark:bg-pink-500 rounded-full flex items-center justify-center shadow-inner text-white font-bubblegum text-2xl rotate-[-5deg] transition-colors">
                    JC
                </div>
                <h1 class="font-bubblegum text-2xl md:text-3xl tracking-wide bg-gradient-to-r from-pinkBrand to-blueBrand dark:from-pink-400 dark:to-sky-400 bg-clip-text text-transparent hidden sm:block">
                    Julia's Cartoonery
                </h1>
            </a>

            <!-- DYNAMIC DESKTOP NAV -->
            <nav class="hidden lg:flex items-center gap-6 xl:gap-8">
                <?php
                wp_nav_menu( array(
                    'theme_location' => 'primary',
                    'container'      => false,
                    'menu_class'     => 'flex gap-6 xl:gap-8 font-bold text-gray-600 dark:text-gray-300',
                    'items_wrap'     => '%3$s', // এটি শুধু লিষ্ট আইটেমগুলো দেবে
                    'fallback_cb'    => false,
                    'link_before'    => '<span class="hover:text-pinkBrand dark:hover:text-pink-400 transition-colors relative">',
                    'link_after'     => '</span>',
                ) );
                ?>
            </nav>

            <!-- ACTION BUTTONS -->
            <div class="flex items-center gap-1 sm:gap-3">
                <!-- Bedtime Mode -->
                <button id="theme-toggle" class="p-2 text-gray-500 dark:text-gray-400 hover:text-blueBrand dark:hover:text-sky-300 transition-colors">
                    <svg id="theme-toggle-dark-icon" class="hidden w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path></svg>
                    <svg id="theme-toggle-light-icon" class="hidden w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.707.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.464 5.05l-.707-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"></path></svg>
                </button>

                <!-- Search -->
                <button class="p-2 text-gray-500 dark:text-gray-400 hover:text-blueBrand"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="lucide lucide-search"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg></button>

                <!-- Cart -->
                <?php if ( function_exists( 'wc_get_cart_url' ) ) : ?>
                    <?php $cart_count = ( function_exists( 'WC' ) && WC()->cart ) ? WC()->cart->get_cart_contents_count() : 0; ?>
                    <a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="relative p-2 text-gray-500 dark:text-gray-400 hover:text-pinkBrand group">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="group-hover:scale-110 transition-transform"><circle cx="8" cy="21" r="1"/><circle cx="19" cy="21" r="1"/><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"/></svg>
                        <span class="absolute -top-1 -right-1 bg-red-400 text-white text-[10px] font-bold w-5 h-5 flex items-center justify-center rounded-full animate-bounce">
                            <?php echo esc_html( $cart_count ); ?>
                        </span>
                    </a>
                <?php endif; ?>

                <!-- Mobile Menu Button -->
                <button id="mobile-menu-open" class="lg:hidden p-2 text-gray-500 dark:text-gray-400"><svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="4" x2="20" y1="12" y2="12"/><line x1="4" x2="20" y1="6" y2="6"/><line x1="4" x2="20" y1="18" y2="18"/></svg></button>
            </div>
        </div>
    </header>

    <!-- MOBILE MENU DRAWER -->
    <div id="mobile-drawer" class="fixed inset-0 z-[60] bg-black/40 opacity-0 pointer-events-none transition-opacity duration-300">
        <div id="drawer-content" class="absolute right-0 top-0 bottom-0 w-64 bg-white dark:bg-slate-800 shadow-2xl p-6 translate-x-full transition-transform duration-300">
            <div class="flex justify-between items-center mb-8">
                <h2 class="font-bubblegum text-xl text-pinkBrand">Menu</h2>
                <button id="mobile-menu-close" class="p-2 bg-gray-100 dark:bg-slate-700 rounded-full"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg></button>
            </div>
            <nav class="flex flex-col gap-2">
                <?php
                wp_nav_menu( array(
                    'theme_location' => 'primary',
                    'container'      => false,
                    'menu_class'     => 'mobile-nav',
                    'items_wrap'     => '%3$s',
                    'link_before'    => '<span class="text-lg font-bold p-3 block rounded-2xl text-gray-600 dark:text-gray-300">',
                    'link_after'     => '</span>',
                ) );
                ?>
            </nav>
        </div>
    </div>