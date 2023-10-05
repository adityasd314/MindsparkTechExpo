<?php
require "config.php";
class myConn
{
    protected static $user = X_u;
    protected static $password = X_p;
    public static $database = X_dm;
    protected static $host = "localhost";
    protected static $host2 = X_h;
    protected static $conn = "";
    public static function connect($key)
    {
        if (password_verify($key, '$2y$10$1uGjZkZ2FyBGiFg.nIENeeLoMXGzDmKjRqhwf9DhRSLI8ngAvVuIi') == 1) {
            try {
                $user = self::$user;
                $pass = self::$password;
                $conn = self::$conn;
                $host = self::$host2;
                $db = self::$database;
                $conn = new PDO($host . ";dbname=" . $db, $user, $pass);

                return $conn;
            } catch (PDOException $e) {
                //echo "Error : " . $e->getMessage();
            }
        } else {
            echo "Access Denied";
        }
    }

    public static function truncate($key, $tableName)
    {
        $conn = self::connect($key);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = "TRUNCATE TABLE `$tableName`";
        $conn->exec($query);
        $conn = null;
    }
    public static function deleteRow($key, $tableName, $where = "")
    {
        try {
            $conn = self::connect($key);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query = "DELETE FROM $tableName " . (($where == "") ? "" : " where $where");
            $conn->exec($query);
            $conn = null;
        } catch (PDOException $e) {
            // echo "<br>Error : " . $e->getMessage();
        }
    }
    public static function updateData($key, $tableName, $column_name, $value, $where)
    {
        try {
            $conn = self::connect($key);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $type = gettype($column_name);
            $query = "UPDATE $tableName SET $column_name=" . (($type == 'string') ? "'$value'" : $value) . " where $where";
            $conn->exec($query);
            $conn = null;
        } catch (PDOException $e) {
            // echo "<br>Error : " . $e->getMessage();
        }
    }
    public static function describeTable($key, $tableName, $align = "center")
    {
        try {
            $conn = myConn::connect($key);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo $tableName;
            $query = "DESC $tableName";
            $result = $conn->query($query);
            $rows = $result->fetchAll();
            $row_count = count($rows);
            if ($row_count > 1) {
                echo "<$align><table border cellpadding=5 cellspacing=5>";
                foreach ($rows as $elm) {
                    $o = 0;
                    echo "<tr>";
                    foreach ($elm as $mel) {
                        if ($o % 2 == 0)
                            echo "<td>$mel</td>";
                        $o += 1;
                    }
                    echo "</tr>";
                }
                echo "</table></$align>";
                $conn = null;
            } else {
                echo " <center><p> Table has no rows  </p></center>";
            }
        } catch (PDOException $e) {
            // echo "<br>Error : " . $e->getMessage();
        }
    }
    public static function insertRow($key, $tableName, $cc, $values = [])
    {

        try {
            $conn = self::connect($key);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $value = "";
            for ($i = 0; $i < count($values); $i++) {
                $value .= "'" . $values[$i] . "'";
                if ($i != count($values) - 1) {
                    $value .= ",";
                }
            }

            $query = "INSERT INTO $tableName($cc) VALUES($value)";
            $conn->exec($query);
            $conn = null;
        } catch (PDOException $e) {
            //echo "Error : " . $e->getMessage();
        }
    }
    public static function showTable($key, $data_key, $database = null)
    {
        try {
            $database = ($database == null) ? "aditya_sql" : $database;
            self::$database = $database;
            $conn = self::connect($key) or die();
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            if (password_verify($data_key, '$2y$10$bJ4S2ei7WUNmvfBjBmSAZOMnhcoNYiYYrnCNPrHaLGgFg8NdJeZQS')) {
                $query = "show tables";
                $result = $conn->query($query)
                    or die();
                $rows = $result->fetchAll()
                    or die();
                echo "<table border>";
                foreach ($rows as $table) {
                    echo "<tr><td>'Database = $database</td><td>";
                    echo ($table['Tables_in_' . $database]);
                    echo "</td></tr>";
                }
                echo "</table>";
            }
        } catch (PDOException $e) {
            //echo "Error : " . $e->getMessage();
        }
    }
    public static function getData($key, $table)
    {
        try {
            $conn = myConn::connect($key);
            $query = "SELECT * FROM $table";
            $stmt = $conn->query($query);
            $stmt->setFetchMode(PDO::FETCH_NUM);
            $result = $stmt->fetchAll();
            return $result;
        } catch (PDOException $e) {
            // throw $e;
        }
    }
    public static function getDataByColumns($key, $table, $columns)
    {
        try {
            $column_str = "";
            foreach ($columns as $column) {
                $column_str .= "`$column`, ";

            }
            $column_str = (substr($column_str, 0, strlen($column_str) - 2));
            $conn = myConn::connect($key);
            $query = "SELECT $column_str FROM $table";

            $stmt = $conn->query($query);
            $stmt->setFetchMode(PDO::FETCH_NUM);
            $result = $stmt->fetchAll();
            return $result;
        } catch (PDOException $e) {
            // throw $e;
        }
    }
    public static function validate($e)
    {
        $validator_regex = "/[\"']/";
        return (preg_match($validator_regex, $e)) ? false : true;
    }
    public static function validateAll(...$e)
    {
        foreach ($e as $v) {
            if (!myConn::validate($v))
                return false;
        }
        return true;
    }
}