// Database.php
class Database {
    private $pdo;
    
    public function connect() {
        try {
            $this->pdo = new PDO('mysql:host=localhost;dbname=test', 'user', 'pass');
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            $errorMessage = "Connection failed: " . $e->getMessage();
            file_put_contents(__DIR__ . '/../logs/db_errors.log', 
                date('[Y-m-d H:i:s]') . " DB_ERROR: " . $errorMessage . "\n", 
                FILE_APPEND
            );
            throw new Exception("Database error (see logs)");
        }
    }
}