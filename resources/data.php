<?php

declare(strict_types=1);

/**
 * The following section resembles the DB structure of data
 *
 * This section could have a different structure based on
 * application structure where is run
 */
return (object) [
    'suppliers' => [
        (object) [
            'name'     => 'Supplier A',
            'articles' => [
                (object) [
                    'name'   => 'Dental Floss',
                    'prices' => [
                        [
                            'quantity' => 1,
                            'price'    => 9.00,
                        ],
                        [
                            'quantity' => 20,
                            'price'    => 160.00,
                        ],
                    ],
                ],
                (object) [
                    'name'   => 'Ibuprofen',
                    'prices' => [
                        [
                            'quantity' => 1,
                            'price'    => 5.00,
                        ],
                        [
                            'quantity' => 10,
                            'price'    => 48.00,
                        ],
                    ],
                ],
            ],
        ],
        (object) [
            'name'     => 'Supplier B',
            'articles' => [
                (object) [
                    'name'   => 'Dental Floss',
                    'prices' => [
                        [
                            'quantity' => 1,
                            'price'    => 8.00,
                        ],
                        [
                            'quantity' => 10,
                            'price'    => 71.00,
                        ],
                    ],
                ],
                (object) [
                    'name'   => 'Ibuprofen',
                    'prices' => [
                        [
                            'quantity' => 1,
                            'price'    => 6.00,
                        ],
                        [
                            'quantity' => 5,
                            'price'    => 25.00,
                        ],
                        [
                            'quantity' => 100,
                            'price'    => 410.00,
                        ],
                    ],
                ],
            ],
        ],
    ],
];
