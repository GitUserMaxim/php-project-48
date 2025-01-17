# Configuration File Comparator Utility
<p>This utility compares two configuration files and outputs the results in various formats.</p>

## Features

- **Support for Multiple Input Formats**: The utility can handle configuration files in both YAML(YML) and JSON formats.
- **Report Generation**: Generate comparison reports in various formats:
  - **Plain**: A straightforward text representation of the differences.
  - **Stylish**: A visually appealing format that highlights changes.
  - **JSON**: A structured output in JSON format for easy parsing.

## Minimum Requirements

- **Composer**: >= 2.2
- **PHP**: >= 8.1


## Installation
```bash
$ git clone https://github.com/GitUserMaxim/php-project-48

$ make install
```
## Usage Instructions
```
  gendiff (-h|--help)
  gendiff (-v|--version)
  gendiff [--format <fmt>] <firstFile> <secondFile>
``` 
Options:
```
  -h --help                     Show this screen
  -v --version                  Show version
  --format <fmt>                Report format [default: stylish]
```
Format options:

You can specify the output format using the `--format` option. The available formats are:
- stylish: A visually appealing format that highlights changes.
- plain: A straightforward text representation of the differences.
- json: A structured output in JSON format for easy parsing.

Example:
```
$ ./bin/gendiff tests/fixtures/file1.json tests/fixtures/file4.yaml --format json
```
### Actions Status
[![Actions Status](https://github.com/GitUserMaxim/php-project-48/actions/workflows/hexlet-check.yml/badge.svg)](https://github.com/GitUserMaxim/php-project-48/actions)

### Maintainability
[![Maintainability](https://api.codeclimate.com/v1/badges/c2346020c599a59665e0/maintainability)](https://codeclimate.com/github/GitUserMaxim/php-project-48/maintainability)

### Test Coverage
[![Test Coverage](https://api.codeclimate.com/v1/badges/c2346020c599a59665e0/test_coverage)](https://codeclimate.com/github/GitUserMaxim/php-project-48/test_coverage)

### PHP Linter and Tests
[![PHP Linter and Tests](https://github.com/GitUserMaxim/php-project-48/actions/workflows/test.yml/badge.svg)](https://github.com/GitUserMaxim/php-project-48/actions/workflows/test.yml)



Comparing two nested json files
```
$ ./bin/gendiff file1.json file2.json
```
[![asciicast](https://asciinema.org/a/ssTDmoBxIvI5EHP48L3xLdtVT.svg)](https://asciinema.org/a/ssTDmoBxIvI5EHP48L3xLdtVT)

Сomparison of different formats
```
./bin/gendiff tests/fixtures/file1.json tests/fixtures/file4.yaml --format json
```
[![asciicast](https://asciinema.org/a/698541.svg)](https://asciinema.org/a/698541)