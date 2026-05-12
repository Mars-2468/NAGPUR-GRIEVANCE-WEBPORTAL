<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Security extends CI_Security {

    public function csrf_verify()
    {
        // run default CI validation
        $result = parent::csrf_verify();

        if ($result !== FALSE) {
            // ✅ immediately kill the old token so replay won't work
            $this->_csrf_hash = $this->csrf_set_hash();
            $this->csrf_set_cookie();
        }

        return $result;
    }
}
