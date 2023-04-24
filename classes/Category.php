<?php

class Category
{
    public static function getAll($conn)
    {
        $sql = "SELECT *
                FROM my_first_db.category
                ORDER BY id;";

        $results = $conn->query($sql);

        return $results->fetchAll(PDO::FETCH_ASSOC);
    }
}