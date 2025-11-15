$(function () {

	/* flexible */
	$(window).bind('load resize', function () {
		var winW = $(window).width();

		$('.ca_notice .desc').css('width', winW / 2.6);
		$('.w_m .ca_notice .desc').css('width', 800);
		$('#common .banner .thumbs').css('width', winW / 2);
		$('#common .banner .thumbs li').css('width', winW / 8)
		$('.w_m #common .banner .thumbs').css('width', 880);
		$('.w_m #common .banner .thumbs li').css('width', 220)
	}).resize();

	/* scroll */
	$(window).bind('load scroll', function () {
	});


	$.fn.mainBanner();
	bannerAll();
	CAItem();
	CATalk();
	CARanking();
	btnOver();
	introBanner();
});


/* 배너 모아보기 */
function bannerAll(){
	//show/hide
	$("#main_banner .btn_list button").on('click', function () {

		if ($(".banner_all").html().length == 0) {
			$('.banner_all').load(location.origin + "/Home/MainEventAll", function () {
				$(".banner_all .btn_close, .banner_all .btn_full").on('click', function () {
					$(".banner_all").fadeOut();
				});

				//커스텀 스크롤 및 스크롤 이벤트 적용
				$(".banner_all .banners_wrap").mCustomScrollbar({
					theme: "dark-3",
					callbacks: {
						whileScrolling: function () {
							scrollEvt();
						}
					}
				});
				//날짜 클릭시 scrollTo 배너 영역 이동
				$('.banner_all .date a').on("click", function (e) {
					e.preventDefault();
					var target = $(this).attr('href');
					$(".banner_all .banners_wrap").mCustomScrollbar("scrollTo", target);
				});

				//이전, 다음 버튼
				$('.banner_all .btn_prev').on('click', function () {
					var $date = $('.banner_all .date')
					curDate = $date.find('li.active').index();

					$date.find('li').eq(curDate - 1).find('a').trigger('click');
				});
				$('.banner_all .btn_next').on('click', function () {
					var $date = $('.banner_all .date')
					curDate = $date.find('li.active').index();
					var _next = (curDate == $date.find("li").length-1) ? 0 : curDate + 1;
					$date.find('li').eq(_next).find('a').trigger('click');
				});

				$('.banner_all').fadeIn();
			});
		} else {
			// 위치값 reset
			$('.banner_all .date li, .banner_all .banners').removeClass('active');
			$('.banner_all .date li:eq(0), .banner_all .banners:eq(0)').addClass('active');
			$(".banner_all .banners_wrap").mCustomScrollbar("scrollTo", 0);
			dateOn();
			$('.banner_all').fadeIn();
		}

	});
}
//스크롤시 배너영역, 날짜 active
function scrollEvt() {
	var $banners = $('.banners_wrap .banners');

	$banners.each(function () {
		var curPos = $(this).offset().top;
		if (curPos < 260) {
			$banners.removeClass('active');
			$(this).addClass('active');
			dateOn();
		}
	});
}
// 날짜 active 및 위치값 잡기
function dateOn() {
	var onId = $('.banners_wrap .banners.active').attr('id'),
		$date = $('.banner_all .date');

	$date.find('li').each(function () {
		var cHref = $(this).find('a').attr('href').replace(/#/, "");

		if (onId == cHref) {
			var curPos = $(this).position().top;

			$date.find('li').removeClass('active');
			$date.find('li span').show();
			$(this).addClass('active');
			$(this).find('span').hide();

			if ($date.find('li.active').index() == 0) {
				$date.css('top', -curPos + 10)
			}
			else if ($date.find('li.active').index() == 1) {
				$date.css('top', -curPos + 100)
			} else {
				$date.css('top', -curPos + 90)
			}
		}
	});
}

/* 크아템 */
function CAItem(){
	$(".ca_tem .sorting button").on('click', function () {
		var btnW = $(this).parent().width(),
			idx = $(this).parent().index();

		$('.ca_tem .sorting .btn').removeClass('active');
		$(this).parent().addClass('active');

		if (idx == 0) {
			TweenMax.to($(".ca_tem .sorting .bar"), 0.5, { width: btnW, x: 0, ease: Circ.easeOut });
		}
		else {
			TweenMax.to($(".ca_tem .sorting .bar"), 0.5, { width: btnW, x: $(".ca_tem .sorting .btn").eq(idx).position().left - 6, ease: Circ.easeOut });
		}
	});

	var temSize = $('.ca_tem .tem_list li').length,
		temW = $('.ca_tem .tem_list li').width() + 20;

	$('.ca_tem .tem_list ul').css('width', temW * temSize);
	$(".ca_tem .tem_list").mCustomScrollbar({
		axis: "x",
		theme: "dark-3",
		callbacks: {
			onScroll: function () {
				listPosition();
			}
		}
	});

	//이전, 다음
	var temIdx = 0;
	function listPosition() {
		var $temLi = $('.ca_tem .tem_list li');

		$(window).bind('load resize', function () {
			var winW = $(window).width() / 2 - 150;

			$temLi.each(function () {
				var curPos = $(this).offset().left;
				if (curPos < winW) {
					$temLi.removeClass('active');
					$(this).addClass('active');
				}
			});

		}).resize();
		temIdx = $('.ca_tem .tem_list li.active').index();
	}
	$('.ca_tem .btn_prev').on('click', function () {
		//1440 해상도 분기 (리스트4개일때, 5개일때)
		if ($('body').hasClass('w_m')) {
			var slide = 4;
		} else {
			var slide = 5;
		}
		if (temIdx > 0) {
			if (0 <= temIdx - slide) {
				temIdx = temIdx - slide;
			} else {
				temIdx = 0;
			}
			$('.ca_tem .tem_list').mCustomScrollbar("scrollTo", '.tem_list li:eq(' + temIdx + ')', { scrollInertia: 500, scrollEasing: "easeOut" });
		}
	});
	$('.ca_tem .btn_next').on('click', function () {
		//1440 해상도 분기 (리스트4개일때, 5개일때)
		if ($('body').hasClass('w_m')) {
			var slide = 4;
		} else {
			var slide = 5;
		}
		if (temIdx < $('.ca_tem .tem_list li').length - slide) {
			temIdx = temIdx + slide;
			$('.ca_tem .tem_list').mCustomScrollbar("scrollTo", '.tem_list li:eq(' + temIdx + ')', { scrollInertia: 500, scrollEasing: "easeOut" });
		}
	});
}

/* 크아톡 */
function CATalk(){
	$(".ca_talk .sorting button").on('click', function () {
		var btnW = $(this).parent().width(),
			idx = $(this).parent().index();

		$('.ca_talk .sorting .btn').removeClass('active');
		$(this).parent().addClass('active');

		if (idx == 0) {
			TweenMax.to($(".ca_talk .sorting .bar"), 0.5, { width: btnW, x: 0, ease: Circ.easeOut });
		}
		else {
			TweenMax.to($(".ca_talk .sorting .bar"), 0.5, { width: btnW, x: $(".ca_talk .sorting .btn").eq(idx).position().left - 6, ease: Circ.easeOut });
		}
	});
	$('.ca_talk h2').append('<span class="line"></span>');

	$(window).bind('load resize', function () {
		var $el = $(".ca_talk"),
			  caTalkW = $el.width(),
			  barW = $el.find('.sorting').width();

		var btnW = $el.find(".sorting .active").width();
		TweenMax.to($el.find(".sorting .bar"), 0.5, { width: btnW, x: $el.find(".sorting .active").position().left - 6, ease: Circ.easeOut });
		$el.find('.line').css('width', caTalkW-barW - 180);
	}).resize();
}

/* 크아랭킹 */
function CARanking(){
	var btnWrap = $('.ca_ranking .sorting .btns'),
		 btnRk = $('.ca_ranking .sorting .btn'),
		 btnRkL = $('.ca_ranking .sorting .btn').length,
		 btnH = $('.ca_ranking .sorting .btn').height();

	btnWrap.find('.btn:last-child').prependTo(btnWrap);

	function rankPrev() {
		var dIdx = $('.ca_ranking .sorting .btn.active').attr('data-idx');

		btnWrap.animate({
			top: btnH + 9
		}, 400, function () {
			moveFirst()
		});

		btnRk.removeClass('active');
		if (dIdx == 1) {
			btnWrap.find('.btn[data-idx=4]').addClass('active');
		} else {
			btnRk.eq(dIdx - 2).addClass('active');
		}
		function moveFirst() {
			btnWrap.find('.btn:last-child').prependTo(btnWrap);
			btnWrap.css('top', 7);
		}
		CAMain.RankingClick();
	};
	function rankNext() {
		var dIdx = $('.ca_ranking .sorting .btn.active').attr('data-idx');

		//TweenMax.to(btnWrap, 0.4, {top: -btnH, ease:Circ.easeOut, onComplete:moveLast});
		btnWrap.animate({
			top: -btnH - 1
		}, 400, function () {
			moveLast()
		});

		btnRk.eq(dIdx - 1).removeClass('active');
		if (dIdx == btnRkL) {
			btnWrap.find('.btn[data-idx=1]').addClass('active');
		} else {
			btnRk.eq(dIdx).addClass('active');
		}
		function moveLast() {
			btnWrap.find('.btn:first-child').appendTo(btnWrap);
			btnWrap.css('top', 7);
		}
		CAMain.RankingClick();
	};
	$('.ca_ranking .sorting .btn_prev').on('click', function () {
		rankPrev();
	});
	$('.ca_ranking .sorting .btn_next').on('click', function () {
		rankNext();
	});
	btnRk.on('click', function () {
		var cIdx = $(this).attr('data-idx'),
			dIdx = $('.ca_ranking .sorting .btn.active').attr('data-idx');

		if (cIdx < dIdx) {
			if (cIdx == 1 && dIdx == btnRkL) {
				rankNext();
			} else {
				rankPrev();
			}
		}
		else if (cIdx > dIdx) {
			if (cIdx == btnRkL && dIdx == 1) {
				rankPrev();
			} else {
				rankNext();
			}
		}
	});
	//server
	$(".ca_ranking .server button").on('click', function () {
		var btnW = $(this).parent().width(),
			idx = $(this).parent().index();

		$('.ca_ranking .server .btn').removeClass('active');
		$(this).parent().addClass('active');

		if (idx == 0) {
			TweenMax.to($(".ca_ranking .server .bar"), 0.5, { width: btnW, x: 0, ease: Circ.easeOut });
		}
		else {
			TweenMax.to($(".ca_ranking .server .bar"), 0.5, { width: btnW, x: $(".ca_ranking .server .btn").eq(idx).position().left - 6, ease: Circ.easeOut });
		}
		CAMain.RankingClick();
	});
}

/* 버튼 over */
function btnOver(){
	$('.intro_banner, .ca_monthly .cover').hover(function(){
		TweenMax.to($(this), 0.4, {y:15,  ease:Circ.easeOut})
	}, function(){
		TweenMax.to($(this), 0.2, {y:0,  ease:Circ.easeOut})
	});	
}

(function ($) {

	/* 메인 배너 */
	$.fn.mainBanner = function (options) {
		// 변수 기본값
		var defaults = {
			banners: '#main_banner .viewer li',
			//nextItem: '#main_banner .next_item',
			prevBtn: '#main_banner .controls .prev',
			nextBtn: '#main_banner .controls .next',
			pager: '#main_banner .controls .paging',
			thumbs: '#main_banner .thumbs ul',
			tmb: '#main_banner .thumbs ul li',
			interval: 4000,
			pause: false
		};

		// 사용자 변수와 기본값 merge
		var settings = $.extend({}, defaults, options);
		var $banners = $(settings.banners);
		var bannerSize = $banners.length;

		// 기준 인덱스
		var pivotIdx = 0;

		// 총 인덱스
		$('#main_banner .total').html(bannerSize);

		// 마우스오버시 멈춤
		$(settings.prevBtn + ',' + settings.nextBtn + ',' + settings.tmb).hover(function () {
			settings.pause = true;
		}, function () {
			settings.pause = false;
		});
		$('#main_banner').hover(function () {
			$('#main_banner .thumbs_wrap').stop().fadeIn();

		}, function () {
			$('#main_banner .thumbs_wrap').stop().fadeOut();

		});

		// 다음버튼
		$(settings.nextBtn).on('click', function () {
			intervalFunc();
		});
		// 이전버튼
		$(settings.prevBtn).on('click', function () {
			pivotIdx -= 2;
			intervalFunc();
		});
		// 썸네일버튼
		$(settings.tmb).on('click', function (e) {
			var n = $(this).index() - 1;
			pivotIdx = n;
			intervalFunc();
			e.preventDefault();
		});

		var funcArray = [];

		// 배너영역
		funcArray.push(function () {
			var number = pivotIdx + ((pivotIdx > bannerSize - 1) ? 2 : 1);
			$banners.fadeOut(400).eq(number % bannerSize).fadeIn(500);

		});

		// 페이징
		funcArray.push(function () {
			var n = pivotIdx + 2;
			$(settings.pager).html('<em>' + (n >= bannerSize + 1 ? 1 : n) + '</em> <span class="bar">/</span> <span class="total">' + bannerSize + '</span>');
			$(this).delay(2000);
		});

		var bnTitTl = new TimelineMax({ paused: true });

		bnTitTl
			.from($banners.find('.category, .time'), 0.4, { opacity: 0, y: 10, ease: Circ.easeOut }, "+=0.3")
			.from($banners.find('.l1 span'), 0.6, { opacity: 0, y: 60, ease: Circ.easeOut }, "-=0.4")
			.from($banners.find('.l2 span'), 0.6, { opacity: 0, y: 60, ease: Circ.easeOut }, "-=0.4")
			.from($banners.find('.txt'), 0.6, { opacity: 0, ease: Circ.easeOut }, "-=0.4");

		// 다음 배너
		// funcArray.push(function() {
		//     var n = pivotIdx + 1;
		//     var html = $banners.eq(n).find('.tit').html();

		//     if (n == bannerSize) {
		//         var html = $banners.eq(0).find('.tit').html();
		//     } 
		//     else if (n == bannerSize+1) {
		//         var html = $banners.eq(1).find('.tit').html();
		//     } 
		//     $(settings.nextItem).find('.tit').html(html);
		//     $(settings.nextItem).show().delay(800).fadeOut();
		// });

		// 썸네일 리스트
		funcArray.push(function () {
			var thumbs = $(settings.thumbs);
			var tmbW = thumbs.find('li').width();
			var display = 4;

			var n = pivotIdx + 1;
			n = (n >= bannerSize ? 0 : n);

			if (n >= display) {
				TweenMax.to(thumbs, 0.6, { x: -tmbW * (n - (display - 1)), ease: Circ.easeOut });

			} else {
				TweenMax.to(thumbs, 0.6, { x: 0, ease: Circ.easeOut });
			}

			thumbs.find('li')
				.prop('class', '')
				.eq(n).prop('class', 'active')
		});

		setIntervalEvent();

		// interval 에 맞춰서 실행할 함수 등록, 첫실행
		function setIntervalEvent() {
			setInterval(function () {
				if (!settings.pause) {
					intervalFunc();
				}
			}, settings.interval);
			TweenMax.fromTo($('.timer_bar'), settings.interval / 1000, { width: '0' }, { width: '100%' });

			bnTitTl.restart();

		}
		function intervalFunc() {
			if (pivotIdx >= bannerSize) {
				pivotIdx = 0;
			} else if (pivotIdx < 0) {
				pivotIdx = bannerSize - 1;
			}
			for (var i = 0; i < funcArray.length; i++) {
				funcArray[i]();
			}
			pivotIdx++;

			// loading bar
			TweenMax.fromTo($('.timer_bar'), settings.interval / 1000, { width: '0' }, { width: '100%' });

			bnTitTl.restart();

		}
	};

})(jQuery);

function introBanner(){
	new Swiper(".intro_banner_swiper", {
        cssMode: true,
        navigation: {
            nextEl: ".intro_banner_next",
            prevEl: ".intro_banner_prev",
        },
		pagination : {
			el : '.intro_banner_pagination',
		},
		autoplay:{
			delay:3500,
			disableOnInteraction : false,
		}
    });
}

