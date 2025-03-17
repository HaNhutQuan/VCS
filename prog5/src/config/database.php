class Database {
    private $host = DB_HOST;
    private $db_name = DB_NAME;
    private $db_user = DB_USER;
    private $db_pass = DB_PASS;

    public $conn;

    public function getConnection() {
        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host={$this->host};dbname={$this->db_name}", $this->db_user, $this->db_pass);
        }catch(PDOException $err) {
            echo $err->getMessage();
        }

        return $this->conn;
    }
}