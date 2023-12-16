<?php 

declare(strict_types = 1);

namespace KaffirFold\DatabaseConnection;

use PDO;

interface DatabaseConnectionInterface
{
    /**
     * Create a new Database Connection
     * @return PDO
     */
    public function open(): PDO;

    /**
     * Close Database Connection
     * @return void
     */
    public function close(): void;
} 