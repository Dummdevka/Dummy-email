<?php
/**
 * Plugin Name:       Dummy email
 * Plugin URI:        https://example.com/plugins/sincerely-add
 * Description:       You can design your own email template here! You are completely free to create something funny and dummy!
 * Version:           1.10.3
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Dummdevka
 */
define( 'PLUGIN_PREFIX_BASEDIR', __DIR__ );
define( 'PLUGIN_PREFIX_ADMINAJAX_URL', admin_url( 'admin-ajax.php' ) );
//Activation
function de_run() {
    add_option( 'de_email_template' );
    //de_rewrite_mail();
}
//Desactivation
function de_finish() {
    delete_option( 'de_email_template' );
}

register_activation_hook( __FILE__, 'de_run' );
register_deactivation_hook( __FILE__, 'de_finish' );

//Enqueue script
function de_enqueque( $hook ) {
    wp_enqueue_script( 'ajax', plugins_url('ajax.js', __FILE__),array('jquery', 'jquery-form') );
    $ajaxurl = admin_url('admin-ajax.php');
    wp_add_inline_script( 'ajax', "ajaxurl='$ajaxurl'" );
    wp_enqueue_style('de-styles', plugins_url('de-styles.css', __FILE__));
}
function load_ajax() {
    add_action( 'admin_enqueue_scripts', 'de_enqueque' );
}

 //Add side menu
add_action('admin_menu', function() {
    $email_form = add_menu_page('Page title', 'Dumm-email', 'administrator', 'email_page', 'de_render_page');
    // Load the JS conditionally
    add_action( 'load-' . $email_form, 'load_ajax' );
});
//Replacements
function de_replace_html( $message ) {
    $replacements = [
        //Bold header
        '[bold]' => '<h1>',
        '[/bold]' => '</h1>',
        //Semi bold header
        '[semi]' => '<h3>',
        '[/semi]' => '</h3>',
        //Italic
        '[it]' => '<i>',
        '[/it]' => '</i>',
        //Red
        '[red]' => '<p style="color:#CA0B00">',
        '[/red]' => '</p>',
        //Green
        '[gr]' => '<p style="color:#4BCA81">',
        '[/gr]' => '</p>',
        //Btn
        '[btn]' => '<button style="min-height:40px;min-width:90px;border-radius:4px;background-color:#F0D500;border:none;color:black;">',
        '[/btn]' => '</button>',
    ];
    $message = str_replace( array_keys( $replacements), array_values( $replacements ), $message );
    return $message;
}
//Replace user data
function de_replace_user_tags( $message, $user, $blog ) {
    $replacements = [
        //Confirmation url
        '[confirmation-url]' => network_site_url( "login/" ),
        //Username
        '[user-username]' => $user->user_username,
        //Email
        '[user-email]' => $user->user_email,
        //Website name
        '[website-name]' => $blog,
        //Website url
        '[website-url]' => get_home_url(),
    ];
    $message = str_replace( array_keys( $replacements), array_values( $replacements), $message );
    return $message;
    
}
//Admin input
function admin_change_email() {
    $template = [];
    //Send the results
    if( isset($_POST['subject']) && !empty(trim($_POST['subject']))) {
        $subject = ltrim( $_POST['subject']);
        $template['subject'] = $subject;
    }
    if( isset($_POST['body']) && !empty(trim($_POST['body']))) {
        //Replace data
        $message = $_POST['body'];
        //Custom HTML
        if( isset($_POST['html']) && $_POST['html'] === 'on') {
            $template['message'] = $message;
        } else {
            $template['message'] = de_replace_html( $message );
        }
    } else {
        WP_HTTP_Response::set_status( 422 );
    }
    //Update the template
    update_option( 'de_email_template', $template);
    wp_new_user_notification(5, 'user');
    //Finish the ajax call
    wp_die( get_option( 'de_email_template' )['message'] ); // gotta finish an ajax request with this..
}
add_action( 'wp_ajax_admin_change_email', 'admin_change_email' );
//Get dafault template
function de_get_default() {
    $template = get_option( 'de_email_template' );
    echo json_encode( $template );
    wp_die();
}
add_action( 'wp_ajax_get_default', 'de_get_default' );

//Enable html in templates
function de_set_mail_content_type() {
    return 'text/html';
}
add_filter( 'wp_mail_content_type', 'de_set_mail_content_type');
//Insert altered message
function de_custom_email_send( $new_user_email, $user, $blog) {
    $de_email_template = get_option('de_email_template');
    if( isset( $de_email_template['subject'] ) ){
        $new_user_email['subject'] = $de_email_template['subject'];
    }
    if( isset( $de_email_template['message'] ) ){
        $new_user_email['message'] = de_replace_user_tags( $de_email_template['message'], $user, $blog );
    } else {
        $new_user_email['message'] = 'Some fancy stuff';
    }
    return $new_user_email;
}
add_filter('wp_new_user_notification_email', 'de_custom_email_send', 99, 3);


//Render admin menu
function de_render_page() {
    $html = require_once "form.php";
    return $html;
}
