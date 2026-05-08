<?php
$defaults = array(
    'url'        => wp_get_referer() ? wp_get_referer() : home_url( '/' ),
    'text'       => __( 'Go Back', 'julias-cartoonery' ),
    'class'      => '',
    'aria_label' => '',
    'show_icon'  => true,
);

$args = wp_parse_args( is_array( $args ?? null ) ? $args : array(), $defaults );

$url        = (string) $args['url'];
$text       = (string) $args['text'];
$class      = trim( (string) $args['class'] );
$aria_label = (string) ( $args['aria_label'] ? $args['aria_label'] : $text );
$show_icon  = (bool) $args['show_icon'];

$base_class = 'group inline-flex items-center gap-2 mb-8 px-5 py-2.5 -ml-5 text-gray-500 dark:text-gray-400 font-bold rounded-full hover:bg-pink-50 dark:hover:bg-slate-800 hover:text-[#FF9CB0] dark:hover:text-pink-400 transition-all duration-300 active:scale-95';
$classes    = $class ? $base_class . ' ' . $class : $base_class;
?>

<a href="<?php echo esc_url( $url ); ?>"
    class="<?php echo esc_attr( $classes ); ?>"
    aria-label="<?php echo esc_attr( $aria_label ); ?>">
    <?php if ( $show_icon ) { ?>
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
            class="transition-transform duration-300 group-hover:-translate-x-1.5" aria-hidden="true" focusable="false">
            <path d="m15 18-6-6 6-6" />
        </svg>
    <?php } ?>
    <?php echo esc_html( $text ); ?>
</a>