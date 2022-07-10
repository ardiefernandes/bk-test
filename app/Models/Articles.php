<?php

declare(strict_types=1);

namespace App\Models;

use Framework\Model;

class Articles extends Model
{
    /**
     * Finds articles by name
     *
     * @param string|array $names
     *
     * @return array
     */
    public function findByName($names): array
    {
        if (is_string($names)) {
            $names = [$names];
        }

        /**
         * The following section resembles DB processing by applying
         * the proper filter on a query execution and returns the array
         * after of results obtainable after joining the corresponding
         * tables
         *
         * This section could have a different implementation based on
         * the framework or application structure where is run
         */
        $result = [];

        foreach ($this->data->suppliers as $supplier) {
            foreach ($supplier->articles as $article) {
                if (in_array(strtolower($article->name), $names)) {
                    array_map(
                        function ($price) use (
                            $supplier,
                            $article,
                            &$result
                        ) {
                            $result[] = array_merge(
                                [
                                    'supplier' => $supplier->name,
                                    'article'  => $article->name,
                                ],
                                $price
                            );
                        },
                        $article->prices
                    );
                }
            }
        }

        return $result;
    }
}
