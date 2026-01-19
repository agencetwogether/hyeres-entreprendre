import './bootstrap';
import './theme-switcher.js';
import './cookie.js';
import 'share-buttons';
import Swiper from 'swiper';
import { Navigation, EffectFade, Autoplay } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/effect-fade';

document.addEventListener('DOMContentLoaded', function () {
  // AOS Animation
  if (window['AOS']) {
    window['AOS'].init({
      once: true,
    });
  }

  // Scroll to top
  const scrollToTop = () => {
    document.documentElement.scrollTo({
      top: 0,
      behavior: 'smooth',
    });
  };

  window.onscroll = function () {
    setOnScroll();
  };

  const setOnScroll = () => {
    let scrollpos = window.scrollY;
    if (scrollpos > 0) {
      document.getElementById('scrollToTopBtn')?.classList.remove('hidden');
      document.getElementById('top-header')?.classList.add('sticky-header');
    } else {
      document.getElementById('scrollToTopBtn')?.classList.add('hidden');
      document.getElementById('top-header')?.classList.remove('sticky-header');
    }
  };
  setOnScroll();

  // Blog Slider
  const swiper = new Swiper('.blog-slider', {
    modules: [Navigation, EffectFade, Autoplay],
    effect: 'fade',
    loop: true,
    slidesPerView: 'auto',
    autoplay: {
      delay: 6000,
      disableOnInteraction: false,
    },
    navigation: {
      nextEl: '.blog-slider-button-next',
      prevEl: '.blog-slider-button-prev',
    },
  });
});
