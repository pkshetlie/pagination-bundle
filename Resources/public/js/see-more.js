$(function(){
    $(document).on('click','.btn-paginatation.see-more',function(){
       let $t = $(this);
        $.ajax({
            url : $t.data('href'),
            dataType: 'html',
            success: function(data){
                if($t.data('parent') === undefined) {
                    $t.parent().append(data);
                }else{
                    let parentElt = $($t.data('parent'));
                    parentElt.append(data);
                }
                $t.remove();
            }
        });
       return false;
    });
});