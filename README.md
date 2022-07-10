# Backend Test Project

### Introduction
Full Backend Test Project built over a really basic framework structure made up by myself in order to prove the capability to re-use the implementation of the requested code which has been built up over the concept of an API/Package on behalf of reusability either by integrating it in any project/application as a dependency/package using any package manager such as Composer.

### Environment
Ubuntu 20.08 + Apache + PHP 8.0

### Code implementation
The source code, main objective of this implementation, has been made in the `package/Analyzer.php` file. This file holds most of the logic requested for this test project.

The rest of the implementation of this code, which involves the usage of this "package", is split between the `Supplier.php` controller and the `Articles.php` model.

### Request example
The application has one usable endpoint for the sake of this implementation:
```
GET /best-supplier

Body:
articles: [
    [
        name: "article 1",
        quantity: 5
    ],
    [
        name: "article 2",
        quantity: 10
    ]
]
```

The `articles` parameter is mandatory, such as the `name` and `quantity` indexes in every set of article

Based on the parameters, and the data stored in the `resources/data.php` file, the endpoint might return one of the following values:
- Success:
  - Comparison performed with success:
    Ex: `Supplier B is cheaper - 102 EUR`
  - When no supplier has the requested articles
    `Unable to perform any comparison, no entries found for the requested articles`
  - When not all the requested articles are found for the registered suppliers
    `Unable to perform any comparison, missing requested, articles for the registered suppliers`

- Errors:
  - Articles parameter is missing or empty
  `400 Bad Request - Missing required parameter 'articles' array`
  - Name key is missing in any of the articles set in the articles array
  `400 Bad Request - Missing required key 'name' in the 'articles' array`
  - Quantity key is missing in any of the articles set in the articles array
  `400 Bad Request - Missing required key 'quantity' in the 'articles' array`

### Final notes
- The construction of the made up framework was of my own choice to spend a bit of time on it just to simulate the package usage on a superficial and really basic PHP framework concept without having to pull a huge amount of dependencies such as the 70MB on Laravel, none of it had anything to do with the test itself or on what has been requested.
- The whole application is prepared to run just as is without having to install any package or run any command. The auto loader class list is updated to the latest change. If required, should be enough to run the command `composer dump-autoload`.
- The `vendor` folder contains no dependency, it is required only to use composer's class auto loader. During development it contained only the dependencies for code formatting, such as php-cs-fixer.
- Since the application was built in an environment with Apache, relies on the `.htaccess` configuration and redirecting rules to properly invoke the implemented endpoint. If ran in an environment not using Apache, or with "Rewrite module" for Apache disabled, the application might not run properly until equivalent changes are made.
