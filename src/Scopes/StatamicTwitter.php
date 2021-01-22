<?php

namespace Pixney\StatamicTwitter\Scopes;

use Statamic\Query\Scopes\Scope;

class StatamicTwitter extends Scope
{
    /**
     * Apply the scope.
     *
     * @param \Statamic\Query\Builder $query
     * @param array $values
     * @return void
     */
    public function apply($query, $values)
    {
        // $query->where('featured', true);
    }
}
