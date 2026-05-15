<?php
/**
 * The template for displaying a Single Story
 */

$story_reader_mode = isset( $_GET['story_reader'] ) ? wp_unslash( $_GET['story_reader'] ) : '';

if ( '1' === $story_reader_mode ) {
    while ( have_posts() ) :
        the_post();
        global $page, $numpages;
        $current_page = $page ? $page : 1;
        $total_pages  = $numpages ? $numpages : 1;
        $has_cover    = 1 === $current_page && has_post_thumbnail();
        get_template_part(
            'template-parts/story-reader',
            null,
            array(
                'current_page' => $current_page,
                'total_pages'  => $total_pages,
                'has_cover'    => $has_cover,
            )
        );
    endwhile;
    exit;
}

get_header();

// Helper function to get exact URL for pagination
function get_story_page_url($i)
{
    global $post;
    if (1 == $i)
        return get_permalink();
    if ('' == get_option('permalink_structure') || in_array($post->post_status, array('draft', 'pending')))
        return add_query_arg('page', $i, get_permalink());
    return trailingslashit(get_permalink()) . user_trailingslashit($i, 'single_paged');
}
?>

<main class="story-reader-shell min-h-[80vh] py-8 md:py-12 transition-colors">
    <div class="container mx-auto px-4 lg:px-8 relative z-10">

        <!-- Back to Library Link -->
        <?php
        get_template_part('template-parts/components/button', 'back', array(
            'url' => get_post_type_archive_link('stories'),
            'text' => 'Back to Library'
        ));
        ?>

        <?php while (have_posts()):
            the_post();
            global $page, $numpages;
            $current_page = $page ? $page : 1;
            $total_pages = $numpages ? $numpages : 1;
            $has_cover = 1 === $current_page && has_post_thumbnail();
            ?>
            <?php
            get_template_part(
                'template-parts/story-reader',
                null,
                array(
                    'current_page' => $current_page,
                    'total_pages'  => $total_pages,
                    'has_cover'    => $has_cover,
                )
            );
            ?>
        <?php endwhile; ?>

    </div>
</main>

<?php get_footer(); ?>