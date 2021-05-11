# Model random ID generator.

This package automatically generate primary id using cryptographic random integers that fit MySQL `BIGINT` column and JavaScript `MAX_SAFE_INTEGER`.

### Purpose

Systems using distributed databases like [Cloud Spanner](https://cloud.google.com/spanner) or [Firestore](https://cloud.google.com/firestore) shouldn't use incremental id's to avoid bottlenecks. (UUID)[https://en.wikipedia.org/wiki/Universally_unique_identifier] can be used as alternative but long strings can cause performance issues, and UX issues. Random BIGINT is a middle ground between incremental id and UUID.

## Installation

Make sure your model id is a BIGINT for example: `$table->bigInteger('id')->primary();`.


Add to your model trait `use \Firevel\ModelRandomId\HasRandomId;` and
```
    /**
     * Primary key incrementing.
     *
     * @var bool
     */
    public $incrementing = false;
```

