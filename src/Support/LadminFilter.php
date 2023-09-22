<?php

namespace LowB\Ladmin\Support;

use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use LowB\Ladmin\Support\Query\LadminQuery;

class LadminFilter
{
    public const KEYWORD = 'keyword';

    public const ORDER = 'order';

    public const ORDER_BY = 'by';

    public const ORDER_DIRECTION = 'direction';

    public static function filter(Request $request, LadminQuery $query): LadminQuery
    {
        $clone = clone $query;
        $params = $request->all();
        foreach ($params as $key => $param) {
            $clone->query = self::handle($key, $param, $clone->query);
        }

        return $clone;
    }

    protected static function handle(string $key, mixed $param, Model|Builder|EloquentBuilder $query): Model|Builder|EloquentBuilder
    {
        if ($key === self::KEYWORD) {
            return self::keyword($param, $query);
        }
        if ($key === self::ORDER) {
            return self::order($param[self::ORDER_BY], $param[self::ORDER_DIRECTION], $query);
        }

        return self::column($key, $param, $query);
    }

    protected static function keyword(string $param, Model|Builder|EloquentBuilder $query): Model|Builder|EloquentBuilder
    {
        $keywords = preg_split('/[\s　]+/', $param);
        $columnNames = $query->getColumnNames();
        foreach ($keywords as $keyword) {
            $query = $query->where(function ($query) use ($keyword, $columnNames) {
                foreach ($columnNames as $column) {
                    $query->orWhere($column, 'LIKE', "%$keyword%");
                }
            });
        }

        return $query;
    }

    protected static function order(string $by, string $direction, Model|Builder|EloquentBuilder $query): Model|Builder|EloquentBuilder
    {
        $query = $query->orderBy($by, $direction);

        return $query;
    }

    protected static function column(string $key, string $param, Model|Builder|EloquentBuilder $query): Model|Builder|EloquentBuilder
    {
        $key = Str::after($key, '_');
        $query = $query->where($key, 'LIKE', "%$param%");

        return $query;
    }
}
