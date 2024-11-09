<?php

namespace App\Models;

#[\AllowDynamicProperties]
class BaseModel {
    protected $table;
    protected $pk;
    protected $db;

    public static function __callStatic($method, $arg) {
        $obj = new static;
        if (is_callable([$obj, $method])) {
            return call_user_func_array([$obj, $method], $arg);
        }
        throw new \Exception("Method $method does not exist");
    }

    public function __construct($db = null) {
        $this->db = $db ?: $GLOBALS['db'];

        if (!isset($this->table)) {
            $single = strtolower($this->getClassName(get_called_class()));
            switch (substr($single, -1)) {
                case 'y':
                    $this->table = substr($single, 0, -1) . 'ies';
                    break;
                case 's':
                    $this->table = $single;
                    break;
                default:
                    $this->table = $single . 's';
            }
        }

        if (!isset($this->pk)) {
            $this->pk = 'id';
        }
    }

    public function searchAllTables(string $searchTerm): array {
        $results = [];
        $tables = $this->getTables();

        foreach ($tables as $table) {
            $columns = $this->getColumns($table);

            if (empty($columns)) continue;

            $query = "SELECT * FROM `$table` WHERE ";
            $conditions = [];
            $params = [':search' => '%' . $searchTerm . '%'];

            foreach ($columns as $column) {
                $conditions[] = "`$column` LIKE :search";
            }
            $query .= implode(' OR ', $conditions);

            $stmt = $this->db->prepare($query);
            $stmt->execute($params);

            $tableResults = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            if (!empty($tableResults)) {
                $results[$table] = $tableResults;
            }
        }

        return $results;
    }

    private function getTables(): array {
        return ['users', 'coins', 'wallets', 'transactions'];
    }

    private function getColumns(string $table): array {
        $stmt = $this->db->query("SHOW COLUMNS FROM `$table`");
        return array_column($stmt->fetchAll(\PDO::FETCH_ASSOC), 'Field');
    }

    public function all(int $limit = 100, int $offset = 0) {
        $sql = 'SELECT * FROM `' . $this->table . '` LIMIT :limit OFFSET :offset';
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':limit', $limit, \PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
        $stmt->execute();

        return $this->castToModel($stmt->fetchAll(\PDO::FETCH_ASSOC));
    }

    public function find(int $id) {
        $sql = 'SELECT * FROM ' . $this->table . ' WHERE ' . $this->pk . ' = :p_id';
        $pdo_statement = $this->db->prepare($sql);
        $pdo_statement->execute([':p_id' => $id]);

        $db_item = $pdo_statement->fetchObject();

        return self::castToModel($db_item);
    }

    public function findById(int $id) {
        $sql = 'SELECT * FROM ' . $this->table . ' WHERE ' . $this->pk . ' = :p_id';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':p_id' => $id]);

        return $this->castToModel($stmt->fetch(\PDO::FETCH_ASSOC));
    }

    public function findByColumn(string $column, int $value, bool $single = true) {
        $sql = 'SELECT * FROM `' . $this->table . '` WHERE `' . $column . '` = :value';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':value' => $value]);
    
        $result = $single ? $stmt->fetch(\PDO::FETCH_ASSOC) : $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $this->castToModel($result);
    }    

    protected function castToModel($object) {
        if (is_array($object) && isset($object[0]) && is_array($object[0])) {
            return array_map(fn($item) => $this->castToModel($item), $object);
        }
        if (empty($object)) return null;

        $item = new static();
        foreach ((array)$object as $column => $value) {
            $item->{$column} = $value;
        }
        return $item;
    }

    public function delete() {
        return $this->deleteById($this->{$this->pk});
    }

    public function deleteById(int $id) {
        if ($this->table === 'users') {
            $transactionDeleteQuery = $this->db->prepare("DELETE FROM wallets WHERE user_id = :user_id");
            $transactionDeleteQuery->execute([':user_id' => $id]);

            $transactionDeleteQuery = $this->db->prepare("DELETE FROM transactions WHERE user_id = :user_id");
            $transactionDeleteQuery->execute([':user_id' => $id]);

            $notificationDeleteQuery = $this->db->prepare("DELETE FROM notifications WHERE user_id = :user_id");
            $notificationDeleteQuery->execute([':user_id' => $id]);
        }
        
        $sql = 'DELETE FROM `' . $this->table . '` WHERE `' . $this->pk . '` = :p_id';
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':p_id' => $id]);
    }

    public function update(int $id, array $data) {
        $setClause = '';
        foreach ($data as $column => $value) {
            $setClause .= "`$column` = :$column, ";
        }
        $setClause = rtrim($setClause, ', ');

        $sql = "UPDATE `{$this->table}` SET $setClause WHERE `{$this->pk}` = :id";
        $data['id'] = $id;

        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }

    public function create(array $data) {
        $columns = implode(', ', array_keys($data));
        $values = implode(', ', array_map(fn($key) => ":$key", array_keys($data)));

        $sql = "INSERT INTO `{$this->table}` ($columns) VALUES ($values)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($data);

        return $this->db->lastInsertId();
    }

    public function authenticate(string $username, string $password) {
        $sql = 'SELECT user_id, username, password_hash, role, profile_picture FROM `' . $this->table . '` WHERE `username` = :username';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':username' => $username]);
    
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);
    
        if ($user && $password === $user['password_hash']) {
            unset($user['password_hash']); 
            return $user; 
        }
    
        return null;
    }

    private function getClassName($classname) {
        return strpos($classname, '\\') === false ? $classname : substr($classname, strrpos($classname, '\\') + 1);
    }
}