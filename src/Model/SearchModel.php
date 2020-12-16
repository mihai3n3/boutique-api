<?php

namespace App\Model;

class SearchModel
{
    /** @var int */
    private $totalPages;
    /** @var int */
    private $totalResults;
    /** @var int */
    private $currentPage;
    /** @var array */
    private $facets;
    /** @var array */
    private $products;
   
    public function getTotalPages(): int
    {
        return $this->totalPages;
    }

    public function setTotalPages(int $totalPages): self
    {
        $this->totalPages = $totalPages;
        return $this;
    }

    public function getTotalResults(): int
    {
        return $this->totalResults;
    }


    public function setTotalResults(int $totalResults): self
    {
        $this->totalResults = $totalResults;
        return $this;
    }


    public function getCurrentPage(): int
    {
        return $this->currentPage;
    }

    public function setCurrentPage(int $currentPage): self
    {
        $this->currentPage = $currentPage;
        return $this;
    }


    public function getFacets(): array
    {
        return $this->facets;
    }


    public function setFacets(array $facets): self
    {
        $this->facets = $facets;
        return $this;
    }


    public function getProducts(): array
    {
        return $this->products;
    }

    public function setProducts(array $products): self
    {
        $this->products = $products;
        return $this;
    }
}