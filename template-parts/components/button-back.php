<?php
/**
 * UI Component: Global Back Button
 * React-এর মতো Props হিসেবে আমরা 'url' এবং 'text' পাস করব।
 */

// Props রিসিভ করা (যদি কিছু পাস না করা হয়, তবে ডিফল্ট ভ্যালু বসবে)
$url  = !empty( $args['url'] ) ? $args['url'] : home_url();
$text = !empty( $args['text'] ) ? $args['text'] : 'Go Back';
?>

<a href="<?php echo esc_url( $url ); ?>" class="group inline-flex items-center gap-2 mb-8 px-5 py-2.5 -ml-5 text-gray-500 dark:text-gray-400 font-bold rounded-full hover:bg-pink-50 dark:hover:bg-slate-800 hover:text-[#FF9CB0] dark:hover:text-pink-400 transition-all duration-300 active:scale-95">
    <!-- Smooth Arrow SVG -->
    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="transition-transform duration-300 group-hover:-translate-x-1.5">
        <path d="m15 18-6-6 6-6"/>
    </svg>
    <!-- Dynamic Text -->
    <?php echo esc_html( $text ); ?>
</a>