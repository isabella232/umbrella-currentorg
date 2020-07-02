<?php

function ltw_projects_user_roles_init() {
    add_role(
        'ltw_editor',
        __( 'LTW Projects Editor', 'current-ltw-projects' ),
        array(
            'read' => true,
            'edit_posts' => false,
            'delete_posts' => false,
            'publish_posts' => false,
            'upload_files' => true,
            'read_attachments' => true,
        )
    );
}
add_action( 'init', 'ltw_projects_user_roles_init' );

function ltw_projects_add_role_capabilities() {
 
    $roles = array( 'ltw_editor', 'editor', 'administrator' );

    foreach($roles as $the_role) { 

        $role = get_role($the_role);

        $role->add_cap( 'read' );
        $role->add_cap( 'read_project');
        $role->add_cap( 'read_private_projects' );
        $role->add_cap( 'edit_project' );
        $role->add_cap( 'edit_projects' );
        $role->add_cap( 'edit_others_projects' );
        $role->add_cap( 'edit_published_projects' );
        $role->add_cap( 'publish_projects' );
        $role->add_cap( 'delete_projects' );
        $role->add_cap( 'delete_others_projects' );
        $role->add_cap( 'delete_private_projects' );
        $role->add_cap( 'delete_published_projects' );

    }

}
add_action( 'admin_init', 'ltw_projects_add_role_capabilities', 999 );

/**
 * Unregister LTW taxonomies from Largo CFTL landing page object type
 * so that the new ltw_editor user role doesn't have access to series landing pages
 * 
 * @see https://github.com/INN/largo/blob/c41d8519370b48a6e53ce36b3b516d3e54e39d66/inc/wp-taxonomy-landing/functions/cftl-admin.php#L77-L84
 * @see https://github.com/INN/umbrella-currentorg/pull/156#issuecomment-652672358
 */
function ltw_projects_unregister_taxonomies_from_cftl_landing() {

    $ltw_projects_taxonomies = array(
        'project-category',
        'project-org-type',
        'project-status'
    );

    foreach( $ltw_projects_taxonomies as $taxonomy ) {
        unregister_taxonomy_for_object_type( $taxonomy, 'cftl-tax-landing' );
    }
    
}
add_action( 'init', 'ltw_projects_unregister_taxonomies_from_cftl_landing', 999999 );