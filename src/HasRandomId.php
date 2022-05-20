<?php

namespace Firevel\ModelRandomId;

trait HasRandomId
{
    /**
     * Minimum value used for random id.
     * 
     * This particular number is `10000000000` after base conversion from 36 [0-9][a-z] to 10.
     * 
     * Used to have minimum 11 chars representation of resource.
     * 
     * @var integer
     */
    public $minimumRandomId = 3656158440062976;

    /**
     * Maximum value used for random id.
     *
     * This number represents the maximum safe integer in JavaScript (MAX_SAFE_INTEGER).
     * 
     * @var integer
     */
    public $maximumRandomId = 9007199254740991;

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    public static function bootHasRandomId(): void
    {
        static::saving(function ($model) {
            if (empty($model->{$model->getRandomIdKeyName()})) {
                $model->generateRandomId();
            }
        });
    }

    /**
     * Get column name with random key.
     *
     * @return string
     */
    public function getRandomIdKeyName() {
        if (!empty($this->randomIdKeyName)) {
            return $this->randomIdKeyName;
        }

        return $this->getKeyName();
    }

    /**
     * Generate random id.
     *
     * @return self
     */
    public function generateRandomId()
    {
        $this->{$this->getRandomIdKeyName()} = $this->generateRandomInteger();

        return $this;
    }

    /**
     * Generate random integer.
     *
     * @return int
     */
    protected function generateRandomInteger(): int
    {
        return random_int($this->minimumRandomId, $this->maximumRandomId);
    }
}