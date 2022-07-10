<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\Exceptions\BadRequestException;
use Framework\Request;
use BestSupplier\Analyzer;
use App\Models\Articles;

class Supplier
{
    /**
     * Retrieves best supplier for the given ser of articles
     *
     * @param \Framework\Request $request
     *
     * @return string
     */
    public function getBestSupplier(Request $request): string
    {
        $articles = $request->input('articles');

        /**
         * Validations and articles' name extraction to perform the
         * filter over the stored set of data
         */
        if (empty($articles) || !is_array($articles)) {
            throw new BadRequestException('Missing required parameter `articles` array');
        }

        $names = array_map(function ($item)
        {
            if (empty($item['name'])) {
                throw new BadRequestException('Missing required key `name` in the `articles` array');
            }

            if (empty($item['quantity'])) {
                throw new BadRequestException('Missing required key `quantity` in the `articles` array');
            }

            return strtolower($item['name']);
        }, $articles);

        $prices = (new Articles())->findByName($names);

        /**
         * The following section resembles what would be the
         * implementation/usage of the desired code to re-use,
         * which, in this case, has been implemented using its
         * namespaces, but in other implementations could be
         * added to the application/project as a package via a
         * package/dependency manager such as composer
         *
         * It's input must be two arrays with the following structure
         *
         * $articles = [
         *     ['name' => 'article 1', 'quantity' => 1]
         * ]
         *
         * $prices = [
         *     [
         *         'article' => 'article 1',
         *         'supplier' => 'supplier 1',
         *         'quantity' => 1,
         *         'price' => 5
         *     ]
         * ]
         *
         * It's output is an object that might have one of the following structures
         *
         * Error:
         * $analysis: {
         *     message: string
         * }
         *
         * Success:
         * $analysis: {
         *     result: {
         *         supplier: name,
         *         total: 25.00
         *     }
         * }
         */
        $analysis = (new Analyzer($articles, $prices))->run();

        /**
         * The package API performs the comparison and returns the
         * result as an object usable on any other context so the
         * result treatment, or message to return, should be separately
         * implemented based on each application/project
         */
        return isset($analysis->result) ?
            $analysis->result->supplier . ' is cheaper - ' . number_format($analysis->result->total, 2) . ' EUR' :
            $analysis->message;
    }
}
