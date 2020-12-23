<?php

namespace App\Filters;

class UserFilter extends BaseFilter
{
    protected function sort(string $field, bool $desc)
    {
        switch($field) {
            case 'org':
                $this->query
                    ->select('users.*')
                    ->leftJoin('orgs', 'orgs.id', '=', 'users.org_id')
                    ->orderBy('orgs.name', $desc === true ? 'desc' : 'asc');
                break;
            default:
                $this->query->orderBy($field, $desc === true ? 'desc' : 'asc');
        }
    }

}
