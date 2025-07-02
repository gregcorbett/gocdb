<?php
namespace org\gocdb\security\authentication;


/**
 * A basic custom exception to throw on authorization errors.
 * Based on: https://www.php.net/manual/en/language.exceptions.extending.php
 */
class AuthorizationException extends \Exception {

    // Redefine the exception so message isn't optional
    public function __construct($message, $code = 0, ?Throwable $previous = null) {

        // make sure everything is assigned properly
        parent::__construct($message, $code, $previous);
    }
}

?>
