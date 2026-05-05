<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$current_label = isset( $catalog_orderby_options[ $orderby ] ) ? $catalog_orderby_options[ $orderby ] : current( $catalog_orderby_options );
?>

<form class="woocommerce-ordering m-0 relative z-50" method="get">
    <select name="orderby" class="orderby hidden" aria-label="<?php esc_attr_e( 'Shop order', 'woocommerce' ); ?>">
        <?php foreach ( $catalog_orderby_options as $id => $name ) : ?>
            <option value="<?php echo esc_attr( $id ); ?>" <?php selected( $orderby, $id ); ?>><?php echo esc_html( $name ); ?></option>
        <?php endforeach; ?>
    </select>

    <input type="hidden" name="paged" value="1" />
    <?php wc_query_string_form_fields( null, array( 'orderby', 'submit', 'paged', 'product-page' ) ); ?>

    <div class="relative" id="custom-dropdown-wrapper">
        <button type="button" id="dropdown-trigger" class="group flex items-center gap-3 rounded-full border border-slate-200 bg-white px-5 py-2.5 shadow-[0_2px_10px_rgba(15,23,42,0.06)] transition-all duration-300 hover:border-[#FFB7C5] hover:shadow-[0_8px_20px_rgba(255,183,197,0.1)] dark:border-slate-700/50 dark:bg-slate-800/60 dark:shadow-[0_8px_30px_rgba(0,0,0,0.12)] dark:hover:border-[#FFB7C5]/50 dark:hover:bg-slate-800/80 dark:hover:shadow-[0_0_25px_rgba(255,183,197,0.15)] focus:outline-none">
            <svg class="h-5 w-5 text-slate-400 dark:text-[#FFB7C5] dark:drop-shadow-[0_0_8px_rgba(255,183,197,0.4)]" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                <path d="M3 5h18l-7 8v5l-4 2v-7L3 5Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round" />
            </svg>

            <span class="text-sm font-semibold text-slate-600 dark:text-slate-200 tracking-wide" id="dropdown-label">
                <?php echo esc_html( $current_label ); ?>
            </span>

            <svg class="h-4 w-4 text-slate-400 transition-transform duration-300 group-hover:text-slate-600 dark:group-hover:text-white" id="dropdown-arrow" viewBox="0 0 20 20" fill="none" aria-hidden="true">
                <path d="M6 8l4 4 4-4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </button>

        <div id="dropdown-menu" class="absolute right-0 top-[120%] mt-2 w-64 origin-top-right rounded-3xl border border-slate-100 bg-white shadow-[0_20px_50px_rgba(15,23,42,0.08)] p-2.5 opacity-0 invisible scale-95 transition-all duration-300 pointer-events-none dark:border-white/10 dark:bg-slate-900/90 dark:shadow-[0_30px_60px_rgba(0,0,0,0.6)]">
            <ul class="flex flex-col gap-1 m-0 p-0">
                <?php foreach ( $catalog_orderby_options as $id => $name ) : ?>
                    <li class="list-none">
                        <button type="button" data-value="<?php echo esc_attr( $id ); ?>" class="sort-option flex w-full items-center rounded-2xl px-4 py-3 text-left text-[1rem] font-medium transition-all duration-200 <?php echo $orderby === $id ? 'bg-[#FFB7C5]/15 text-[#FFB7C5] font-bold shadow-inner dark:bg-[#FFB7C5]/15 dark:text-[#FFB7C5] dark:shadow-inner' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-800 dark:text-slate-300 dark:hover:bg-white/10 dark:hover:text-white'; ?>">
                            <?php echo esc_html( $name ); ?>
                            <?php if ( $orderby === $id ) : ?>
                                <svg class="ml-auto h-5 w-5 text-[#FFB7C5] dark:drop-shadow-[0_0_5px_rgba(255,183,197,0.5)]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                            <?php endif; ?>
                        </button>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</form>

<script>
jQuery(document).ready(function($) {
    $('.woocommerce-ordering').each(function() {
        var $form = $(this);
        var $trigger = $form.find('#dropdown-trigger');
        var $menu = $form.find('#dropdown-menu');
        var $arrow = $form.find('#dropdown-arrow');
        var $nativeSelect = $form.find('.orderby');
        var $options = $form.find('.sort-option');

        if (!$trigger.length || !$menu.length || !$nativeSelect.length) return;

        $trigger.on('click', function(e) {
            e.stopPropagation();
            var isExpanded = $menu.hasClass('opacity-100');

            $('.woocommerce-ordering').each(function() {
                var $otherMenu = $(this).find('#dropdown-menu');
                var $otherArrow = $(this).find('#dropdown-arrow');
                closeDropdown($otherMenu, $otherArrow);
            });

            if (!isExpanded) {
                openDropdown($menu, $arrow);
            }
        });

        $(document).on('click', function(e) {
            if (!$trigger.is(e.target) && $trigger.has(e.target).length === 0 && 
                !$menu.is(e.target) && $menu.has(e.target).length === 0) {
                closeDropdown($menu, $arrow);
            }
        });

        $options.on('click', function(e) {
            e.preventDefault();
            var value = $(this).data('value');
            $nativeSelect.val(value);
            $form.submit();
        });
    });

    function openDropdown($menuElem, $arrowElem) {
        $menuElem.removeClass('opacity-0 invisible scale-95 pointer-events-none')
                 .addClass('opacity-100 visible scale-100 pointer-events-auto');
        if($arrowElem.length) {
            $arrowElem.addClass('rotate-180');
        }
    }

    function closeDropdown($menuElem, $arrowElem) {
        $menuElem.addClass('opacity-0 invisible scale-95 pointer-events-none')
                 .removeClass('opacity-100 visible scale-100 pointer-events-auto');
        if($arrowElem.length) {
            $arrowElem.removeClass('rotate-180');
        }
    }
});
</script>