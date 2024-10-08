<?php 
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/errorDisplay.php';

    $redirectPath = '/veikals/admin/index.php';

    function deleteFunc ($data) {
        $id = $data['id'];

        include $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/orders/data.php';

        try {
            $conn = Database::openConnection();
    
            $stmt = $conn->prepare(
                "SELECT * FROM purchased_goods WHERE product_id=:product_id"
            );
            $stmt->bindParam(':product_id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($rows as $row) {
                $purchGoodsData['id'] = $row['purch_goods_id'];
                CRUDFunctions::deleteAndDELETE($purchGoodsData);
            }
    
            Database::closeConnection($conn);
        } catch (PDOException $exception) {
            echo "PDO Exception: " . $exception->getMessage();
            echo "Error Code: " . $exception->getCode();
        }
    }
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/CRUD/deletePage.php';
?>
