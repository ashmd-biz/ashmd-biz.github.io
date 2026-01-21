<?php
/**
 * UNIMAT LIFE Theme Functions
 *
 * @package UNIMAT_LIFE
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * テーマのセットアップ
 */
function unimat_life_setup() {
    // テーマの翻訳サポート
    load_theme_textdomain('unimat-life', get_template_directory() . '/languages');

    // タイトルタグの自動生成
    add_theme_support('title-tag');

    // アイキャッチ画像のサポート
    add_theme_support('post-thumbnails');

    // HTML5マークアップのサポート
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));

    // カスタムロゴのサポート
    add_theme_support('custom-logo', array(
        'height'      => 44,
        'width'       => 200,
        'flex-height' => true,
        'flex-width'  => true,
    ));
}
add_action('after_setup_theme', 'unimat_life_setup');

/**
 * スタイルシートとスクリプトの読み込み
 */
function unimat_life_scripts() {
    // スタイルシート
    wp_enqueue_style('unimat-life-style', get_stylesheet_uri(), array(), '1.0.0');
    
    // JavaScript
    wp_enqueue_script('unimat-life-script', get_template_directory_uri() . '/assets/js/main.js', array(), '1.0.0', true);
}
add_action('wp_enqueue_scripts', 'unimat_life_scripts');

/**
 * メニューの登録
 */
function unimat_life_menus() {
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'unimat-life'),
        'footer'  => __('Footer Menu', 'unimat-life'),
    ));
}
add_action('init', 'unimat_life_menus');

/**
 * ウィジェットエリアの登録
 */
function unimat_life_widgets_init() {
    register_sidebar(array(
        'name'          => __('Sidebar', 'unimat-life'),
        'id'            => 'sidebar-1',
        'description'   => __('Add widgets here.', 'unimat-life'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ));
}
add_action('widgets_init', 'unimat_life_widgets_init');

/**
 * 検索フォームのカスタマイズ
 */
function unimat_life_search_form($form) {
    $form = '<form role="search" method="get" class="search-form" action="' . esc_url(home_url('/')) . '">
        <input type="search" class="search-field" placeholder="' . esc_attr__('Search...', 'unimat-life') . '" value="' . get_search_query() . '" name="s" />
        <button type="submit" class="search-submit">' . esc_html__('Search', 'unimat-life') . '</button>
    </form>';
    return $form;
}
add_filter('get_search_form', 'unimat_life_search_form');

/**
 * 抜粋の長さを変更
 */
function unimat_life_excerpt_length($length) {
    return 40;
}
add_filter('excerpt_length', 'unimat_life_excerpt_length');

/**
 * 抜粋の末尾テキストを変更
 */
function unimat_life_excerpt_more($more) {
    return '...';
}
add_filter('excerpt_more', 'unimat_life_excerpt_more');

/**
 * カスタムメニューウォーカー
 */
class Unimat_Life_Walker_Nav_Menu extends Walker_Nav_Menu {
    
    function start_lvl(&$output, $depth = 0, $args = null) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul class=\"sub-menu\">\n";
        $output .= "$indent\t<div class=\"sub-menu-inner container\">\n";
    }
    
    function end_lvl(&$output, $depth = 0, $args = null) {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent\t</div>\n";
        $output .= "$indent</ul>\n";
    }
    
    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $indent = ($depth) ? str_repeat("\t", $depth) : '';
        
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;
        
        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
        $class_names = $class_names ? ' class="menu-item ' . esc_attr($class_names) . '"' : ' class="menu-item"';
        
        $id = apply_filters('nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args);
        $id = $id ? ' id="' . esc_attr($id) . '"' : '';
        
        $output .= $indent . '<li' . $id . $class_names .'>';
        
        $attributes = ! empty($item->attr_title) ? ' title="'  . esc_attr($item->attr_title) .'"' : '';
        $attributes .= ! empty($item->target)     ? ' target="' . esc_attr($item->target     ) .'"' : '';
        $attributes .= ! empty($item->xfn)        ? ' rel="'    . esc_attr($item->xfn        ) .'"' : '';
        $attributes .= ! empty($item->url)        ? ' href="'   . esc_attr($item->url        ) .'"' : '';
        
        // サブメニューがある場合はmenu-toggle、ない場合はmenu-link
        $has_children = in_array('menu-item-has-children', $classes);
        $link_class = $has_children ? 'menu-toggle' : 'menu-link';
        
        $item_output = isset($args->before) ? $args->before : '';
        $item_output .= '<' . ($has_children ? 'div' : 'a') . ' class="' . $link_class . '"' . ($has_children ? '' : $attributes) . '>';
        $item_output .= (isset($args->link_before) ? $args->link_before : '') . apply_filters('the_title', $item->title, $item->ID) . (isset($args->link_after) ? $args->link_after : '');
        
        // サブテキスト（説明文）を追加
        if (!empty($item->description)) {
            $item_output .= '<span class="sub-text">' . esc_html($item->description) . '</span>';
        }
        
        $item_output .= '</' . ($has_children ? 'div' : 'a') . '>';
        $item_output .= isset($args->after) ? $args->after : '';
        
        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }
    
    function end_el(&$output, $item, $depth = 0, $args = null) {
        $output .= "</li>\n";
    }
}
