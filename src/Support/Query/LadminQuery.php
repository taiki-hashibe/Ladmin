<?php

namespace LowB\Ladmin\Support\Query;

use Closure;
use Exception;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use LowB\Ladmin\Support\Facades\LadminQueryManager;
use LowB\Ladmin\Support\LadminFilter;

class LadminQuery
{
    public const TYPE_MODEL = 'model';

    public const TYPE_BUILDER = 'builder';

    public string $primaryKey = 'id';

    public Model|Builder|EloquentBuilder $query;

    public string $queryType;

    public string $displayColumn;

    public function __construct(string $name, string|Closure $displayColumn = null)
    {
        $this->query = self::makeQuery($name);
        $this->queryType = self::typeOf($this->query);
        if ($this->queryType === self::TYPE_MODEL) {
            $this->primaryKey = $this->query->getKeyName();
            // TODO
        }
        $this->displayColumn = $displayColumn ?? $this->primaryKey;
    }

    public function __call($method, $args)
    {
        return $this->query->{$method}(...$args);
    }

    public function __get($name)
    {
        return $this->query->{$name};
    }

    public static function make(string $name, string|Closure $displayColumn = null, ?bool $register = true): self
    {
        $query = new self($name, $displayColumn);
        if ($register) {
            LadminQueryManager::register($query);
        }

        return $query;
    }

    public static function makeQuery(string $name): Model|Builder
    {
        if (is_subclass_of($name, Model::class)) {
            return app()->make($name);
        } else {
            return DB::table($name);
        }
    }

    public static function typeOf(Model|Builder $query): string
    {
        if ($query instanceof Model) {
            return self::TYPE_MODEL;
        }
        if ($query instanceof Builder) {
            return self::TYPE_BUILDER;
        }
        throw new Exception('The specified class [$query] is neither a subclass of '.Model::class.' nor '.Builder::class.'.');
    }

    public function filter(): self
    {
        $clone = clone $this;

        return LadminFilter::filter(request(), $clone);
    }

    public function getTable()
    {
        if ($this->queryType === self::TYPE_MODEL) {
            return $this->query->getTable();
        }

        return $this->query->from;
    }

    public function getColumns()
    {
        $columns = [];
        foreach ($this->getColumnNames() as $column) {
            $columns[$column] = Schema::connection(config('database.default'))->getConnection()->getDoctrineColumn($this->getTable(), $column);
        }

        return $columns;
    }

    public function getColumnNames()
    {
        return Schema::connection(config('database.default'))->getColumnListing($this->getTable());
    }

    public function getPrimaryKeyName()
    {
        return $this->primaryKey;
    }

    public function getDisplayColumnValue(mixed $primaryKey): mixed
    {
        return $this->query->where($this->primaryKey, $primaryKey)->first()->{$this->displayColumn};
    }

    public function find(mixed $primaryKey)
    {
        return $this->query->where($this->primaryKey, $primaryKey);
    }

    public function findUpdate(mixed $primaryKey, mixed $value)
    {
        $currentItem = $this->find($primaryKey);
        if ($this->queryType === self::TYPE_MODEL) {
            return $currentItem->first()->update($value);
        }

        return $currentItem->update($value);
    }

    public function findDelete(mixed $primaryKey)
    {
        $currentItem = $this->find($primaryKey);
        if ($this->queryType === self::TYPE_MODEL) {
            return $currentItem->first()->delete();
        }

        return $currentItem->delete();
    }
}
