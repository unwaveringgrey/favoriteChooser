$('.favorite_box').on('click', function(){favoriteSubmit($(this))});




function favoriteSubmit($selected) {
    $('#selected_favorite').val($selected.children('.favorite_id').val());
    document.favorite_chooser.submit() ;
}
