$(function(){
    $(document).on('click','.btn-paginatation.see-more',function(){
       let $t = $(this);
        $.ajax({
            url : $t.attr('href'),
            dataType: 'html',
            success: function(data){
                $t.parent().append(data);
                $t.remove();
            }
        });
       return false;
    });
})