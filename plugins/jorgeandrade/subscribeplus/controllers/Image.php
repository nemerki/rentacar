<?php namespace JorgeAndrade\SubscribePlus\Controllers;

use Backend\Classes\Controller;
use JorgeAndrade\SubscribePlus\Models\Message;

/**
 * Back-end Controller
 */
class Image extends Controller
{
    /**
     * @var array Defines a collection of actions available without authentication.
     */
    protected $publicActions = ['image'];

    /**
     * Log the mail open and output a 1x1 image
     * @param  integer $id
     * @param  string $hash
     * @return void
     */
    public function image($id = null, $hash = null)
    {
        $hash = str_replace('.png', '', $hash);
        $mail = Message::whereHash($hash)->findOrFail($id);

        // Log the email open
        $mail->logEmailOpened();

        // output img
        header('Content-Type: image/png');
        header('Cache-Control: no-cache, max-age=0');
        echo base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABAQMAAAAl21bKAAAAA1BMVEUAAACnej3aAAAAAXRSTlMAQObYZgAAAApJREFUCNdjYAAAAAIAAeIhvDMAAAAASUVORK5CYII=');
        die;
    }
}
