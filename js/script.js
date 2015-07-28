$(function(){
    //SELETOR, EVENTO/EFEITO, CALLBACK, AÇÃO
    $('.j_edit').click(function(){
        console.log('Eu cliquei');
        $('form').fadeOut(3000, function(){
            alert('terminou');
        });
    });
});