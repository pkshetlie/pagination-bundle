$(function(){
    $(document).on('click','.btn-paginatation.see-more',function(){
       let $t = $(this);
        $.ajax({
            url : $t.data('href'),
            dataType: 'html',
            success: function(data){
                $t.parent().append(data);
                $t.remove();
            }
        });
       return false;
    });
})