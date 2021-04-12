<?php

namespace App\Filters;

class UserFilter extends BaseFilter
{
    protected function sort(string $field, bool $isDescending)
    {
        switch($field) {
            case 'org':
                $this->query
                    ->select('users.*')
                    ->leftJoin('orgs', 'orgs.id', 'users.org_id')
                    ->orderBy('orgs.name', $isDescending ? 'desc' : 'asc');
                break;
            default:
                $this->query->orderBy($field, $isDescending ? 'desc' : 'asc');
        }
    }

}
