(function () {
  // 汎用スライダー
  function createSlider(config) {
    var index = config.initialIndex || 0;
    var total = config.totalSlides;
    var autoTimer = null;

    function goTo(newIndex) {
      index = newIndex;
      config.onUpdate(index);
    }

    function goNext() {
      if (config.onNext) {
        index = config.onNext(index, total);
      } else {
        index = (index + 1) % total;
      }
      config.onUpdate(index);
    }

    function goPrev() {
      if (config.onPrev) {
        index = config.onPrev(index, total);
      } else {
        index = (index - 1 + total) % total;
      }
      config.onUpdate(index);
    }

    function startAuto() {
      stopAuto();
      if (config.autoInterval) {
        autoTimer = setInterval(goNext, config.autoInterval);
      }
    }

    function stopAuto() {
      if (autoTimer) clearInterval(autoTimer);
      autoTimer = null;
    }

    function restartAuto() {
      stopAuto();
      startAuto();
    }

    if (config.prevBtn) {
      config.prevBtn.addEventListener("click", function (e) {
        if (config.preventDefault) {
          e.preventDefault();
          e.stopPropagation();
        }
        goPrev();
        restartAuto();
      });
    }
    if (config.nextBtn) {
      config.nextBtn.addEventListener("click", function (e) {
        if (config.preventDefault) {
          e.preventDefault();
          e.stopPropagation();
        }
        goNext();
        restartAuto();
      });
    }

    if (config.indicators) {
      config.indicators.forEach(function (indicator, i) {
        indicator.addEventListener("click", function () {
          goTo(i);
          restartAuto();
        });
      });
    }

    if (config.swipeEl) {
      var touchStartX = 0;
      var touchStartY = 0;
      var isSwiping = false;
      var SWIPE_THRESHOLD = 50;

      config.swipeEl.addEventListener("touchstart", function (e) {
        touchStartX = e.touches[0].clientX;
        touchStartY = e.touches[0].clientY;
        isSwiping = true;
        stopAuto();
      }, { passive: true });

      config.swipeEl.addEventListener("touchmove", function (e) {
        if (!isSwiping) return;
        var dx = Math.abs(e.touches[0].clientX - touchStartX);
        var dy = Math.abs(e.touches[0].clientY - touchStartY);
        if (dx > dy && dx > 10) {
          e.preventDefault();
        }
      }, { passive: false });

      config.swipeEl.addEventListener("touchend", function (e) {
        if (!isSwiping) return;
        isSwiping = false;
        var dx = e.changedTouches[0].clientX - touchStartX;
        if (dx < -SWIPE_THRESHOLD) {
          goNext();
        } else if (dx > SWIPE_THRESHOLD) {
          goPrev();
        }
        restartAuto();
      }, { passive: true });
    }

    if (config.hoverEl) {
      config.hoverEl.addEventListener("mouseenter", function () {
        stopAuto();
      });
      config.hoverEl.addEventListener("mouseleave", function () {
        startAuto();
      });
    }

    if (config.onResize) {
      window.addEventListener("resize", function () {
        config.onResize(index);
      });
    }

    startAuto();

    return {
      goTo: goTo,
      goNext: goNext,
      goPrev: goPrev,
      startAuto: startAuto,
      stopAuto: stopAuto,
      getIndex: function () {
        return index;
      },
    };
  }

  // ヒーロースライダー
  function initHeroSlider() {
    var slides = document.querySelectorAll(".hero-slide");
    var indicators = document.querySelectorAll(".hero-indicator");
    if (slides.length === 0) return;

    createSlider({
      totalSlides: slides.length,
      initialIndex: 0,
      autoInterval: 3000,
      prevBtn: document.querySelector(".hero-prev"),
      nextBtn: document.querySelector(".hero-next"),
      swipeEl: document.querySelector(".hero-slider"),
      hoverEl: document.querySelector(".hero-slider"),
      indicators: Array.from(indicators),
      onUpdate: function (index) {
        slides.forEach(function (s) {
          s.classList.remove("active");
        });
        indicators.forEach(function (s) {
          s.classList.remove("active");
        });
        if (slides[index]) slides[index].classList.add("active");
        if (indicators[index]) indicators[index].classList.add("active");
      },
    });
  }

  // キャンペーンスライダー（巻物のように動く + 自動再生）
  function initCampaignSlider() {
    var viewport = document.querySelector(".campaign-slider-viewport");
    var track = document.querySelector(".campaign-slider-track");
    if (!viewport || !track) return;
    var slides = track.querySelectorAll(".campaign-slide");
    if (!slides || slides.length < 3) return;

    var GAP = window.innerWidth <= 768 ? 24 : 80;
    track.insertBefore(
      slides[slides.length - 1].cloneNode(true),
      track.firstChild,
    );
    track.appendChild(slides[0].cloneNode(true));
    slides = track.querySelectorAll(".campaign-slide");
    var totalSlides = slides.length;
    var captionEl = document.querySelector(".campaign-slider-caption p");

    function updateView(index, noTransition) {
      if (noTransition) track.style.transition = "none";
      for (var i = 0; i < totalSlides; i++) {
        slides[i].classList.toggle("active", i === index);
        var imgEl = slides[i].querySelector(".campaign-slide-img");
        if (imgEl) {
          if (i === index) {
            imgEl.style.backgroundPosition = "center";
          } else if (i < index) {
            imgEl.style.backgroundPosition = "right center";
          } else {
            imgEl.style.backgroundPosition = "left center";
          }
        }
      }
      track.offsetHeight;
      var vw = viewport.clientWidth;
      var isSP = window.innerWidth <= 768;
      var ACTIVE_W = isSP ? 320 : 800;
      var INACTIVE_W = isSP ? 120 : Math.max(360, (vw - ACTIVE_W - GAP * 2) / 2);
      var offset = 0;
      for (var j = 0; j < index; j++) {
        offset += (j === index ? ACTIVE_W : INACTIVE_W) + GAP;
      }
      var padLeft = Math.max(0, (vw - ACTIVE_W) / 2);
      track.style.paddingLeft = padLeft + "px";
      track.style.transform = "translate3d(" + -offset + "px, 0, 0)";
      var totalW = padLeft;
      for (var k = 0; k < totalSlides; k++) {
        totalW += (k === index ? ACTIVE_W : INACTIVE_W) + (k < totalSlides - 1 ? GAP : 0);
      }
      track.style.minWidth = totalW + "px";
      if (noTransition) {
        track.offsetHeight;
        track.style.transition = "";
      }
      if (captionEl) {
        var caption = slides[index]
          ? slides[index].getAttribute("data-caption")
          : "";
        if (caption) captionEl.innerHTML = caption;
      }
    }

    var slider = createSlider({
      totalSlides: totalSlides,
      initialIndex: 2,
      autoInterval: 3000,
      prevBtn: document.querySelector(".campaign-slider-prev"),
      nextBtn: document.querySelector(".campaign-slider-next"),
      swipeEl: viewport,
      hoverEl: viewport,
      preventDefault: true,
      onNext: function (index, total) {
        var next = index + 1;
        if (next >= total) next = total - 1;
        if (next === total - 1) {
          setTimeout(function () {
            slider.goTo(1);
            updateView(1, true);
          }, 420);
        }
        return next;
      },
      onPrev: function (index, total) {
        var prev = index - 1;
        if (prev < 0) prev = 0;
        if (prev === 0) {
          setTimeout(function () {
            slider.goTo(total - 2);
            updateView(total - 2, true);
          }, 420);
        }
        return prev;
      },
      onUpdate: function (index) {
        updateView(index, false);
      },
      onResize: function (index) {
        GAP = window.innerWidth <= 768 ? 24 : 80;
        updateView(index, false);
      },
    });

    updateView(2, false);
  }

  // DOMContentLoaded で初期化
  document.addEventListener("DOMContentLoaded", function () {
    initHeroSlider();
    initCampaignSlider();
  });
})();
