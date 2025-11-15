$(function(){

    tab();
    placdholder();
    chkOn();
    selectBox();
    
});

/* tab */
function tab() {
    var $el  = $('#loginContainer');

    $el.find(".lnb li a").bind("click focus", function () {
        runTab($el.find(".lnb li a").index(this));
        return false;
    });
    function runTab(idx) {
        $el.find(".lnb li a").each(function () { $(this).parent().removeClass('active') });
        $el.find(".lnb li a").eq(idx).parent().addClass('active');
        $el.find(".t_contents").hide();
        $el.find(".t_contents").eq(idx).show();
    }
    runTab(0);
}

/* placeholder */
function placdholder() {
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

/* check on */
function chkOn(){
    var $el  = $('#loginContainer');
    $el.find('.btn_chk').on('click', function(){
        $(this).parent().find('.btn_chk').removeClass('on');
        $(this).addClass('on');
    });
    $el.find('.btn_id_chk').on('click', function(){
        $(this).toggleClass('on');
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
            $list.find('li a').off('click');
            $list.find('li a').on('click', function(j){
                var selectItem = $(this).html();
                $list.find('.btn_select').html(selectItem);
                $list.find('.btn_select').addClass('selected');
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