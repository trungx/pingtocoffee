<?php

namespace App\Traits;

trait Searchable
{
    /**
     * Scope a query to only include in array $searchableColumns
     *
     * @param $query
     * @param $needle
     */
    public function scopeSearch($query, $needle)
    {
        if (!$this->searchableColumns) {
            return;
        }

        $queryString = '';
        $counter = 1;
        $numberOfColumns = count($this->searchableColumns);
        foreach ($this->searchableColumns as $column) {
            if (is_array($column)) {
                // Build CONCAT query
                $column = 'CONCAT(' . implode(', " ", ', $column) . ')';
            }

            $queryString .= $column . ' LIKE \'%' . $needle . '%\'';

            if ($counter != $numberOfColumns) {
                $queryString .= ' OR ';
            }
            $counter++;
        }

        return $query->whereRaw($queryString);
    }
}
