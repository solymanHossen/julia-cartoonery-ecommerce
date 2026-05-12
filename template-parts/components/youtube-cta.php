<?php
/**
 * YouTube CTA button component
 * Uses theme mod 'julias_youtube_channel' for the channel URL (fallback to youtube.com)
 */
$youtube_url = get_theme_mod( 'julias_youtube_channel', 'https://www.youtube.com/' );
?>
<a href="<?php echo esc_url( $youtube_url ); ?>" target="_blank" rel="noopener noreferrer" aria-label="Visit Julia's YouTube channel" class="julias-youtube-cta">
    <span class="sr-only">Visit Julia's YouTube channel</span>
    <div class="flex items-center gap-3 px-3 py-2 bg-red-600 hover:bg-red-700 dark:bg-red-500 dark:hover:bg-red-600 text-white rounded-full shadow-lg transform transition-transform duration-200 hover:-translate-y-0.5 hover:scale-105">
        <svg class="w-5 h-5 flex-shrink-0" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <path d="M23.498 6.186a2.99 2.99 0 0 0-2.104-2.112C19.87 3.5 12 3.5 12 3.5s-7.87 0-9.394.574A2.99 2.99 0 0 0 .502 6.186 31.97 31.97 0 0 0 0 12a31.97 31.97 0 0 0 .502 5.814 2.99 2.99 0 0 0 2.104 2.112C4.13 20.5 12 20.5 12 20.5s7.87 0 9.394-.574a2.99 2.99 0 0 0 2.104-2.112A31.97 31.97 0 0 0 24 12a31.97 31.97 0 0 0-.502-5.814zM9.75 15.02V8.98L15.5 12l-5.75 3.02z"></path>
        </svg>
        <span class="font-semibold text-sm hidden sm:inline">Julia on YouTube</span>
    </div>
</a>
