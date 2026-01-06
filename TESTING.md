## PHPUnit

### Get started

1. install
    ```bash
    composer require phpunit/phpunit
    ```
2. Create the 'tests' folder in the root directory and repeat project tree add to 'tests' bootstrap.php:
3. Update composer.json:
    ```json
    {
      "autoload-dev": {
        "psr-4": {
            "Tests\\": "tests/"
        }
      } 
    }
    ```

4. Create the settings file "phpunit.xml" in the root directory:

    ```xml
    <phpunit
        xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
        xsi:noNamespaceSchemaLocation="https://schema.phpunit.de/10.5/phpunit.xsd"
        bootstrap="tests/bootstrap.php"
        backupGlobals="true"
        displayDetailsOnTestsThatTriggerDeprecations="true"
        displayDetailsOnTestsThatTriggerWarnings="true"
        displayDetailsOnTestsThatTriggerNotices="true"
        displayDetailsOnTestsThatTriggerErrors="true"
        displayDetailsOnPhpunitDeprecations="true"
        colors="true"
        cacheDirectory="tests/info"
    >
   
        <testsuites>
            <testsuite name="unit">
                <directory>tests/unit</directory>
            </testsuite>
            <testsuite name="integration">
                <directory>tests/integration</directory>
            </testsuite>
        </testsuites>
   
        <source>
            <include>
                <directory>src</directory>
            </include>
            <exclude>
                <directory>vendor</directory>
                <directory>coverage</directory>
                <directory>tests</directory>
            </exclude>
        </source>
   
        <coverage>
            <report>
                <clover outputFile="tests/info/coverage.xml"/>
                <html outputDirectory="tests/info/coverage"/>
                <text outputFile="php://stdout"/>
            </report>
        </coverage>
   
        <logging>
            <junit outputFile="tests/info/log/junit.xml"/>
        </logging>
    </phpunit>
    ```

5. For working coverage you need to enable coverage mode in the PHP:
    ```php.ini
    xdebug.mode=debug,coverage
    ```

6. ExampleTest.php
    ```php
    class FunctionsTest extends TestCase {}
    ```

7. Start tests:
    ```bash
    vendor/bin/phpunit [tests]
    ```

8. Setting configuration for tests run in IDE:
9. Turn on "Toggle Auto-Test" in the
