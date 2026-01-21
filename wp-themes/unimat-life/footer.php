<footer>
    <div class="footer-container">
        <div class="footer-col">
            <h3>COMPANY</h3>
            <?php
            wp_nav_menu(array(
                'theme_location' => 'footer',
                'container'      => false,
                'menu_class'     => '',
                'fallback_cb'    => false,
            ));
            ?>
            <?php if (!has_nav_menu('footer')) : ?>
            <ul>
                <li><a href="<?php echo esc_url(home_url('/company')); ?>">企業理念</a></li>
                <li><a href="<?php echo esc_url(home_url('/company/message')); ?>">代表メッセージ</a></li>
                <li><a href="<?php echo esc_url(home_url('/company/strength')); ?>">私たちの強み</a></li>
                <li><a href="<?php echo esc_url(home_url('/company/sdgs')); ?>">SDGsへの取り組み</a></li>
                <li><a href="<?php echo esc_url(home_url('/company/overview')); ?>">会社概要</a></li>
                <li><a href="<?php echo esc_url(home_url('/company/officers')); ?>">役員一覧</a></li>
                <li><a href="<?php echo esc_url(home_url('/company/history')); ?>">沿革</a></li>
                <li><a href="<?php echo esc_url(home_url('/company/organization')); ?>">組織図</a></li>
                <li><a href="<?php echo esc_url(home_url('/company/notice')); ?>">電子公告</a></li>
                <li><a href="<?php echo esc_url(home_url('/recruit')); ?>">採用情報</a></li>
            </ul>
            <?php endif; ?>
        </div>
        <div class="footer-col">
            <h3>SERVICE</h3>
            <ul>
                <li><a href="https://www.unimat-life.co.jp/ocs/">オフィスコーヒーサービス</a></li>
                <li><a href="https://www.unimat-life.co.jp/rs/">環境美化用品レンタル</a></li>
                <li><a href="https://unimat-totele.jp/">オフィス事務機器</a></li>
                <li><a href="https://unimat-renovation.jp/">リノベーション事業</a></li>
                <li><a href="https://www.unimat-life.co.jp/drugstore/">調剤薬局事業</a></li>
                <li><a href="https://www.unimat-life.co.jp/linen/">リネンサプライ事業</a></li>
                <li><a href="https://www.unimat-life.co.jp/rs/cleaning/">クリーンメンテナンス事業</a></li>
                <li><a href="https://www.unimat-caravan.co.jp/">コーヒー・カフェ・パティスリー事業</a></li>
                <li><a href="<?php echo esc_url(home_url('/service/offices')); ?>">事業所一覧</a></li>
            </ul>
        </div>
        <div class="footer-col">
            <h3>NEWS</h3>
            <ul>
                <li><a href="<?php echo esc_url(home_url('/news')); ?>">すべて</a></li>
                <li><a href="<?php echo esc_url(home_url('/news?cat=item')); ?>">商品情報</a></li>
                <li><a href="<?php echo esc_url(home_url('/news?cat=company')); ?>">企業情報</a></li>
                <li><a href="<?php echo esc_url(home_url('/news?cat=recruit')); ?>">採用情報</a></li>
                <li><a href="<?php echo esc_url(home_url('/news?cat=other')); ?>">その他</a></li>
            </ul>
        </div>
        <div class="footer-col">
            <h3>CONTACT</h3>
            <ul>
                <li><a href="<?php echo esc_url(home_url('/contact')); ?>">ご意見・ご要望</a></li>
                <li><a href="<?php echo esc_url(home_url('/contact/ocs')); ?>">オフィスコーヒーサービス【資料請求・見積依頼】</a></li>
                <li><a href="<?php echo esc_url(home_url('/contact/rs')); ?>">環境美化用品レンタルサービス【資料請求・見積依頼】</a></li>
                <li><a href="<?php echo esc_url(home_url('/contact/pharmacy')); ?>">調剤薬局事業に関するお問い合わせ</a></li>
                <li><a href="<?php echo esc_url(home_url('/contact/linen')); ?>">リネンサプライ事業【資料請求・見積依頼】</a></li>
                <li><a href="<?php echo esc_url(home_url('/contact/recruit')); ?>">採用担当者へお問い合わせ</a></li>
            </ul>
        </div>
    </div>
    <p class="copyright">&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. All Rights Reserved.</p>
</footer>

<?php wp_footer(); ?>
</body>
</html>
