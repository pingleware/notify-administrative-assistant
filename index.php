<?php
/**
 * Plugin Name: Notify Administrative Assistamt
 * Description: Provides an action hook to send a note notification to the Administrative Assistant application downloaded from https://sourceforge.net/projects/administrative-assistant/
 * Version: 1.0.0
 * Plugin URI: https://github.com/pingleware/notify-administrative-assistant
 * Author: PressPage Entertainment Inc DBA PINGLEWARE
 * Author URI: https://pingleware.work
 */
?>
<?php
if (!function_exists('notify_administrative_assistant')) {
    function notify_administrative_assistant($url, $note) {
        $response = wp_remote_post(
            $url,
            array(
                'body' => array(
                    'note' => $note
                )
            )
        );
        return $response;
    }

    add_action('notify_administrative_assistant','notify_administrative_assistant',10,2);
}

function notify_administrative_assistant_options_page_html() {
    if (isset($_POST['submit']) && $_POST['submit'] == 'Send') {
        $response = notify_administrative_assistant($_POST['url'],$_POST['note']);
    }
    // check user capabilities
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }
    ?>
    <div class="wrap">
        <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
        <form method="post">
            <label for="url">URL</label><br/>
            <input type="url" name="url" id="url" value="" /><br/>
            <label for="note">Note</label><br/>
            <textarea name="note" id="note" rows="5"></textarea><br/>
            <?php
            submit_button( __( 'Send', 'textdomain' ) );
            ?>
        </form>
    </div>
    <?php
}

function notify_administrative_assistant_options_page()
{
    add_submenu_page(
        'tools.php',
        'Administrative Assistant',
        'Administrative Assistant Test',
        'manage_options',
        'notify_administrative_assistant',
        'notify_administrative_assistant_options_page_html'
    );
}
add_action('admin_menu', 'notify_administrative_assistant_options_page');
?>
