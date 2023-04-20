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
    public $errors = [];

    public static function getAll($conn)
    {
        $sql = "SELECT *
                FROM my_first_db.test_table
                ORDER BY id;";

        $results = $conn->query($sql);

        return $results->fetchAll(PDO::FETCH_ASSOC);
    }
    public static function getAllPublished($conn)
    {
        $sql = "SELECT *
                FROM my_first_db.test_table
                WHERE published_at IS NOT NULL
                ORDER BY id";

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
    public static function getArticleWithCategories($conn, $id)
    {
        $sql = "SELECT test_table.*, category.name AS category_name
                FROM my_first_db.test_table
                LEFT JOIN my_first_db.article_category
                ON test_table.id = article_category.article_id
                LEFT JOIN my_first_db.category
                ON article_category.category_id = category.id
                WHERE test_table.id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getCategories($conn)
    {
        $sql = "SELECT category.* 
                FROM my_first_db.category
                JOIN my_first_db.article_category
                ON category.id = article_category.category_id
                WHERE article_id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':id', $this->id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function setCategories($conn, $ids)
    {
        if ($ids) {
            $sql = "INSERT IGNORE INTO my_first_db.article_category (article_id, category_id)
                    VALUES ";
            $values = [];
            foreach ($ids as $id) {
                $values[] = "({$this->id}, ?)";
            }
            $sql .= implode(", ", $values);

            $stmt = $conn->prepare($sql);
            foreach ($ids as $i => $id) {
                $stmt->bindValue($i + 1, $id, PDO::PARAM_INT);
            }
            $stmt->execute();
        }
        $sql = "DELETE FROM my_first_db.article_category
                WHERE article_id = {$this->id}";
        if ($ids) {
            $placeholders = array_fill(0, count($ids), '?');
            $sql .= " AND category_id NOT IN (" . implode(", ", $placeholders) . ")";
        }
        $stmt = $conn->prepare($sql);
        foreach ($ids as $i => $id) {
            $stmt->bindValue($i + 1, $id, PDO::PARAM_INT);
        }
        $stmt->execute();
    }
    public function updateArticle($conn)
    {
        if ($this->validate()) {
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
        return false;
    }
    public function addArticle($conn)
    {
        if ($this->validate()) {
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
        return false;
    }
    public function deleteArticle($conn)
    {
        $sql = "DELETE
                FROM my_first_db.test_table
                WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':id', $this->id, PDO::PARAM_INT);
        return $stmt->execute();
    }
    protected function validate()
    {
        if ($this->title === "") {
            $this->errors[] = 'Title is reqiured';
        }
        if ($this->content === "") {
            $this->errors[] = 'Content is reqiured';
        }
        return empty($this->errors);
    }
    public function publish($conn)
    {
        $sql = "UPDATE my_first_db.test_table
                SET published_at = :published_at
                WHERE id = :id";
        $stmt = $conn->prepare($sql);

        $stmt->bindValue(':id', $this->id, PDO::PARAM_INT);
        $published_at = date("Y-m-d H:i:s");
        $stmt->bindValue(':published_at', $published_at, PDO::PARAM_STR);

        if ($stmt->execute()) {
            return $published_at;
        }
    }
}