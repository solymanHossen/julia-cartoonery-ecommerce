<?php
defined( 'ABSPATH' ) || exit;

// Get the current category slug if we are on a category page
$current_term     = is_product_category() ? get_queried_object() : null;
$current_cat_slug = $current_term ? $current_term->slug : 'all';

$terms = get_terms( array( 'taxonomy' => 'product_cat', 'hide_empty' => true ) );
?>
<div class="rounded-[32px] border border-slate-100 bg-white p-6 shadow-[0_2px_12px_rgba(15,23,42,0.05)] dark:border-slate-700 dark:bg-slate-800">
  <h3 class="border-b border-slate-100 pb-4 text-[1.05rem] font-bold tracking-tight text-slate-800 dark:border-slate-700 dark:text-slate-100">Categories</h3>

  <ul class="mt-4 space-y-2.5">
    
    <!-- 'All' Category Link (Main Shop Page) -->
    <li>
      <a href="<?php echo esc_url( get_post_type_archive_link( 'product' ) ); ?>" class="block rounded-2xl px-4 py-3 text-[1rem] transition-all duration-200 <?php echo 'all' === $current_cat_slug ? 'bg-[#FFB7C5]/15 text-[#FFB7C5] font-bold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-800 dark:text-slate-400 dark:hover:bg-slate-700 dark:hover:text-slate-100'; ?>">All</a>
    </li>
    
    <!-- Dynamic WooCommerce Categories -->
    <?php if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) : ?>
      <?php foreach ( $terms as $term ) : ?>
        <?php
        // Generate native WooCommerce category link
        $link   = get_term_link( $term, 'product_cat' );
        $active = ( $current_cat_slug === $term->slug );
        ?>
        <li>
          <a href="<?php echo esc_url( $link ); ?>" class="block rounded-2xl px-4 py-3 text-[1rem] transition-all duration-200 <?php echo $active ? 'bg-[#FFB7C5]/15 text-[#FFB7C5] font-bold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-800 dark:text-slate-400 dark:hover:bg-slate-700 dark:hover:text-slate-100'; ?>"><?php echo esc_html( $term->name ); ?></a>
        </li>
      <?php endforeach; ?>
    <?php endif; ?>
    
  </ul>
</div>