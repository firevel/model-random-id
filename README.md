# Model random ID generator.

This package automatically generate primary id using cryptographic random integers that fit MySQL BIGINT column and JavaScript MAX_SAFE_INTEGER.

### Purpose

If you developing a system using distributed databases like (Cloud Spanner)[https://cloud.google.com/spanner] or (Firestore)[https://cloud.google.com/firestore] you shouldn't use incremental id's. You can use (UUID)[https://en.wikipedia.org/wiki/Universally_unique_identifier] as model identifier but using long strings can cause performance issues, and UX issues. Random BIGINT is a middle ground between incremental id and UUID.

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

