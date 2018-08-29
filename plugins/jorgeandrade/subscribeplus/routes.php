<?php
use JorgeAndrade\SubscribePlus\Models\Message;
use Illuminate\Database\Eloquent\ModelNotFoundException;

Route::get('campaign/messages/webversion/{id}/{hash}', ['as' => 'webversion', function ($id, $hash) {
    try {
        $mail = Message::whereHash($hash)->findOrFail($id);
        return $mail->html;
    } catch (ModelNotFoundException $e) {
        return \Redirect::to('/');
    }
}]);