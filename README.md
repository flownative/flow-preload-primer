[![MIT license](http://img.shields.io/badge/license-MIT-brightgreen.svg)](http://opensource.org/licenses/MIT)

# PHP Preload Primer 

This [Flow](https://flow.neos.io) package is an experiment to generate
preloading information and preload classes for PHP's opcache.

## How does it work?

tldr;

- `touch Configuration/Development/Beach/Instance/PreloadingFiles.on`
- request a few URLs via the browser
- find `Configuration/Development/Beach/Instance/PreloadingFiles.json`
  inside the container, move it to the same directory outside the
  container, so you can add it to Git
- remove `Configuration/Development/Beach/Instance/PreloadingFiles.on`
- deploy the site with PHP's opcache script pointing to
  `/application/Packages/Application/Flownative.PreloadPrimer/Scripts/preload.php`

## Compatibility

…

## Installation

The Preloading Primer plugin is installed as a regular Flow package via
Composer. For your existing project, simply include
`flownative/preload-primer` into the dependencies of your Flow or Neos
distribution:

```bash
$ composer require flownative/preload-primer
```
