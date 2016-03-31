<?php

namespace App\Http;

class Flash {

    /**
     * create the flash message, that will pass in
     * title, message, and the level (info, success, error)
     *
     * @param $title
     * @param $message
     * @param $level
     * @param string $key
     * @return mixed
     */
    public function create($title, $message, $level, $key = 'flash_message') {
        return session()->flash($key, [
            'title'   => $title,
            'message' => $message,
            'level'   =>  $level
        ]);
    }


    /**
     *  Display the success flash message icon.
     *
     * @param $title
     * @param $message
     * @return mixed
     */
    public function success($title, $message) {
        return $this->create($title, $message, 'success');
    }


    /**
     * Display the error flash message icon.
     *
     * @param $title
     * @param $message
     * @return mixed
     */
    public function error($title, $message) {
        return $this->create($title, $message, 'error');
    }


    /**
     * Display the info flash message icon.
     *
     * @param $title
     * @param $message
     * @return mixed
     */
    public function info($title, $message) {
        return $this->create($title, $message, 'info');
    }

}