$(document).ready(function() {
    $('input.numeric').keydown(function(evt) {
        var charCode = (evt.which) ? evt.which : event.keyCode;
        if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
            return false;

        return true;
    });
    $('.to-top').click(function (ev) {
        $("html, body").animate({scrollTop:0}, 1000);
    });
    $('img').error(function(ev){
        $(this).attr('src','/images/notfound.jpg')
    })
    if ($('.img-thumb').length > 0) {
        $('.img-thumb').click(function(ev){
            var this_ = $(ev.currentTarget);
            var prev_ = $('.image-preview');
            this_.siblings().removeClass('active');
            this_.addClass('active');
            prev_.attr('src',this_.data('thumb'));
        })
    }
    setTimeout(function(){
        $('.flash-msg').fadeOut();
    },2000)

    $('form').submit(function(ev){
        $(this).find('input[name="page"]').val(1);
    })
    $('.load-more').click(function (ev) {
        var this_ = $(ev.currentTarget);
        if (this_.hasClass('disabled') == false){
            var page_ = $('input[name="page"]');
            var form_ = (page_.closest('form'));
            var pageVal_ = parseInt(page_.val()) + 1;
            var url_ = form_.attr('action');
            page_.val(pageVal_);
            $.ajax({
                url:url_,
                data:form_.serialize(),
                type:'POST',
                success:function (data) {
                    if (data) {
                        $('.items-table').append(data);
                    } else {
                        this_.addClass('disabled').html('you reach end of page');
                    }
                }
            });
        }
        return false;
    });
});