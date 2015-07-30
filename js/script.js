$(function () {

    $('.j_open').click(function () {
        $(this).toggleClass('closeform')
        $('.' + $(this).attr('rel')).slideToggle();
    });

    $('.j_load').click(function () {
        var destino = $('.' + $(this).attr('rel'));
        var loaded = destino.find('article').length;

        $.ajax({
            url: "ajax/ajax.php",
            data: {action: 'loadmore', offset: loaded},
            type: 'POST',
            dataType: 'json',
            beforeSend: function () {
                $('.register').find('.form_load').fadeIn();
            },
            success: function (data) {
                $(data.result).prependTo(destino.find('.j_insert'));
                $('.trigger, article').fadeIn(400, function () {
                    $('.register').find('.form_load').fadeOut();
                });
            }

        });
    });
    //SELETOR, EVENTO/EFEITO, CALLBACK, AÇÃO
    $('.j_formsubmit').submit(function () {
        var form = $(this);
        var data = $(this).serialize();

        $.ajax({
            url: "ajax/ajax.php",
            data: data,
            type: 'POST',
            dataType: 'json',
            beforeSend: function () {
                form.find('.form_load').fadeIn(500);
                form.find('.trigger').fadeOut(500, function () {
                    $(this).remove();
                });
            },
            success: function (resposta) {
                if (resposta.error) {
                    form.find('.trigger-box').html('<div class="trigger trigger-error">' + resposta.error + '</div>');
                    form.find('.trigger-error').fadeIn();
                } else {
                    form.find('.trigger-box').html('<div class="trigger trigger-success">' + resposta.success + '</div>');
                    form.find('.trigger-success').fadeIn();
                    form.find('input[class!="noclear"]').val('');


                }

                form.find('.form_load').fadeOut(500);
            }
        });
        return false;
    });
});