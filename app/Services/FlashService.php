<?php

namespace App\Services;

class FlashService
{
    public function setFlashMessage($type, $message)
    {
        session()->flash($type, $message);
    }
}
