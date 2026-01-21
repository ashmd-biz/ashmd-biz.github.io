<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header>
    <div class="logo">
        <a href="<?php echo esc_url(home_url('/')); ?>">
            <?php
            $custom_logo_id = get_theme_mod('custom_logo');
            if ($custom_logo_id) {
                $logo = wp_get_attachment_image_src($custom_logo_id, 'full');
                if ($logo) {
                    echo '<img src="' . esc_url($logo[0]) . '" alt="' . esc_attr(get_bloginfo('name')) . ' Symbol">';
                }
            } else {
                // デフォルトロゴ画像
                echo '<img src="' . esc_url(get_template_directory_uri() . '/assets/images/logo.png') . '" alt="' . esc_attr(get_bloginfo('name')) . ' Symbol">';
            }
            ?>
            <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/logo_type.png'); ?>" alt="<?php bloginfo('name'); ?>" style="height: 22px; margin-top: 4px;">
        </a>
    </div>
    
    <nav class="global-menu" id="globalMenu">
        <div class="menu-container">
            <?php
            wp_nav_menu(array(
                'theme_location' => 'primary',
                'container'      => false,
                'items_wrap'     => '<ul>%3$s</ul>',
                'fallback_cb'    => 'unimat_life_default_menu',
                'walker'         => new Unimat_Life_Walker_Nav_Menu(),
            ));
            ?>
        </div>
    </nav>

    <div class="header-actions">
        <div class="menu-trigger" id="menuTrigger">
            <span></span>
            <span></span>
            <span></span>
        </div>
        <div class="search-trigger" id="searchTrigger">
            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M9 17C13.4183 17 17 13.4183 17 9C17 4.58172 13.4183 1 9 1C4.58172 1 1 4.58172 1 9C1 13.4183 4.58172 17 9 17Z" stroke="#333" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M19 19L14.65 14.65" stroke="#333" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </div>
    </div>
</header>

<!-- 検索入力枠 -->
<div class="search-overlay" id="searchOverlay">
    <div class="search-container">
        <form class="search-form" action="<?php echo esc_url(home_url('/')); ?>" method="get">
            <input type="text" name="s" class="search-input" id="searchInput" placeholder="検索キーワードを入力してください" autocomplete="off" required value="<?php echo get_search_query(); ?>">
            <button type="submit" class="search-submit">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M11 19C15.4183 19 19 15.4183 19 11C19 6.58172 15.4183 3 11 3C6.58172 3 3 6.58172 3 11C3 15.4183 6.58172 19 11 19Z" stroke="#333" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M21 21L16.65 16.65" stroke="#333" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
            <button type="button" class="search-close" id="searchClose">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M18 6L6 18M6 6L18 18" stroke="#333" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
        </form>
    </div>
</div>

<?php
/**
 * デフォルトメニュー（メニューが設定されていない場合）
 */
function unimat_life_default_menu() {
    echo '<ul>';
    echo '<li class="menu-item"><a href="' . esc_url(home_url('/')) . '" class="menu-link">TOP<span class="sub-text">トップ</span></a></li>';
    echo '<li class="menu-item"><a href="' . esc_url(home_url('/company')) . '" class="menu-link">COMPANY<span class="sub-text">企業情報</span></a></li>';
    echo '<li class="menu-item"><a href="' . esc_url(home_url('/service')) . '" class="menu-link">SERVICE<span class="sub-text">事業内容</span></a></li>';
    echo '<li class="menu-item"><a href="' . esc_url(home_url('/news')) . '" class="menu-link">NEWS<span class="sub-text">お知らせ</span></a></li>';
    echo '<li class="menu-item"><a href="' . esc_url(home_url('/recruit')) . '" class="menu-link">RECRUIT<span class="sub-text">採用情報</span></a></li>';
    echo '<li class="menu-item"><a href="' . esc_url(home_url('/contact')) . '" class="menu-link">CONTACT<span class="sub-text">お問い合わせ</span></a></li>';
    echo '</ul>';
}
?>
