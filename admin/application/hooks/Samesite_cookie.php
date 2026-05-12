<?php
// application/hooks/Samesite_cookie.php
class Samesite_cookie {
    public function set_samesite()
    {
        if (isset($_COOKIE['ci_session'])) {
            setcookie('ci_session', $_COOKIE['ci_session'], [
                'expires'  => time() + 7200,
                'path'     => '/',
                'domain'   => '',
                'secure'   => TRUE,
                'httponly' => TRUE,
                'samesite' => 'Strict'
            ]);
        }

        if (isset($_COOKIE['csrf_cookie_name'])) {
            setcookie('csrf_cookie_name', $_COOKIE['csrf_cookie_name'], [
                'expires'  => time() + 7200,
                'path'     => '/',
                'domain'   => '',
                'secure'   => TRUE,
                'httponly' => TRUE,
                'samesite' => 'Strict'
            ]);
        }
    }
}


?>