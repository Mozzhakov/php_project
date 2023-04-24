<?php
class Paginator
{
    public $limit;
    public $offset;
    public $previousPage;
    public $nextPage;
    public $totalPages;
    public function __construct($page, $articlesPerPage, $totalAmountOfArticles)
    {
        $this->limit = $articlesPerPage;
        $page = filter_var($page, FILTER_VALIDATE_INT, [
            'options' => ['default' => 1, 'min_range' => 1]
        ]);
        $this->previousPage = $page - 1;
        $this->nextPage = $page + 1;
        $this->totalPages = ceil($totalAmountOfArticles / $articlesPerPage);
        $this->offset = $articlesPerPage * ($page - 1);
    }
}