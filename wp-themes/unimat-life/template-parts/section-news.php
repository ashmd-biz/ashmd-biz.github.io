<?php
/**
 * News セクション
 *
 * @package UNIMAT_LIFE
 */
?>

<section class="news">
    <div class="container">
        <div class="news-header">
            <h2>NEWS & TOPICS</h2>
            <span>お知らせ</span>
        </div>
        <ul class="news-list">
            <?php
            $news_query = new WP_Query(array(
                'post_type'      => 'post',
                'posts_per_page' => 3,
                'post_status'    => 'publish',
            ));

            if ($news_query->have_posts()) :
                while ($news_query->have_posts()) : $news_query->the_post();
            ?>
                <li>
                    <a href="<?php the_permalink(); ?>" style="display: flex; gap: 30px; text-decoration: none; color: inherit;">
                        <span class="date"><?php echo get_the_date('Y.m.d'); ?></span>
                        <span class="title"><?php the_title(); ?></span>
                    </a>
                </li>
            <?php
                endwhile;
                wp_reset_postdata();
            else :
            ?>
                <li><span class="date">2025.10.01</span><span class="title">新商品「プレミアムブレンド」の取り扱いを開始しました</span></li>
                <li><span class="date">2025.09.15</span><span class="title">採用情報を更新しました（2026年度新卒採用）</span></li>
                <li><span class="date">2025.08.01</span><span class="title">夏季休業期間のお知らせ</span></li>
            <?php endif; ?>
        </ul>
        <div style="text-align:center; margin-top:40px;">
            <a href="<?php echo esc_url(home_url('/news')); ?>" class="btn" style="border-color:#ccc; color:#666;">一覧を見る</a>
        </div>
    </div>
</section>
