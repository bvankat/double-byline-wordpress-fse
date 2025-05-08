<?php
/*
Plugin Name: Double Byline Block
Description: A dynamic block to display one or two post authors with archive links.
Version: 0.1
Author: Hanscom Park Studio
*/

if (!defined('ABSPATH')) {
	exit;
}

add_action('init', function() {
	register_block_type(__DIR__ . '/block', [
		'render_callback' => function($attributes, $content, $block) {
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
	]);
});
