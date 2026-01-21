<?php
/**
 * Service Item テンプレート
 *
 * @package UNIMAT_LIFE
 * 
 * @var array $args {
 *     @type string $num        サービス番号
 *     @type string $en_title   英語タイトル
 *     @type string $title      日本語タイトル
 *     @type string $desc       説明文
 *     @type string $url        リンクURL
 *     @type string $image      画像プレースホルダー
 * }
 */

$args = wp_parse_args($args, array(
    'num' => '',
    'en_title' => '',
    'title' => '',
    'desc' => '',
    'url' => '#',
    'image' => 'IMAGE'
));
?>

<div class="service-item">
    <div class="service-img"><?php echo esc_html($args['image']); ?></div>
    <div class="service-text">
        <span class="service-num"><?php echo esc_html($args['num']); ?>. <?php echo esc_html($args['en_title']); ?></span>
        <h2 class="service-title"><?php echo esc_html($args['title']); ?></h2>
        <p class="service-desc">
            <?php echo wp_kses_post($args['desc']); ?>
        </p>
        <a href="<?php echo esc_url($args['url']); ?>" class="btn">詳しく見る</a>
    </div>
</div>
