import $ from 'jquery';


$(".related_slide").slick({
 
    dots: true,
    speed: 300,
    infinite: false,
    centerMode: true,
    slidesToShow: 4,
    slidesToScroll: 1,
    prevArrow : '.prevArrow',
    nextArrow : '.nextArrow',
    responsive: [
      {
        breakpoint: 1024,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 1,
          infinite: false,
        }
      },
      {
        breakpoint: 600,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1
        }
      },
      {
        breakpoint: 480,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1
        }
      }
      // You can unslick at a given breakpoint now by adding:
      // settings: "unslick"
      // instead of a settings object
    ]
  });