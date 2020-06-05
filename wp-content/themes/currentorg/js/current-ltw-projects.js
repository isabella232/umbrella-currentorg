var $ = jQuery;
$(document).ready(function(){

    current_ltw_projects_load_param_project_if_exists();

    $(document).on('click', '.projects-list article .entry-title a', function(e){
        e.preventDefault();
        var post_id = $(this).data("post-id");
        current_ltw_projects_load_single_project(post_id);

        // add active left border
        $('.projects-list-item').removeClass('active');
        $(this).closest('.projects-list-item').addClass('active');
    });

    $(".projects-single-close").on('click', function(){
        $('.projects-list-item').removeClass('active');
        $(".projects-single-layout").hide();
    });

    $(document).on('scroll', function(){   
        if($('.sticky-nav-holder').hasClass('show')) {
            $('html').addClass('sticky-show');
        } else {
            $('html').removeClass('sticky-show');
        }
    });

});

/**
 * Function to load the single project partial for whatever project
 * is provided.
 * 
 * @param int post_id The id of the project we want to load
 */
function current_ltw_projects_load_single_project( post_id ) {

    // give a reassuring "loading" notice
    $(".projects-single-holder").html("Loading project...");

    // actually load the single project
    $(".projects-single-holder").load(ajax_object.ajax_url+"?action=load_more_post&post_id="+post_id);
    $(".projects-single-layout").addClass('open');
    $(".projects-single-layout").show();
    
    // return and let's be happy
    return;

}

/**
 * Fires on page load to check if a post_id query param is set
 * If it is set, attemps to load the specified project by the ID given
 */
function current_ltw_projects_load_param_project_if_exists() {

    // find all current query params
    var get_url_params = new URLSearchParams(window.location.search);

    // if the post id query param exists, let's use it
    if(get_url_params.get('project_id') || Number.isInteger(get_url_params.get('project_id'))) {

        var post_id = get_url_params.get('project_id');

        // actually try and load the project
        current_ltw_projects_load_single_project( post_id );
        
        return;

    }

}