<?php

namespace App\Models\Traits;

use Illuminate\Support\Str;

trait HasUuids
{
    /**
     * Initialize the trait.
     *
     * @return void
     */
    public function initializeHasUuids()
    {
        foreach ($this->uniqueIds() as $column) {
            if (empty($this->{$column})) {
                $this->{$column} = $this->newUniqueId();
            }
        }
    }

    /**
     * Get the columns that should receive a unique identifier.
     *
     * @return array[string]
     */
    public function uniqueIds(): array
    {
        return ['uuid'];
    }

    /**
     * Generate a new UUID for the model.
     *
     * @return string
     */
    public function newUniqueId(): string
    {
        return (string) Str::orderedUuid();
    }

    
}