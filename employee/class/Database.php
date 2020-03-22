<?php

if (!defined('DEBUG')) define('DEBUG', false);

abstract class Databse 
{
    protected $mysqli;

    public function __construct()
    {
        $this->mysqli = $this->connect();
    }

    protected function throwException(Throwable $th)
    {
        if (DEBUG) throw $th;
        $this->setAlert('danger', $th->getMessage());
    }

    public function alert()
    {
        if (!isset($_SESSION['alert'])) {
            return null;
        }
        $alert = $_SESSION['alert'];
        unset($_SESSION['alert']);
        return $alert;
    }

    public function setAlert($type, $message = null)
    {
        if (is_null($message)) {
            $message = $type;
            $type = 'success';
        }
        $_SESSION['alert'] = compact('type', 'message');
    }

    public function date($format, $string = null)
    {
        if (is_null($string)) {
            $string = $format;
            $format = 'Y-m-d';
        }
        return date($format, strtotime(str_replace('/', '-', $string)));
    }

    public function redirect($path)
    {
        die("<script type=\"text/javascript\">window.location.href = '{$path}'</script>");
    }

    protected function connect()
    {
        if ($this->mysqli instanceof mysqli) return $this->mysqli;

        $mysqli = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

        if ($mysqli->connect_errno) {
            throw new Exception("Failed to connect to MySQL: {$mysqli->connect_error}", 500);
        }

        return $mysqli;
    }

    protected function isAssociativeArray(array $array): bool
    {
        return array_keys($array) !== range(0, count($array) - 1);
    }

    protected function arrayOnly($array, $keys)
    {
        return array_intersect_key($array, array_flip((array) $keys));
    }

    protected function mapPlaceholderMark(array $array): array
    {
        return array_map(function ($key) {
            return "{$key} = ?";
        }, $array);
    }

    protected function getTypes(array $values): string
    {
        return implode(array_map(function ($value) {
            if ('integer' == gettype($value)) return 'i';
            if ('double' == gettype($value)) return 'd';
            if ('string' == gettype($value)) return 's';

            return 'b';
        }, $values));
    }

    protected function wrapIfNotArray($value): array
    {
        return is_array($value) ? $value : [$value];
    }

    protected function prepareExecute(string $query, array $values)
    {
        $return = new stdClass;

        if ($return->success = $stmt = $this->mysqli->prepare($query)) {
            if ($values) $stmt->bind_param($this->getTypes($values), ...$values);
            if ($return->success = $stmt->execute()) {

                if (strpos($query, 'SELECT') === 0) {
                    $result = $stmt->get_result();

                    $return->results = [];
                    $return->count = $result->num_rows;

                    while ($row = $result->fetch_object()) {
                        array_push($return->results, $row);
                    }
                }

                if (strpos($query, 'INSERT') === 0) {
                    $return->insert_id = $stmt->insert_id;
                }

                if (strpos($query, 'UPDATE') === 0) {
                    $return->affected_rows = $stmt->affected_rows;
                }
            } else {
                throw new Exception($stmt->error);
            }
        } else {
            throw new Exception($this->mysqli->error);
        }

        return $return;
    }

    protected function select(string $table, $columns = '*', array $where = [], array $extra = [])
    {
        $values = [];

        if (is_array($columns)) {
            if (0 == count($columns)) throw new InvalidArgumentException('The columns must have at least 1 items.');

            if ($this->isAssociativeArray($columns)) throw new InvalidArgumentException('The columns must be a sequential array.');

            $columns = implode(', ', $columns);
        }

        if (0 < count($where)) {
            if (!$this->isAssociativeArray($where)) throw new InvalidArgumentException('The where must be a associative array.');

            $values = array_merge($values, array_values($where));
            $where = implode(' AND ', $this->mapPlaceholderMark(array_keys($where)));
        }

        $limit = null;
        if (array_key_exists('limit', $extra)) {
            $limit = implode(', ', $this->wrapIfNotArray($extra['limit']));
        }

        $query = "SELECT {$columns} FROM {$table}";
        if ($where) $query .= " WHERE {$where}";
        if ($limit) $query .= " LIMIT {$limit}";

        return $this->prepareExecute($query, $values);
    }

    protected function insert(string $table, array $data = [])
    {
        if (!$this->isAssociativeArray($data)) throw new InvalidArgumentException('The data must be a associative array.');

        $columns = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));

        $query = "INSERT INTO {$table} ({$columns}) VALUES ({$placeholders})";
        return $this->prepareExecute($query, array_values($data));
    }

    protected function update(string $table, array $data = [], array $where)
    {
        if (!$this->isAssociativeArray($data)) throw new InvalidArgumentException('The data must be a associative array.');

        if (!$this->isAssociativeArray($where)) throw new InvalidArgumentException('The where must be a associative array.');

        $values = array_merge(array_values($data), array_values($where));

        $columns = implode(', ', $this->mapPlaceholderMark(array_keys($data)));
        $where = implode(' AND ', $this->mapPlaceholderMark(array_keys($where)));

        $query = "UPDATE {$table} SET {$columns} WHERE {$where}";
        return $this->prepareExecute($query, $values);
    }

    protected function delete(string $table, array $where = [])
    {
        $values = array_values($where);

        if (0 == count($where)) throw new InvalidArgumentException('The where must have at least 1 items.');
        if (!$this->isAssociativeArray($where)) throw new InvalidArgumentException('The where must be a associative array.');

        $where = implode(' AND ', $this->mapPlaceholderMark(array_keys($where)));

        $query = "DELETE FROM {$table} WHERE {$where}";
        return $this->prepareExecute($query, $values);
    }
}
