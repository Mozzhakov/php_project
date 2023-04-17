<!-- variables -->
<!-- fn getAll -->
<!--  -->
<!--  -->
<!--  -->
<!--  -->

<?php

class Article
{
    public $id;
    public $title;
    public $content;
    public $published_at;

    public static function getAll($conn)
    {
        $sql = "SELECT *
                FROM my_first_db.test_table
                ORDER BY id;";

        $results = $conn->query($sql);

        return $results->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getArticleByID($conn, $id)
    {
        $sql = "SELECT *
                FROM my_first_db.test_table
                WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Article');
        if ($stmt->execute()) {
            return $stmt->fetch();
        }
    }
    public function updateArticle($conn)
    {
        /** 1.пишем скьюл
         * 2. готовим запрос через соединение
         * 3. байндим каджый элемент
         * 4. если дата не задана, то байндим ноль 
         * 5. возвращаем эезекьют
         */

        $sql = "UPDATE my_first_db.test_table
                SET title = :title,
                     content = :content,
                     published_at = :published_at
                WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':id', $this->id, PDO::PARAM_INT);
        $stmt->bindValue(':title', $this->title, PDO::PARAM_STR);
        $stmt->bindValue(':content', $this->content, PDO::PARAM_STR);

        if ($this->published_at === '') {
            $stmt->bindValue(':published_at', null, PDO::PARAM_NULL);
        } else {
            $stmt->bindValue(':published_at', $this->published_at, PDO::PARAM_STR);
        }
        return $stmt->execute();
    }
    public function addArticle($conn)
    {
        $sql = "INSERT INTO my_first_db.test_table (title, content, published_at)
                VALUES (:title, :content, :published_at)";
        $stmt = $conn->prepare($sql);

        $stmt->bindValue(':title', $this->title, PDO::PARAM_STR);
        $stmt->bindValue(':content', $this->content, PDO::PARAM_STR);

        if ($this->published_at === '') {
            $stmt->bindValue(':published_at', null, PDO::PARAM_NULL);
        } else {
            $stmt->bindValue(':published_at', $this->published_at, PDO::PARAM_STR);
        }
        if ($stmt->execute()) {
            $this->id = $conn->lastInsertId();
            return true;
        }
    }
}
