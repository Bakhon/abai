<?php

namespace App;

use App\Models\Refs\Org;
use App\Services\BigData\StructureService;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\Traits\CausesActivity;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable, HasRoles, CausesActivity;

    /**
     * The attributes that are mass assignable.
     *`
     * @var array
     */
    protected $fillable = [
        'name',
        'username',
        'password',
        'org_structure'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_authorized_at' => 'datetime',
        'org_structure' => 'array'
    ];

    private $userOrgs = [];

    public function profile()
    {
        return $this->hasOne(Profile::class)->withDefault();
    }

    public function org()
    {
        return $this->belongsTo(\App\Models\Refs\Org::class);
    }

    public function pageViewLogs()
    {
        return $this->hasMany(\App\Models\LogPageView::class)->orderBy('created_at', 'desc');
    }

    public function bigdataFavoriteReports()
    {
        return $this->belongsToMany(\App\Models\BigdataReport::class);
    }

    public function reportTemplates()
    {
        return $this->belongsToMany(\App\Models\ReportTemplate::class);
    }

    public function getOrganizations()
    {
        if($this->org_id) {
            return Org::query()
                ->where('id', $this->org_id)
                ->orWhere('parent_id', $this->org_id)
                ->get();
        }
        else {
            return new \Illuminate\Database\Eloquent\Collection();
        }
    }

    public function getUserOrganizations(StructureService $structureService): array
    {
        $orgs = [];
        if($this->org_structure) {
            $orgIds = array_map(function ($item) {
                return substr($item, strpos($item, ":") + 1);
            }, $this->org_structure);
            $orgs = \App\Models\BigData\Dictionaries\Org::query()
                ->select(['id', 'name_ru as name'])
                ->whereIn('id', $orgIds)
                ->get()
                ->toArray();
        }

        return $orgs;
    }

    public function getUserAllOrganizations(StructureService $structureService): array
    {
        if($this->org_structure) {
            $orgIds = array_map(function ($item) {
                return substr($item, strpos($item, ":") + 1);
            }, $this->org_structure);
            $orgsTree = $structureService->getTree(Carbon::now());
            $this->getOrgsByIdsRecursive($orgsTree, $orgIds);
        }

        return $this->userOrgs;
    }

    public function getOrganizationIds(): array
    {
        return $this->getOrganizations()->pluck('id')->toArray();
    }

    public function modules()
    {
        return $this->belongsToMany(Module::class);
    }

    private function getOrgsByIdsRecursive(array $orgsTree, array $orgIds): void {
            foreach ($orgsTree as $orgTreeItem) {
                if (!in_array($orgTreeItem['id'], $orgIds) || !isset($orgTreeItem['children'])) {
                    continue;
                }
                foreach ($orgTreeItem['children'] as $child) {
                    $this->userOrgs[] = self::getOrgsArray($child);
                }
                $this->getOrgsByIdsRecursive($orgTreeItem['children'], $orgIds);
            }
    }

    private static function getOrgsArray(array $org): array
    {
        $result = [
            'id' => $org['id'],
            'name' => $org['name'],
            'sub_type' => $org['sub_type'],
            'parent_id' => $org['parent_id'] ?? null,
        ];
        if (isset($org['children'])) {
            $result['children'] = array_map('self::getOrgsArray', $org['children']);
        }
        return $result;
    }
}
