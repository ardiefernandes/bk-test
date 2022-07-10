<?php

declare(strict_types=1);

namespace BestSupplier;

class Analyzer
{
    /**
     * Array of requested articles and quantity
     *
     * @var array
     */
    private $articles;

    /**
     * Prices data organized by article and supplier
     *
     * @var null|array
     */
    private $prices;

    /**
     * Analysis results
     *
     * @var array
     */
    private $analysis;

    /**
     * Instances constructor
     *
     * @param array $articles
     * @param array $prices
     */
    public function __construct(array $articles, array $prices)
    {
        $this->analysis = [];
        $this->articles = $articles;
        $this->prices   = $this->sortAndOrganizePrices($prices);
    }

    /**
     * Performs the best supplier comparison
     *
     * @return \stdClass
     */
    public function run(): \stdClass
    {
        if (empty($this->prices)) {
            return (object) [
                'message' => 'Unable to perform any comparison, ' .
                             'no entries found for the requested articles',
            ];
        }

        if (sizeof($this->prices) !== sizeof($this->articles)) {
            return (object) [
                'message' => 'Unable to perform any comparison, missing requested ' .
                             'articles for the registered suppliers',
            ];
        }

        foreach ($this->articles as $article) {
            $this->analyze($article);
        }

        return $this->decide();
    }

    /**
     * Performs analysis for the requested articles and calculates the
     * total amount for each supplier based on the requested articles
     * list and quantities
     *
     * @param array $article
     *
     * @return void
     */
    private function analyze(array $article): void
    {
        $idx_article = $this->nameIndex($article['name']);

        foreach ($this->prices[$idx_article]->suppliers as $idx_supplier => $supplier) {
            $quantity = (float) $article['quantity'];

            foreach ($supplier->prices as $row) {
                $row_quantity = (float) $row['quantity'];
                $row_price    = (float) $row['price'];
                $units        = floor($quantity / $row_quantity);

                if ($units >= 1) {
                    if (!array_key_exists($idx_supplier, $this->analysis)) {
                        $this->analysis[$idx_supplier] = [
                            'supplier' => $supplier->name,
                            'total'    => 0.00,
                        ];
                    }

                    $this->analysis[$idx_supplier]['total'] += $units * $row_price;
                    $quantity -= $row_quantity * $units;
                }
            }
        }
    }

    /**
     * Decides which supplier is cheaper by organizing the analysis
     * result by total amount on ascending order
     *
     * @return \stdClass
     */
    private function decide(): \stdClass
    {
        /**
         * Sorts by total ASC to place on top the cheaper supplier
         */
        $column = array_column($this->analysis, 'total');

        array_multisort($column, SORT_ASC, $this->analysis);

        return (object) [
            'result' => (object) array_shift($this->analysis),
        ];
    }

    /**
     * Sorts and organizes the prices by separating them in a multidimenssional
     * array based on the article and supplier as upper levels
     *
     * @param array $data
     *
     * @return null|array
     */
    private function sortAndOrganizePrices(array $data): ?array
    {
        if (empty($data)) {
            return null;
        }

        /**
         * Sorts by article ASC, supplier ASC and quantity DESC
         * the prices array
         *
         * This supposes that data might not be properly ordered
         * before running the supplier comparison analysis
         */
        $article  = array_column($data, 'article');
        $supplier = array_column($data, 'supplier');
        $quantity = array_column($data, 'quantity');

        array_multisort(
            $article,
            SORT_ASC,
            $supplier,
            SORT_ASC,
            $quantity,
            SORT_DESC,
            $data
        );

        $prices = $this->organizePrices($data);

        return $this->clearSuppliersMissingArticles($prices);
    }

    /**
     * Separates and organized the prices array in a multidimenssional
     * array based on the article and supplier as upper levels
     *
     * @param array $data
     *
     * @return array
     */
    private function organizePrices(array $data): array
    {
        $prices = [];

        foreach ($data as $row) {
            $idx_article = $this->nameIndex($row['article']);

            if (!isset($prices[$idx_article])) {
                $prices[$idx_article] = (object) [
                    'name'      => $row['article'],
                    'suppliers' => [],
                ];
            }

            $article      = &$prices[$idx_article];
            $idx_supplier = $this->nameIndex($row['supplier']);

            if (!array_key_exists($idx_supplier, $article->suppliers)) {
                $article->suppliers[$idx_supplier] = (object) [
                    'name'   => $row['supplier'],
                    'prices' => [],
                ];
            }

            $article->suppliers[$idx_supplier]->prices[] = [
                'quantity' => $row['quantity'],
                'price'    => $row['price'],
            ];

            unset($article);
        }

        return $prices;
    }

    /**
     * Removes the suppliers with missing articles from the prices
     * data in order to not be included in the coparison
     *
     * @param array $prices
     *
     * @return array
     */
    public function clearSuppliersMissingArticles(array $prices): array
    {
        if (sizeof($prices) === 1) {
            return $prices;
        }

        /**
         * These suppliers are removed in order to not
         * execute the comparison with missing articles
         * for some suppliers, which might give a cheaper
         * value based on missing information
         */
        $args = [];

        foreach ($prices as $article) {
            $args[] = array_keys($article->suppliers);
        }

        $diff = call_user_func_array('array_diff', $args);

        if (sizeof($diff) !== 0) {
            $diff = array_flip($diff);

            foreach ($prices as &$article) {
                $article->suppliers = array_diff_key($article->suppliers, $diff);
                unset($article);
            }
        }

        return $prices;
    }

    /**
     * Returns a non-special characters string from a given string
     * to be used as array index
     *
     * @param string $str
     *
     * @return string
     */
    private function nameIndex(string $str): string
    {
        return strtolower(
            preg_replace(
                ['/\s/', '/[^A-Za-z0-9\-_]/'],
                ['_', ''],
                $str
            )
        );
    }
}
