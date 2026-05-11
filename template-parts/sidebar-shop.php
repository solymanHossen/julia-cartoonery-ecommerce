<?php
defined( 'ABSPATH' ) || exit;

// Get the current category slug if we are on a category page
$current_term     = is_product_category() ? get_queried_object() : null;
$current_cat_slug = $current_term ? $current_term->slug : 'all';

$terms = get_terms( array( 'taxonomy' => 'product_cat', 'hide_empty' => true ) );

$all_count = 0;
if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
  foreach ( $terms as $term ) {
    $all_count += (int) $term->count;
  }
}
?>
<div class="sidebar-shop rounded-[28px] border border-slate-100 bg-gradient-to-br from-white to-slate-50 p-4 shadow-[0_8px_30px_rgba(15,23,42,0.05)] dark:border-slate-700 dark:from-slate-800 dark:to-slate-800 sm:p-5 lg:rounded-[32px] lg:p-6">
  <h3 class="flex items-center justify-between border-b border-slate-100 pb-3 text-[1rem] font-bold tracking-tight text-slate-800 dark:border-slate-700 dark:text-slate-100 lg:pb-4 lg:text-[1.05rem]">
    <span>Categories</span>
    <span class="rounded-full bg-slate-100 px-2.5 py-1 text-[0.65rem] font-bold uppercase tracking-[0.12em] text-slate-500 dark:bg-slate-700 dark:text-slate-300">Shop</span>
  </h3>

  <ul class="mt-3 flex flex-wrap gap-2 lg:mt-4 lg:flex lg:flex-col lg:space-y-2.5 lg:gap-0">
    
    <!-- 'All' Category Link (Main Shop Page) -->
    <li class="flex-shrink-0 min-w-0">
      <a href="<?php echo esc_url( get_post_type_archive_link( 'product' ) ); ?>" class="inline-flex items-center gap-1.5 sm:gap-2 rounded-full px-3 py-2 sm:px-4 sm:py-2.5 text-[0.77rem] sm:text-[0.88rem] font-semibold transition-all duration-200 lg:flex lg:w-full lg:justify-between lg:rounded-2xl lg:px-4 lg:py-3 lg:text-[1rem] <?php echo 'all' === $current_cat_slug ? 'bg-[#FFB7C5]/18 text-[#FF6F95] shadow-[0_8px_24px_rgba(255,183,197,0.25)] ring-1 ring-[#FFB7C5]/35' : 'bg-white text-slate-600 ring-1 ring-slate-200 hover:bg-slate-50 hover:text-slate-800 dark:bg-slate-800 dark:text-slate-300 dark:ring-slate-600 dark:hover:bg-slate-700 dark:hover:text-slate-100'; ?>">
        <span class="truncate">All</span>
        <span class="rounded-full bg-slate-100 px-1.5 sm:px-2 py-0.5 text-[0.6rem] sm:text-[0.68rem] font-bold text-slate-500 dark:bg-slate-700 dark:text-slate-300 flex-shrink-0"><?php echo esc_html( $all_count ); ?></span>
      </a>
    </li>
    
    <!-- Dynamic WooCommerce Categories -->
    <?php if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) : ?>
      <?php foreach ( $terms as $term ) : ?>
        <?php
        // Generate native WooCommerce category link
        $link   = get_term_link( $term, 'product_cat' );
        $active = ( $current_cat_slug === $term->slug );
        ?>
        <li class="flex-shrink-0 min-w-0">
          <a href="<?php echo esc_url( $link ); ?>" class="inline-flex items-center gap-1.5 sm:gap-2 rounded-full px-3 py-2 sm:px-4 sm:py-2.5 text-[0.77rem] sm:text-[0.88rem] font-semibold transition-all duration-200 lg:flex lg:w-full lg:justify-between lg:rounded-2xl lg:px-4 lg:py-3 lg:text-[1rem] <?php echo $active ? 'bg-[#FFB7C5]/18 text-[#FF6F95] shadow-[0_8px_24px_rgba(255,183,197,0.25)] ring-1 ring-[#FFB7C5]/35' : 'bg-white text-slate-600 ring-1 ring-slate-200 hover:bg-slate-50 hover:text-slate-800 dark:bg-slate-800 dark:text-slate-300 dark:ring-slate-600 dark:hover:bg-slate-700 dark:hover:text-slate-100'; ?>">
            <span class="truncate"><?php echo esc_html( $term->name ); ?></span>
            <span class="rounded-full bg-slate-100 px-1.5 sm:px-2 py-0.5 text-[0.6rem] sm:text-[0.68rem] font-bold text-slate-500 dark:bg-slate-700 dark:text-slate-300 flex-shrink-0"><?php echo esc_html( (int) $term->count ); ?></span>
          </a>
        </li>
      <?php endforeach; ?>
    <?php endif; ?>
    
  </ul>
</div>