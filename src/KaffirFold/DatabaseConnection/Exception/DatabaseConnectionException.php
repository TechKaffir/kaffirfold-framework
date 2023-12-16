<?php  

declare(strict_types = 1);

namespace KaffirFold\DatabaseConnection\Exception;

use PDOException;

class DatabaseConnectionException extends PDOException
{
    protected $message;
    protected $code;

    public function __construct($message = null, $code = null)
    {
        // pipe these properties to the constructor args
        $this->message = $message;
        $this->code = $code;
    }
}