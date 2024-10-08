
<?php
    class Database {
        public static function openConnection() {
            try {
                require_once 'Config.php';

                $dbHost = Config::getValue('config', 'database', 'db_host');
                $dbName = Config::getValue('config', 'database', 'db_name');
                $dbUsername = Config::getValue('config', 'database', 'db_username');
                $dbPassword = Config::getValue('config', 'database', 'db_password');

                $con = new PDO(
                    "mysql:host=".$dbHost.";"."dbname=".$dbName,
                    $dbUsername, 
                    $dbPassword
                );
                $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                return $con;
            } catch (PDOException $exception) {
                echo "PDO Exception: " . $exception->getMessage();
                echo "Error Code: " . $exception->getCode();
            }
            return null;
        }
        public static function closeConnection ($con) {
            $con = null;
        }
        public static function getRowFrom ($tableName, $colName, $var, $varType) {
            $result = null;
            try {
                $conn = Database::openConnection();

                $stmt = $conn->prepare("SELECT * FROM $tableName WHERE $colName=:id");
                $stmt->bindParam(':id', $var, $varType);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
                Database::closeConnection($conn);
            } catch (PDOException $exception) {
                echo "PDO Exception: " . $exception->getMessage();
                echo "Error Code: " . $exception->getCode();
            }
            return $result;
        }
        public static function getRowWithID ($tableName, $colName, $id) {
            return Database::getRowFrom($tableName, $colName, $id, PDO::PARAM_INT);
        }
        public static function getAllRowsFrom ($tableName) {
            $result = null;
            try {
                $conn = Database::openConnection();

                
                
                $stmt = $conn->prepare("SELECT * FROM $tableName");
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                Database::closeConnection($conn);
            } catch (PDOException $exception) {
                echo "PDO Exception: " . $exception->getMessage();
                echo "Error Code: " . $exception->getCode();
            }
            return $result;
        }
        public static function insert ($tableName, $formData) {
            $id = null;
            try {
                $keys = array_keys($formData);
                $keysString = implode(', ', $keys);
                $valuesString = ':'.implode(', :', $keys);
    
                $conn = Database::openConnection();
    
                    $stmt = $conn->prepare("INSERT INTO $tableName ($keysString) VALUES ($valuesString)");
                    foreach ($formData as $key => &$var) {
                        $value = &$var['value'];
                        $stmt->bindParam(':'.$key, $var['value'], $var['db-var-type']);
                    }
                    $stmt->execute();

                $id = $conn->lastInsertId();
    
                Database::closeConnection($conn);
            } catch (PDOException $exception) {
                echo "PDO Exception: " . $exception->getMessage();
                echo "Error Code: " . $exception->getCode();
            }
            return $id;
        }
        public static function deleteWithID ($tableName, $idColumnName, $id) {
            try {
                $conn = Database::openConnection();

                $stmt = $conn->prepare("DELETE FROM $tableName WHERE $idColumnName = :id");
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                $stmt->execute();

                Database::closeConnection($conn);
            } catch (PDOException $exception) {
                echo "PDO Exception: " . $exception->getMessage();
                echo "Error Code: " . $exception->getCode();
            }
        }
        public static function update ($tableName, $idColumnName, $id, $formData) {
            $success = false;
            try {
                $keys = array_keys($formData);
                foreach ($keys as &$key)
                    $key = $key.' = :'.$key;
                $setString = implode(', ', $keys);

                $conn = Database::openConnection();

                    $stmt = $conn->prepare("UPDATE $tableName SET $setString WHERE $idColumnName = :id");
                    foreach ($formData as $key => &$var) {
                        $value = &$var['value'];
                        $stmt->bindParam(':'.$key, $value, $var['db-var-type']);
                    }
                    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                    $stmt->execute();

                Database::closeConnection($conn);
                $success = true;
            } catch (PDOException $exception) {
                echo "PDO Exception: " . $exception->getMessage();
                echo "Error Code: " . $exception->getCode();
            }
            return $success;
        }
    }
?>