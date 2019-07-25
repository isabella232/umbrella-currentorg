// modifications for the edit_listing view pages
// includes the listing modification page and the submission received page
jQuery(function($) {

    $('p').each(function(){
        if($(this).text() == 'Your listing changes were saved.'){
            $(this).text('Your listing changes have been submitted for review.');
        }
    });

});