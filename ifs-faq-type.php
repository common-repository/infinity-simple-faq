<?php
/* Some setup */
define('IFS_FAQ_NAME', "FAQs");
define('IFS_FAQ_SINGLE', "FAQ");
define('IFS_FAQ_TYPE', "ifs-faq");
define('IFS_FAQ_ADD_NEW_ITEM', "Add New FAQ");
define('IFS_FAQ_EDIT_ITEM', "Edit FAQ");
define('IFS_FAQ_NEW_ITEM', "New FAQ");
define('IFS_FAQ_VIEW_ITEM', "View FAQ");

/* Register custom post for FAQ*/
function IFS_FAQ_custom_post_register() {  
    $args = array(  
        'labels' => array (
			'name' => __( IFS_FAQ_NAME ),
			'singular_label' => __(IFS_FAQ_SINGLE),  
			'add_new_item' => __(IFS_FAQ_ADD_NEW_ITEM),
			'edit_item' => __(IFS_FAQ_EDIT_ITEM),
			'new_item' => __(IFS_FAQ_NEW_ITEM),
			'view_item' => __(IFS_FAQ_VIEW_ITEM),
		), 
        'public' => true,  
        'show_ui' => true,  
        'capability_type' => 'post',  
        'hierarchical' => false,  
        'rewrite' => true,  
        'supports' => array('title', 'editor')  
       );  
    register_post_type(IFS_FAQ_TYPE , $args );  
}
add_action('init', 'IFS_FAQ_custom_post_register');

?>