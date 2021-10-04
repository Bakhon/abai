<?php


namespace App\Services\BigData;


class TableFormHeaderService
{
    public function getHeader(array $columns, array $mergeColumns): array
    {
        $complicatedHeader = [];
        foreach ($columns as $column) {
            if ((isset($column['visible']) && $column['visible'] === false) || $column['type'] === 'hidden') {
                continue;
            }
            if (empty($column['parent_column'])) {
                $complicatedHeader[$column['code']] = [
                    'code' => $column['code'],
                    'title' => $column['title']
                ];
            } else {
                $tree = $this->getHeaderColumnTree($mergeColumns, $column);
                $complicatedHeader = $this->mergeColumns($complicatedHeader, $tree);
            }
        }

        $maxLevel = $this->getMaxLevel($complicatedHeader);
        $complicatedHeader = $this->fillMeta($complicatedHeader, $maxLevel);
        $complicatedHeader = $this->formatHeader($complicatedHeader, $maxLevel);

        return $complicatedHeader;
    }

    private function getHeaderColumnTree(array $mergeColumns, array $column, array $child = []): array
    {
        $col = [
            'code' => $column['code'],
            'title' => $column['title']
        ];
        if (!empty($child)) {
            $col['child'] = $child;
        }
        if (empty($column['parent_column'])) {
            return $col;
        }

        $parent = $mergeColumns[$column['parent_column']];
        if (empty($parent)) {
            return $col;
        }

        return $this->getHeaderColumnTree($mergeColumns, $parent, $col);
    }

    private function mergeColumns(array $complicatedHeader, array $tree): array
    {
        if (!isset($complicatedHeader[$tree['code']])) {
            $complicatedHeader[$tree['code']] = [
                'code' => $tree['code'],
                'title' => $tree['title'],
                'children' => []
            ];
        }
        $column = &$complicatedHeader[$tree['code']]['children'];
        while (true) {
            if (empty($tree['child'])) {
                break;
            }
            $tree = $tree['child'];

            if (!isset($column[$tree['code']])) {
                $column[$tree['code']] = [
                    'code' => $tree['code'],
                    'title' => $tree['title'],
                    'children' => []
                ];
            }
            $column = &$column[$tree['code']]['children'];
        }
        return $complicatedHeader;
    }

    public function getMaxLevel($columns): int
    {
        $maxLevel = 1;
        foreach ($columns as $column) {
            if (!empty($column['children'])) {
                $level = $this->getMaxLevel($column['children']) + 1;
                $maxLevel = max($level, $maxLevel);
                break;
            }
        }
        return $maxLevel;
    }

    private function fillMeta(array $columns, int $maxLevel)
    {
        foreach ($columns as &$column) {
            if (empty($column['children'])) {
                $column['rowspan'] = $maxLevel;
                $column['colspan'] = 1;
                continue;
            }

            $column['rowspan'] = $maxLevel - $this->getMaxLevel($column['children']);
            $column['colspan'] = $this->getColSpan($column['children']);
            $column['children'] = $this->fillMeta($column['children'], $maxLevel - 1);
        }
        return $columns;
    }

    private function getColSpan(array $columns): int
    {
        $colSpan = 0;
        foreach ($columns as $column) {
            if (empty($column['children'])) {
                $colSpan++;
                continue;
            }
            $colSpan += $this->getColSpan($column['children']);
        }
        return $colSpan;
    }

    private function formatHeader(array $complicatedHeader, int $maxLevel)
    {
        $columns = $complicatedHeader;
        $header = [];

        while (true) {
            if (empty($columns)) {
                break;
            }
            $row = [];
            $newColumns = [];
            foreach ($columns as $column) {
                if (!empty($column['children'])) {
                    $newColumns = array_merge($newColumns, $column['children']);
                }
                unset($column['children']);
                $row[] = $column;
            }
            $header[] = $row;
            $columns = $newColumns;
            $maxLevel--;
        }

        return $header;
    }
}