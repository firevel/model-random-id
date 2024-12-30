# Model Random ID Generator for Laravel

A package for generating random `BIGINT` IDs as primary keys in Laravel models. These IDs are compatible with MySQL `BIGINT` columns and JavaScript's `MAX_SAFE_INTEGER`.

### Purpose

Systems using distributed databases like [Cloud Spanner](https://cloud.google.com/spanner) or [Firestore](https://cloud.google.com/firestore) shouldn't use incremental id's to avoid bottlenecks. [UUID](https://en.wikipedia.org/wiki/Universally_unique_identifier) can be used as an alternative but long strings can cause performance issues and UX issues. Random BIGINT is a middle ground between incremental id and UUID.

## Installation

Install the package via Composer:

```bash
composer require firevel/model-random-id
```

## Usage

### Database Setup

Ensure your database table uses a `BIGINT` primary key. For example:

```php
$table->bigInteger('id')->unsigned()->primary();
```

### Model Setup

Add the trait to your model:
```php
use \Firevel\ModelRandomId\HasRandomId;
```

Disable auto-incrementing for the primary key:
```php
/**
 * Indicates if the IDs are auto-incrementing.
 *
 * @var bool
 */
public $incrementing = false;
```

## Limitations

While random number generation reduces the risk of ID collisions, it is not entirely immune to conflicts. The more IDs you generate, the higher the chance of a collision due to the Birthday Paradox—where random sampling within a finite range (in this case, BIGINT) increases the likelihood of overlap as the number of samples grows. For use cases involving millions of rows or extremely high throughput, consider pre-generating a list of unique IDs and distributing them to avoid runtime conflicts. This approach ensures scalability while preserving randomness.


