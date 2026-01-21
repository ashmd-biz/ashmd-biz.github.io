// メニューの開閉制御
const menuTrigger = document.getElementById('menuTrigger');
const globalMenu = document.getElementById('globalMenu');
const menuLinks = document.querySelectorAll('.menu-link');
const menuToggles = document.querySelectorAll('.menu-toggle');

if (menuTrigger && globalMenu) {
    // ハンバーガーメニューのクリック
    menuTrigger.addEventListener('click', () => {
        menuTrigger.classList.toggle('active');
        globalMenu.classList.toggle('active');
    });

    // 通常リンクをクリックしたらメニューを閉じる
    menuLinks.forEach(link => {
        link.addEventListener('click', () => {
            menuTrigger.classList.remove('active');
            globalMenu.classList.remove('active');
        });
    });

    // アコーディオンメニューの制御
    menuToggles.forEach(toggle => {
        toggle.addEventListener('click', function() {
            // PCサイズ（769px以上）ではアコーディオン動作を無効化（メガメニューはホバーで表示）
            if (window.innerWidth >= 769) return;

            this.classList.toggle('open');
            const subMenu = this.nextElementSibling;
            
            if (subMenu && subMenu.classList.contains('is-open')) {
                subMenu.classList.remove('is-open');
                subMenu.style.height = null;
            } else if (subMenu) {
                subMenu.classList.add('is-open');
                // スマホ用に高さを計算
                subMenu.style.height = subMenu.scrollHeight + "px";
            }
        });
    });

    // ウィンドウリサイズ時のリセット処理
    window.addEventListener('resize', () => {
        if (window.innerWidth >= 769) {
            // PCサイズになったらスマホ用スタイルをリセット
            document.querySelectorAll('.sub-menu').forEach(el => {
                el.style.height = null;
                el.classList.remove('is-open');
            });
            document.querySelectorAll('.menu-toggle').forEach(el => {
                el.classList.remove('open');
            });
            // メニューが開いていたら閉じる
            menuTrigger.classList.remove('active');
            globalMenu.classList.remove('active');
        }
    });
}

// 検索機能
const searchTrigger = document.getElementById('searchTrigger');
const searchOverlay = document.getElementById('searchOverlay');
const searchClose = document.getElementById('searchClose');
const searchInput = document.getElementById('searchInput');

if (searchTrigger && searchOverlay) {
    // 検索アイコンクリックで検索入力枠を表示
    searchTrigger.addEventListener('click', () => {
        searchOverlay.classList.add('active');
        // フォーカスを検索入力に移動
        setTimeout(() => {
            if (searchInput) {
                searchInput.focus();
            }
        }, 100);
    });

    // 閉じるボタンで検索入力枠を非表示
    if (searchClose) {
        searchClose.addEventListener('click', () => {
            searchOverlay.classList.remove('active');
            if (searchInput) {
                searchInput.value = '';
            }
        });
    }

    // ESCキーで検索入力枠を閉じる
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && searchOverlay.classList.contains('active')) {
            searchOverlay.classList.remove('active');
            if (searchInput) {
                searchInput.value = '';
            }
        }
    });

    // 検索オーバーレイの背景クリックで閉じる
    searchOverlay.addEventListener('click', (e) => {
        if (e.target === searchOverlay) {
            searchOverlay.classList.remove('active');
            if (searchInput) {
                searchInput.value = '';
            }
        }
    });
}
