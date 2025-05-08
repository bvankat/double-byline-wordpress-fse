<?php
/**
 * Plugin Name:       Hanscomparkstudio Double Byline
 * Description:       A dynamic block showing one or two post authors.
 * Requires at least: 6.0
 * Requires PHP:      7.0
 * Version:           0.1.0
 * Author:            Your Name
 * License:           GPL-2.0+
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       hanscomparkstudio-double-byline
 *
 * @package           hanscomparkstudio-double-byline
 */

function hanscomparkstudio_double_byline_register_block() {
    register_block_type( __DIR__ . '/build', [
        'render_callback' => 'hanscomparkstudio_double_byline_render_callback',
    ] );
}
add_action( 'init', 'hanscomparkstudio_double_byline_register_block' );

function hanscomparkstudio_double_byline_render_callback( $attributes, $content, $block ) {
    $post_id = get_the_ID();

    $primary_author_id = get_post_field('post_author', $post_id);
    $primary_author = get_userdata($primary_author_id);
    $primary_author_link = get_author_posts_url($primary_author_id);
    $primary_name = $primary_author->display_name;

    $secondary_author = get_field('secondary_author', $post_id); // ACF user field (user ID)

    if ($secondary_author) {
        $secondary_user = get_userdata($secondary_author);
        $secondary_author_link = get_author_posts_url($secondary_author);
        $secondary_name = $secondary_user->display_name;

        $output = sprintf(
            '<span class="double-byline"><a href="%s">%s</a> and <a href="%s">%s</a></span>',
            esc_url($primary_author_link),
            esc_html($primary_name),
            esc_url($secondary_author_link),
            esc_html($secondary_name)
        );
    } else {
        $output = sprintf(
            '<span class="double-byline"><a href="%s">%s</a></span>',
            esc_url($primary_author_link),
            esc_html($primary_name)
        );
    }

    return $output;
}
