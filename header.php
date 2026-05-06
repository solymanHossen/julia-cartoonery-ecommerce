<!DOCTYPE html>
<html <?php language_attributes(); ?> class="scroll-smooth">
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Bubblegum+Sans&family=Nunito:wght@400;600;700;800&family=Lora:ital,wght@0,400;0,600;1,400&display=swap" rel="stylesheet">
    <?php wp_head(); ?>
</head>
<body <?php body_class('min-h-screen bg-[#fafafc] dark:bg-slate-900 font-["Nunito"] text-slate-800 dark:text-slate-200 flex flex-col overflow-x-hidden selection:bg-[#FFB7C5] selection:text-white transition-colors duration-500'); ?>>
    <?php wp_body_open(); ?>

    <!-- Header Section -->
    <header class="sticky top-0 z-40 bg-white/80 dark:bg-slate-900/80 backdrop-blur-md shadow-sm border-b border-[#FFB7C5]/20 dark:border-slate-800 transition-colors duration-500">
        <div class="container mx-auto px-4 lg:px-8 py-4 flex items-center justify-between">
            
            <!-- 1. LOGO -->
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="flex items-center gap-3 cursor-pointer shrink-0">
                <div class="w-12 h-12 bg-[#FFB7C5] dark:bg-pink-500 rounded-full flex items-center justify-center shadow-inner text-white font-['Bubblegum_Sans'] text-2xl rotate-[-5deg] transition-colors">
                    JC
                </div>
                <h1 class="font-['Bubblegum_Sans'] text-2xl md:text-3xl tracking-wide bg-gradient-to-r from-[#FFB7C5] to-[#A8D8EA] dark:from-pink-400 dark:to-sky-400 bg-clip-text text-transparent hidden sm:block">
                    Julia's Cartoonery
                </h1>
            </a>

            <!-- 2. DYNAMIC DESKTOP NAV (Matches Image exactly) -->
            <nav class="hidden lg:flex items-center">
                <?php
                if ( has_nav_menu( 'primary' ) ) {
                    wp_nav_menu( array(
                        'theme_location' => 'primary',
                        'container'      => false,
                        'items_wrap'     => '<ul id="%1$s" class="flex items-center gap-6 xl:gap-8 font-bold text-gray-600 dark:text-gray-300">%3$s</ul>',
                    ) );
                }
                ?>
            </nav>

            <!-- 3. ACTION ICONS -->
            <div class="flex items-center gap-2 sm:gap-4 shrink-0">
                
                <!-- Moon/Sun Icon -->
                <button id="theme-toggle" class="p-2 text-gray-500 dark:text-gray-400 hover:text-[#A8D8EA] dark:hover:text-sky-300 transition-colors">
                    <svg id="theme-toggle-dark-icon" class="hidden w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z"/></svg>
                    <svg id="theme-toggle-light-icon" class="hidden w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="4"/><path d="M12 2v2"/><path d="M12 20v2"/><path d="m4.93 4.93 1.41 1.41"/><path d="m17.66 17.66 1.41 1.41"/><path d="M2 12h2"/><path d="M20 12h2"/><path d="m6.34 17.66-1.41 1.41"/><path d="m19.07 4.93-1.41 1.41"/></svg>
                </button>

                <!-- Search Icon -->
                <button class="p-2 text-gray-500 dark:text-gray-400 hover:text-[#A8D8EA] dark:hover:text-sky-300 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                </button>

                <!-- Wishlist Icon with Pink Badge -->
                <button type="button" id="wishlist-drawer-open" class="relative p-2 text-gray-500 dark:text-gray-400 hover:text-[#FFB7C5] dark:hover:text-pink-400 transition-colors group">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="group-hover:scale-110 transition-transform"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78Z"/></svg>
                    
                    <?php 
                    $wishlist = function_exists('julias_get_wishlist') ? julias_get_wishlist() : [];
                    $wishlist_count = count($wishlist); 
                    ?>
                    <span class="julias-wishlist-count absolute -top-1 -right-1 bg-red-400 text-white text-[10px] font-bold w-5 h-5 flex items-center justify-center rounded-full transition-transform duration-300 transform scale-100 <?php echo $wishlist_count == 0 ? 'hidden' : ''; ?>">
                        <?php echo esc_html( $wishlist_count ); ?>
                    </span>
                </button>

                <!-- Cart Icon with Red Badge -->
                <?php if ( class_exists( 'WooCommerce' ) ) : ?>
                    <a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="relative p-2 text-gray-500 dark:text-gray-400 hover:text-[#FFB7C5] dark:hover:text-pink-400 transition-colors group">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="group-hover:scale-110 transition-transform"><circle cx="8" cy="21" r="1"/><circle cx="19" cy="21" r="1"/><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"/></svg>
                        
                        <?php $cart_count = WC()->cart->get_cart_contents_count(); ?>
                        <span class="julias-cart-count absolute -top-1 -right-1 bg-red-400 text-white text-[10px] font-bold w-5 h-5 flex items-center justify-center rounded-full transition-transform duration-300 transform scale-100 <?php echo $cart_count == 0 ? 'hidden' : ''; ?>">
                            <?php echo esc_html( $cart_count ); ?>
                        </span>
                    </a>
                <?php endif; ?>

                <!-- User Icon / Avatar -->
                <?php 
                $myaccount_page_url = class_exists('WooCommerce') ? esc_url( get_permalink( get_option('woocommerce_myaccount_page_id') ) ) : esc_url( wp_login_url() );
                $is_logged_in = is_user_logged_in();
                ?>
                <div class="relative group flex items-center h-full">
                    <a href="<?php echo $myaccount_page_url; ?>" class="<?php echo $is_logged_in ? 'p-1.5' : 'p-2'; ?> text-gray-500 dark:text-gray-400 hover:text-[#B5EAD7] dark:hover:text-emerald-400 transition-colors flex items-center justify-center">
                        <?php if ( $is_logged_in ) : ?>
                            <div class="w-8 h-8 rounded-full overflow-hidden border-2 border-slate-200 dark:border-slate-700 group-hover:border-[#B5EAD7] dark:group-hover:border-emerald-400 transition-colors shadow-sm">
                                <?php echo get_avatar( get_current_user_id(), 64, '', 'User Avatar', array( 'class' => 'w-full h-full object-cover' ) ); ?>
                            </div>
                        <?php else : ?>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        <?php endif; ?>
                    </a>
                    
                    <!-- Dropdown (Only shows if logged in) -->
                    <?php if ( $is_logged_in ) : ?>
                        <div class="absolute right-0 top-full mt-2 w-48 bg-white dark:bg-slate-800 rounded-2xl shadow-xl border border-slate-100 dark:border-slate-700 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50 overflow-hidden transform origin-top-right group-hover:scale-100 scale-95">
                            <div class="px-4 py-3 border-b border-slate-100 dark:border-slate-700/50">
                                <p class="text-sm font-bold text-slate-800 dark:text-slate-100 truncate">
                                    <?php 
                                    $current_user = wp_get_current_user(); 
                                    echo esc_html( $current_user->display_name ); 
                                    ?>
                                </p>
                                <p class="text-xs text-slate-500 dark:text-slate-400 truncate">
                                    <?php echo esc_html( $current_user->user_email ); ?>
                                </p>
                            </div>
                            <div class="p-2">
                                <a href="<?php echo $myaccount_page_url; ?>" class="flex items-center px-3 py-2 text-sm font-medium text-slate-600 dark:text-slate-300 hover:text-[#FFB7C5] hover:bg-slate-50 dark:hover:bg-slate-700/50 rounded-lg transition-colors">
                                    Dashboard
                                </a>
                                <a href="<?php echo esc_url( wc_logout_url() ); ?>" class="flex items-center px-3 py-2 mt-1 text-sm font-medium text-red-500 hover:bg-red-50 dark:hover:bg-red-500/10 rounded-lg transition-colors">
                                    Logout
                                </a>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                
                <!-- Mobile Hamburger -->
                <button id="mobile-menu-open" class="lg:hidden p-3 text-gray-500 dark:text-gray-400">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="4" x2="20" y1="12" y2="12"/><line x1="4" x2="20" y1="6" y2="6"/><line x1="4" x2="20" y1="18" y2="18"/></svg>
                </button>
            </div>
        </div>
    </header>

    <!-- MOBILE DRAWER KEEP AS BEFORE -->
    <div id="mobile-drawer" class="fixed inset-0 z-[60] bg-black/40 opacity-0 pointer-events-none transition-opacity duration-300 lg:hidden">
        <div id="drawer-content" class="absolute right-0 top-0 bottom-0 w-64 bg-white dark:bg-slate-800 shadow-2xl p-6 transform translate-x-full transition-transform duration-300 flex flex-col">
            <div class="flex justify-between items-center mb-8">
                <h2 class="font-['Bubblegum_Sans'] text-xl text-[#FFB7C5] dark:text-pink-400">Menu</h2>
                <button id="mobile-menu-close" class="p-3 bg-gray-100 dark:bg-slate-700 rounded-full text-gray-600 dark:text-gray-300 transition-colors hover:bg-gray-200 dark:hover:bg-slate-600">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                </button>
            </div>
            <nav class="flex flex-col gap-2 flex-grow">
                <?php
                if ( has_nav_menu( 'primary' ) ) {
                    wp_nav_menu( array(
                        'theme_location' => 'primary',
                        'container'      => false,
                        'items_wrap'     => '<ul id="%1$s" class="flex flex-col gap-2">%3$s</ul>',
                        'link_before'    => '<span class="text-lg font-bold p-3 block rounded-2xl text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors">',
                        'link_after'     => '</span>',
                    ) );
                }
                ?>
            </nav>
        </div>
    </div>

    <!-- WISHLIST DRAWER -->
    <div id="wishlist-drawer" class="fixed inset-0 z-[70] bg-black/40 opacity-0 pointer-events-none transition-opacity duration-300">
        <div id="wishlist-drawer-content" class="absolute right-0 top-0 bottom-0 w-[340px] max-w-[90vw] bg-white dark:bg-slate-900 shadow-2xl flex flex-col transform translate-x-full transition-transform duration-400">
            <!-- Header -->
            <div class="flex justify-between items-center p-5 border-b border-slate-100 dark:border-slate-800">
                <div class="flex items-center gap-2 text-[#FFB7C5]">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                    <h2 class="font-['Bubblegum_Sans'] text-2xl">Wishlist</h2>
                </div>
                <button id="wishlist-drawer-close" class="p-2  text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 transition-colors rounded-full hover:bg-slate-50 dark:hover:bg-slate-800">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <!-- Items Area -->
            <div id="wishlist-drawer-items" class="flex-1 overflow-y-auto relative bg-slate-50 dark:bg-slate-900/50">
                <div class="flex flex-col items-center justify-center h-full text-slate-400">
                    <svg class="w-8 h-8 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                </div>
            </div>
        </div>
    </div>