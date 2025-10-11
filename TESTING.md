## PHPUnit
### Get started
1. install
    ```bash
    composer require phpunit/phpunit
    ```
2. create the 'tests' folder in the root directory and repeat project tree
3. composer.json
    ```json
    {
      "autoload-dev": {
        "psr-4": {
            "Tests\\": "tests/"
        }
      } 
    }
    ```
4. create in tests directory, the test class
5. create the settings file "phpunit.xml" in the root directory
6. phpunit.xml
    - displayDetailsOnTestsThatTriggerDeprecations
    - displayDetailsOnPhpunitDeprecations
    ```xml
     <phpunit
        bootstrap="tests\bootstrap.php"
        displayDetailsOnTestsThatTriggerDeprecations="true"
        displayDetailsOnPhpunitDeprecations="true"
        colors= "true"
        backupGlobals="false"
        stopOnFailure="false"
     >
   
        <testsuites>
            <testsuite name="unit">
                <directory>tests</directory>
            </testsuite>
        </testsuites>
     </phpunit> 
    ```
7. ExampleTest.php
    ```php
    class FunctionsTest extends TestCase {}
    ```
8. start test
    ```bash
    vendor/bin/phpunit tests
    ```