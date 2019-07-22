jQuery(document).ready(function(){

    // grab all wpbdp_category terms with the child tags from our rest endpoint
    var category_child_tags = jQuery.get("/wp-json/currentorg/v1/wpbdp_categories", function(data, status){
        return data;
    });

    // empty arr of allowed tags
    var allowed_tags = [];

    // grab selected category
    jQuery('#wpbdp-field-2').on('select2:select', function (e) {
        
        // grab category data and id
        var selected_category = e.params.data;
        var category_id = e.params.data.id;

        // find the index in our category_child_tags response that matches the id of the selected category
        var category_with_child_tags_index = category_child_tags.responseJSON.findIndex(function(category){
            return category.wpbdp_category_id == category_id;
        });

        // loop through each of the category child tags and add their names to the `allowed_tags` arr
        jQuery.each(category_child_tags.responseJSON[category_with_child_tags_index]['wpbdp_category_child_tags'], function(index, tag){
            allowed_tags.push(tag.name);
        });

        console.log(allowed_tags);

    });

    console.log(allowed_tags);

    // grab selected fee plan

    // check wp api to verify what tags are children of selected category and update select box

});