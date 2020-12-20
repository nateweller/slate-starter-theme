<?php
/**
 * List Navigation Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

use Timber\Timber;
use Timber\Menu;

$menu_slug = get_field( 'menu_slug' );
if ( ! $menu_slug ) return;

$menu = new Menu( $menu_slug, array( 'depth' => 2 ) );

Timber::render( 'views/components/list-navigation', array( 'menu' => $menu ) );