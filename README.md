# Model Random ID

A Laravel trait that automatically assigns a cryptographically random integer as the primary key of an Eloquent model. Ids fit in a MySQL `BIGINT` column and stay within JavaScript's `Number.MAX_SAFE_INTEGER`, so they round-trip safely through JSON and JS clients.

## Why random BIGINT?

Distributed databases such as [Cloud Spanner](https://cloud.google.com/spanner) and [Firestore](https://cloud.google.com/firestore) suffer hotspots when ids are monotonically incrementing. [UUIDs](https://en.wikipedia.org/wiki/Universally_unique_identifier) avoid that problem but are long, hurt index locality, and look ugly in URLs. A random BIGINT is the middle ground — fixed-width, numeric, indexable, and collision-resistant within the 2^53 range.

## Installation

```bash
composer require firevel/model-random-id
```

## Usage

Make the primary key a BIGINT in your migration:

```php
Schema::create('posts', function (Blueprint $table) {
    $table->bigInteger('id')->primary();
    // ... other columns
});
```

Add the trait to your model:

```php
use Firevel\ModelRandomId\HasRandomId;

class Post extends Model
{
    use HasRandomId;
}
```

That's it. The trait disables auto-increment for you and assigns a random id on `saving` if the key column is empty.

```php
$post = Post::create(['title' => 'Hello']);
$post->id; // e.g. 7193428815320495
```

### Using a non-primary-key column

If you want to populate a column other than the primary key, set `$randomIdKeyName`:

```php
class Invite extends Model
{
    use HasRandomId;

    public $randomIdKeyName = 'token';
}
```

### Customizing the range

The trait exposes two properties you can override per-model:

| Property | Default | Meaning |
|---|---|---|
| `$minimumRandomId` | `3656158440062976` | Lower bound. Equals `"10000000000"` parsed as base-36, which guarantees every id is at least 11 characters when rendered in base-36. |
| `$maximumRandomId` | `9007199254740991` | Upper bound. Equals `Number.MAX_SAFE_INTEGER` (2^53 − 1) and fits in MySQL `BIGINT`. |

```php
class Order extends Model
{
    use HasRandomId;

    public $minimumRandomId = 1000000000;
    public $maximumRandomId = 9999999999;
}
```

You can also override `generateRandomInteger()` if you need a different generation strategy entirely.

## How it works

- `bootHasRandomId()` registers a `saving` listener so the id is assigned just before the row is written.
- `initializeHasRandomId()` runs on every model instance and sets `$incrementing = false`.
- `generateRandomInteger()` uses PHP's `random_int()`, which draws from the OS CSPRNG.

## License

MIT — see [LICENSE](LICENSE).
