<?php namespace JorgeAndrade\SubscribePlus\Controllers;

use Backend\Classes\Controller;
use JorgeAndrade\SubscribePlus\Models\Message;

/**
 * Back-end Controller
 */
class Messages extends Controller
{
    /**
     * @var array Defines a collection of actions available without authentication.
     */
    protected $publicActions = ['webversion'];

    public function webversion($id = null, $hash = null)
    {
        $mail = Message::whereHash($hash)->findOrFail($id);
        return $mail->html;
    }
}
