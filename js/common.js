$(document).ready(function() {
    $('.preview input[type="file"]').change(function(){
        readURL(this);
        $(this).prev('.delete').removeClass('none')
    });

    $('.preview .delete').click(function(){
        var _parent = $(this).parent();
        var _image = _parent.data('image')
        if (_image) {
            var url = $(this).attr('href');
            $.ajax({
                url:url,
                type:'GET',
                success:function (data) {
                    $(this).addClass('none')
                    _parent.data('image','').css('background-image','');
                }
            });
        } else {
            $(this).addClass('none')
            _parent.data('image','').css('background-image','').find("input[type='file']").val("");
        }
        return false;
    })
    function readURL(input) {

        var fReader = new FileReader();
        fReader.readAsDataURL(input.files[0]);
        fReader.onloadend = function(event){
            $(input).parent().css('background-image','url('+event.target.result+')');
        }
    }

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
        $(".image-preview").elevateZoom({gallery:'navigator', cursor: 'pointer', galleryActiveClass: 'active', imageCrossfade: true, loadingIcon: '/images/loader.gif'});

        $(".image-preview").bind("click", function(e) {
            var ez = $('#zoom_03').data('elevateZoom');
            $.fancybox(ez.getGalleryList());
            return false;
        });
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