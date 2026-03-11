(function () {
  // メニューの開閉制御
  var menuTrigger = document.getElementById("menuTrigger");
  var globalMenu = document.getElementById("globalMenu");
  var menuLinks = document.querySelectorAll(".menu-link");
  var menuToggles = document.querySelectorAll(".menu-toggle");

  if (menuTrigger && globalMenu) {
    menuTrigger.addEventListener("click", function () {
      menuTrigger.classList.toggle("active");
      globalMenu.classList.toggle("active");
    });

    menuLinks.forEach(function (link) {
      link.addEventListener("click", function () {
        menuTrigger.classList.remove("active");
        globalMenu.classList.remove("active");
      });
    });
  }

  // アコーディオンメニューの制御
  menuToggles.forEach(function (toggle) {
    toggle.addEventListener("click", function () {
      if (window.innerWidth >= 769) return;

      this.classList.toggle("open");
      var subMenu = this.parentElement.querySelector(".sub-menu");

      if (subMenu) {
        if (subMenu.classList.contains("is-open")) {
          subMenu.classList.remove("is-open");
          subMenu.style.height = null;
        } else {
          subMenu.classList.add("is-open");
          subMenu.style.height = subMenu.scrollHeight + "px";
        }
      }
    });
  });

  // ウィンドウリサイズ時のリセット処理
  window.addEventListener("resize", function () {
    if (window.innerWidth >= 769) {
      document.querySelectorAll(".sub-menu").forEach(function (el) {
        el.style.height = null;
        el.classList.remove("is-open");
      });
      document.querySelectorAll(".menu-toggle").forEach(function (el) {
        el.classList.remove("open");
      });
      if (menuTrigger && globalMenu) {
        menuTrigger.classList.remove("active");
        globalMenu.classList.remove("active");
      }
    }
  });

  // 検索機能
  var searchTrigger = document.getElementById("searchTrigger");
  var searchOverlay = document.getElementById("searchOverlay");
  var searchClose = document.getElementById("searchClose");
  var searchInput = document.getElementById("searchInput");

  function closeSearch() {
    if (searchOverlay) searchOverlay.classList.remove("active");
    if (searchInput) searchInput.value = "";
  }

  if (searchTrigger && searchOverlay) {
    searchTrigger.addEventListener("click", function () {
      searchOverlay.classList.add("active");
      if (searchInput)
        setTimeout(function () {
          searchInput.focus();
        }, 100);
    });
  }

  if (searchClose && searchOverlay && searchInput) {
    searchClose.addEventListener("click", closeSearch);
  }

  document.addEventListener("keydown", function (e) {
    if (
      e.key === "Escape" &&
      searchOverlay &&
      searchOverlay.classList.contains("active")
    ) {
      closeSearch();
    }
  });

  if (searchOverlay && searchInput) {
    searchOverlay.addEventListener("click", function (e) {
      if (e.target === searchOverlay) closeSearch();
    });
  }

  // スクロールフェードイン
  var fadeTargets = document.querySelectorAll(".fade-in");
  if (fadeTargets.length > 0 && "IntersectionObserver" in window) {
    var observer = new IntersectionObserver(
      function (entries) {
        entries.forEach(function (entry) {
          if (entry.isIntersecting) {
            entry.target.classList.add("is-visible");
            observer.unobserve(entry.target);
          }
        });
      },
      { threshold: 0.15 }
    );
    fadeTargets.forEach(function (el) {
      observer.observe(el);
    });
  } else {
    // IntersectionObserver非対応ブラウザでは全て表示
    fadeTargets.forEach(function (el) {
      el.classList.add("is-visible");
    });
  }
})();
