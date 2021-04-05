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
                if($t.closest(".see-more-delete") !== undefined) {
                    $t.closest(".see-more-delete").remove();
                }
                $t.remove();
                $(document).trigger('seemore.remove');
            }
        });
        return false;
    });
});