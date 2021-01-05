<?php


namespace App\Domain\Query;


/**
 * Class SearchProductQuery
 * @package App\Domain\Query
 */
class SearchProductQuery
{
    /**
     * @var string
     */
    private string $keyWord;

    /**
     * SearchProductQuery constructor.
     * @param string $keyWord
     */
    public function __construct(string $keyWord)
    {
        $this->keyWord = $keyWord;
    }

    /**
     * @return string
     */
    public function getKeyWord(): string
    {
        return $this->keyWord;
    }

    /**
     * @param string $keyWord
     */
    public function setKeyWord(string $keyWord): void
    {
        $this->keyWord = $keyWord;
    }




}