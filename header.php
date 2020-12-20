<?php 
/**
 * Header Template
 * 
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package _slate
 */

use Timber\Timber;
use Timber\Image;
use Timber\Menu;

$context = Timber::context();
$logo_ID = get_theme_mod( 'custom_logo' );
if ( $logo_ID ) {
    $context['logo'] = new Image( $logo_ID );
}
$context['menu'] = new Menu( 'primary_menu', array( 'depth' => 2 ) );

Timber::render( 'views/templates/header.twig', $context );