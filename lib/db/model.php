<?php
namespace Lib\Db;

class Model
{
    public $id = null;
    protected $db;
    protected $table;
    protected $columns = [];

    public function __construct()
    {
        $this->db = DB::getInstance();
    }

    public static function findOne($where)
    {
        return DB::findOne(static::class, $where);
    }

    public static function findAll($where = null)
    {
        return DB::findAll(static::class, $where);
    }


    public function save()
    {
        // check to ensure all properties have values
        if (!$this->isComplete()) {
            return false;
        }

        if ($this->isDuplicate()) {
            return true;
        }

        //execute sql
        $values = $this->getPropertyValues();

        $sql = 'INSERT INTO '.$this->table.' ('.Sql::columns($this->columns).') VALUES ('.Sql::values($values).')';
        $this->db->query($sql);

        //returns record based on value from current object
        $this->findOne([$this->columns[0] => $this->{$this->columns[0]}]);
    }

    // protected functions
    protected function isComplete()
    {
        foreach ($this->columns as $column) {
            if ($this->{$column} == null) {
                return false;
            }
        }
        return true;
    }

    //checks if id is set (only set if recorded in table)
    protected function hasID()
    {
        return $this->id !== null;
    }

    //checks to see if current property values of object are already stored in table
    protected function isDuplicate()
    {
        $object = $this->findDuplicate();
        if (isset($object->id)) {
            return true;
        } else {
            return false;
        }
    }

    protected function findDuplicate()
    {
        $where = [];
        $values = $this->getPropertyValues($this->columns);
        for ($i = 0; $i < count($this->columns); $i++) {
            $where[$this->columns[$i]] = $values[$i];
        }

        return $this->findOne($where);
    }


    protected function createObject($sql_row)
    {
        if (!$sql_row == null) {
            $this->id = $sql_row["id"];
            foreach ($this->columns as $column) {
                $this->{$column} = $sql_row[$column];
            }
        }
    }

    // returns property values as array
    protected function getPropertyValues()
    {
        foreach ($this->columns as $column) {
            $values[] = $this->{$column};
        }
        return $values;
    }
}
