$(function(){
    
    /* flexible */
    $(window).bind('load resize', function () {

        var winW = $(window).width(),
              docW = $(document).width();

        if(winW < 1280){
            $('body').addClass('w_s');
        }else {
            $('body').removeClass('w_s');
        }

        if(winW < 1440){
            $('body').addClass('w_m');
        }else {
            $('body').removeClass('w_m');
        }

        if(winW > 2560){
            $('body').addClass('w_l');
        }else {
            $('body').removeClass('w_l');
        }

        //nav width resize
        var h1_s = $('#header h1.logo').width(),
              gs_s = $('#common #game_start').width();
        $('#header .nav').css('width', docW-h1_s-gs_s);

        //nav padding resize
        if(winW < 1681){
            var navW = parseInt($('#header .nav').width()*0.054);
            $('#header .nav .dep1').css({
                'padding-left': navW,
                'padding-right': navW
            });
        }else {
            $('#header .nav .dep1').css({
                'padding-left': 62,
                'padding-right': 62
            });
        }

        if(winW < 1536){
            $('#header .tip').addClass('tip_off');
        }else {
            $('#header .tip').removeClass('tip_off');
        }

    }).resize();

    
    /* scroll */
    $(window).bind('load scroll', function() {

        //fixed_header
        if($(this).scrollTop() > $('#GNB_Wrapper').height()){
            $('#wrapper').addClass('fixed_header');
        } else {
            $('#wrapper').removeClass('fixed_header');
        }

    });

    /* fixed 영역 작은창에서 가로스크롤시 위치 설정 */
    $(window).bind('scroll resize', function() {

        var winW = $(window).width(),
              bodyW = $('body').width(),
              scrollW = parseInt($('#wrapper').css('min-width'));

        //fixed_header 일때
        if( $('#wrapper').hasClass('fixed_header')){
            
            // header
            if(winW < scrollW){
                $('#header').css({
                    'margin-left': -$(this).scrollLeft(),
                    'width': scrollW
                });
            }else {
                $('#header').css({
                    'margin-left': 0,
                    'width': "100%"
                });
            }
            // 게임시작/로그인버튼
            if(winW < 1280){
                $('#game_start, .log_info .btn_area').css({
                    'margin-right': bodyW - scrollW + $(this).scrollLeft()
                });
            }else {
                $('#game_start, .log_info .btn_area').css({
                    'margin-right': 0
                });
            }
            
        }
        //fixed_header 아닐때
        else {
            $('#header').css({
                'margin-left': 0,
                'width': "100%"
            });
            $('#game_start, .log_info .btn_area').css({
                'margin-right': 0
            });
        }

        //btn_top
        if(winW < scrollW){
            $('.btn_top').css({
                'margin-right': bodyW - scrollW + $(this).scrollLeft()
            });
        }else {
            $('.btn_top').css({
                'margin-right': 0
            });
        }

    }).resize();


    navigation();
    loginfoFold();
    placeholder();
    gameStart();
    selectBox();

});


/* navigation */
function navigation(){
    $('#header .nav, #header .tip, #header h1.logo').on('mouseover', function(){
        $('#wrapper').addClass('nav_on');
    });
    $('#header .nav, #header .tip').on('mouseout', function(){
        $('#wrapper').removeClass('nav_on');
    });
    $('#header .nav a.dep1').append('<span></span>');
    $('#header .nav a.dep1').each(function(){
        $(this).find('span').css({
            'width': $(this).width(),
            'margin-left' : -($(this).width() / 2) - 8
        })
    });
}

/* log info */
function loginfoFold(){
    $('.log_wrap .btn_fold').on('click', function(){
        if($(this).parent().hasClass('fold')) {
            $(this).parent().removeClass('fold');

        }else {
            $(this).parent().addClass('fold');
        }
    });
}

