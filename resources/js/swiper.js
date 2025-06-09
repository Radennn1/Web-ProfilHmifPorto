import Swiper from 'swiper';
import { Navigation, Pagination, EffectCoverflow, Autoplay } from 'swiper/modules';

import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';
import 'swiper/css/effect-coverflow';

document.addEventListener('DOMContentLoaded', function () {

  // Swiper Galeri (yang sudah ada)
  const swiperGaleri = new Swiper('.swiper-galeri', {
      modules: [Navigation, Pagination, EffectCoverflow, Autoplay],
      loop: true,
      centeredSlides: true,
      slidesPerView: 2,
      spaceBetween: -100,
      speed: 2000,
      grabCursor: true,
      effect: 'coverflow',
      coverflowEffect: {
          rotate: 0,
          stretch: 0,
          depth: 200,
          modifier: 2,
          slideShadows: true,
      },
      pagination: {
          el: '.swiper-galeri .swiper-pagination',
          clickable: true,
      },
      watchSlidesProgress: true,
      autoplay: {
          delay: 3000, // <= Tambahkan ini untuk auto-slide 5 detik
          disableOnInteraction: false, // agar tetap autoplay walau user swipe manual
      },
      breakpoints: {
          640: {
              slidesPerView: 1, // untuk hp
              spaceBetween: -150,
          },
          1024: {
              slidesPerView: 2,
              spaceBetween: -100,
          }
      }
  });

  // Swiper Artikel (yang sudah ada)
  const swiperArtikel = new Swiper(".artikel-carousel", {
      modules: [Autoplay],
      slidesPerView: 1, 
      spaceBetween: 20,
      loop: true,
      speed: 3000,
      direction: 'horizontal',
      autoplay: {
          delay: 0, // Tidak ada jeda antar autoplay
      },
      breakpoints: {
          640: {
              slidesPerView: 3,
          },
          1024: {
              slidesPerView: 5,
          },
          1280: {
              slidesPerView: 5,
          },
          1600: {
              slidesPerView: 5,
          },
          1920: {
              slidesPerView: 7,
          },
          2560: {
              slidesPerView: 7,
          },
      },
  });

  document.querySelectorAll('.pengurus-swiper').forEach((swiperEl) => {
    const slideCount = swiperEl.querySelectorAll('.swiper-slide').length;
    const cekKSB = slideCount > 3;
    new Swiper(swiperEl, {
            loop: cekKSB,
            loopAdditionalSlides: 3,
            centeredSlides: true,
            initialSlide: cekKSB ? 0 : 1,
            spaceBetween: 20,
            grabCursor: true,
            slidesPerView: 'auto', // Ini penting untuk width dinamis
            on: {
                click: function (swiper, event) {
                    if (swiper.clickedSlide && cekKSB) {
                        const realIndex = swiper.clickedSlide.dataset.swiperSlideIndex;
                        swiper.slideToLoop(parseInt(realIndex),600);
                    }
                    else {
                        swiper.slideTo(swiper.clickedIndex, 600);
                    }
                }
            }
        });
    });
});
