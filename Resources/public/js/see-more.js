$(function(){
    $(document).on('click','.btn-paginatation.see-more',function(){
       let $t = $(this);
       var parentElt = $($t.data('parent'));
        $.ajax({
            url : $t.data('href'),
            dataType: 'html',
            success: function(data){
                if(parentElt === undefined) {
                    $t.parent().append(data);
                }else{
                    parentElt.append(data);
                }
                $t.remove();
            }
        });
       return false;
    });
});