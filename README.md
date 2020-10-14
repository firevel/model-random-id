# Model random ID generator.

Automatically generate cryptographic random integers that fits mysql BIGINT column and JavaScript MAX_SAFE_INTEGER.

## Installation

Make sure your model id is a BIGINT for example: `$table->bigInteger('id')->primary();`.


Add to your model `use Firevel\ModelRandomId\HasRandomId;` and 
```
    /**
     * Primary key incrementing.
     *
     * @var bool
     */
    public $incrementing = false;
```