/* game start btn */
function gameStart(){
    var imgH = 110,
            frames = 55,
            speed = 80,
            cont = 0;

    var animation = setInterval(function(){
        var position =  -1 * (cont*imgH);
        $('#game_start').find('.btns').css('background-position-y', position);
        cont++;
        if(cont == frames){
            cont = 0;
        }
    },speed);

    TweenMax.set($('#game_start .btn_launcher'), {opacity:0});
    var startTl = new TimelineMax({paused:true});
    startTl
        .to($('#game_start .btn_start'), 0.4, {y:-13, ease:Sine.easeInOut})
        .to($('#game_start .btn_launcher'), 0.4, {opacity:1, ease:Sine.easeInOut}, "-=0.3");

    $('#game_start .btns').hover(function(){
        startTl.play();

    }, function(){
        startTl.reverse();
    });
}

/* input placeholder */
function placeholder(){
    $('.placeholder').bind('focus', function () {
        if (this.value.length < 1) {
            $(this).siblings('label').hide();
        }
    }).bind('blur', function () {
        if (this.value.length < 1) {
            $(this).siblings('label').show();
        }
    });
}

/* selectbox */
function selectBox(){
    $('.selectbox').find('.btn_select').on('click', function(e) {
        var $list = $(this).parent();

        if($list.hasClass('show')){
            $list.removeClass('show');
        }else{
            $('.selectbox').removeClass('show');
            $list.addClass('show');
            $list.find('li a').on('click', function(j){
                var selectItem = $(this).html();
                $list.find('.btn_select').html(selectItem);
                $list.removeClass('show');
            });
        }
        e.preventDefault();
    });
    $(document).click(function(j){
        var $list = $('.selectbox');
        var out = $(j.target).closest($list).length;
        if(!(out)){
            $list.removeClass('show');
        }
    });
} 

/* layer */
function simpleLayerOpen(obj) {
    $obj = $('#' + obj);
    $obj.stop().fadeIn(300);
}
function simpleLayerClose(obj) {
    $obj = $('#' + obj);
    $obj.stop().fadeOut(300);
}
function layerMovClose() {
    var $layer = $('#layerMovie');
    $('#mPlayer').attr('src', '');
    $layer.stop().fadeOut(300);
    $('html, body').css('overflow', 'visible');
}
function videoLayerOpen(obj){
    simpleLayerOpen(obj) 
    const ytbSrc = 'TUxgC-cntiQ';
    const iframe = `
        <iframe 
            width='100%' 
            height='100%'
            src='https://www.youtube.com/embed/${ytbSrc}?rel=0&modestbranding=0&showinfo=0&autoplay=0&mute=0'
            frameborder='0' 
            allowfullscreen='' 
            allow='autoplay;encrypted-media'
        >
        </iframe>`
    $('.video_wrap').empty().html(iframe)
}

function videoLayerClose(obj){
    $('.video_wrap iframe').remove()
    simpleLayerClose(obj)
}

(function ($) {

    /* layer1 - scroll hidden */
    $.fn.layer1 = function (options) {
        var config = {};
        if (options) $.extend(config, options);
        this.each(function () {
            var el = "#" + jQuery(this).attr("id");
            $(el).fadeIn(300);
            $('html, body').css('overflow', 'hidden');

            $(el).find('.btn_close').on("click", function (e) {
                $(el).fadeOut(200);
                $('html, body').css('overflow', 'visible');

                e.preventDefault();
            });
        });
        return this;
    };

    /* tab */
    $.fn.tab = function (options) {
        var config = {};
        if (options) $.extend(config, options);
        this.each(function () {
            var el = "." + jQuery(this).attr("class");

            $(el).find(".heading a").bind("click focus", function () {
                runTab($(el).find(".heading a").index(this));
                return false;
            });
            function runTab(idx) {
                $(el).find(".heading").each(function () { $(this).removeClass('active') });
                $(el).find(".heading").eq(idx).addClass('active');
                $(el).find(".tab_con").hide();
                $(el).find(".tab_con").eq(idx).show();
            }
            runTab(0);
        });
        return this;
    };

})(jQuery);



