<?php


namespace App\Filters;

use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class MapHistoryFilter extends BaseFilter
{

    public function __construct(Builder $query, array $params)
    {
        parent::__construct($query, $params);
        $this->defaultSortField = 'created_at';
    }

    protected function sort(string $field, bool $isDescending)
    {
        switch ($field) {
            case 'user':
                $this->query
                    ->select('activity_log.*')
                    ->leftJoin('users', 'users.id', 'activity_log.causer_id')
                    //dirty hack for alphanumeric sort but other solutions doesn't work
                    ->addSelect(DB::raw('lpad(users.username, 10, 0) AS users_username'))
                    ->orderBy('users_username', $isDescending ? 'desc' : 'asc');
                break;
            case 'subject':
                $this->query->orderBy('subject_type', $isDescending ? 'desc' : 'asc');
                break;
            case 'action':
                $this->query->orderBy('description', $isDescending ? 'desc' : 'asc');
                break;
            default:
                $this->query->orderBy($field, $isDescending ? 'desc' : 'asc');
        }
    }

    protected function filter_date($date)
    {
        $this->query->where('created_at', 'LIKE', $date . '%');
    }

    protected function filter_user($username)
    {
        $userIds = User::where('username', 'like', '%' . $username . '%')->pluck('id')->all();
        $this->query->whereIn('causer_id', $userIds);
    }

    protected function filter_subject($subject)
    {
        $this->query->where('subject_type', 'like', '%'.$subject.'%');
    }

    protected function filter_action($action)
    {
        $this->query->where('description', $action);
    }



}
