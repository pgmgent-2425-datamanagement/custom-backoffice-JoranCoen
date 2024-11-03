<?php
namespace App\Models;

#[\AllowDynamicProperties]
class BaseModel {

    protected $table;
    protected $pk;
    protected $db;

    public static function __callStatic ($method, $arg) {
        $obj = new static;
        $result = call_user_func_array (array ($obj, $method), $arg);
        if (method_exists ($obj, $method))
            return $result;
        return $obj;
    }

    public function __construct() {

        if(!isset($this->table)) {
            $single = strtolower( $this->getClassName(get_called_class()));
            switch(substr($single, -1)) {
                case 'y':
                    //for example: Category model => categories table
                    $this->table = substr($single, 0, -1) . 'ies';
                    break;
                case 's':
                    //for example: News model => news table
                    $this->table = $single;
                    break;
                default:
                    //for example: User model => users table
                    $this->table .= $single . 's';
            }
        }
        if(!isset($this->pk)) {
            $this->pk = 'id';
        }
        if(!isset($this->db)) {
            global $db;
            $this->db = $db;
        }
    }

    public function all(int $limit = 100, int $offset = 0) {
        $sql = 'SELECT * FROM `' . $this->table . '` LIMIT :limit OFFSET :offset';
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        $db_items = $stmt->fetchAll();

        return self::castToModel($db_items);
    }

    private function find ( int $id ) {
        $sql = 'SELECT * FROM `' . $this->table . '` WHERE `' . $this->pk . '` = :p_id';
        $pdo_statement = $this->db->prepare($sql);
        $pdo_statement->execute( [ ':p_id' => $id ] );

        $db_item = $pdo_statement->fetchObject();

        return self::castToModel($db_item);
    }

    protected function castToModel ($object) {
        if(!is_object($object) && isset($object[0]) && is_array($object[0])) {
            $items = [];
            foreach($object as $db_item) {
                $items[] = $this->castToModel($db_item);
            }
            return $items;
        }
        $db_item = (object) $object;
        $model_name = get_class($this);
        $item = new $model_name();
        
        foreach($db_item as $column => $value) {
            $item->{$column} = $value;
        } 
        return $item;
    }

    private function deleteById ( int $id ) {
        $sql = 'DELETE FROM `' . $this->table . '` WHERE `' . $id . '` = :p_id';
        $pdo_statement = $this->db->prepare($sql);
        return $pdo_statement->execute( [ ':p_id' => $id ] );
    }

    public function delete () {
        $this->deleteById( $this->pk );
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

    private function getClassName($classname) {
        if(strpos($classname, '\\') === false) {
            return $classname;
        }
        return (substr($classname, strrpos($classname, '\\') + 1));
    }

}