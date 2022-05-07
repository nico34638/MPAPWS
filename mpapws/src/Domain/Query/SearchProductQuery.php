<?php


namespace App\Domain\Query;


/**
 * Class SearchProductQuery
 * @package App\Domain\Query
 */
class SearchProductQuery
{
    /**
     * SearchProductQuery constructor.
     * @param string $keyWord
     */
    public function __construct(private string $keyWord)
    {
    }

    public function getKeyWord(): string
    {
        return $this->keyWord;
    }

    public function setKeyWord(string $keyWord): void
    {
        $this->keyWord = $keyWord;
    }




}