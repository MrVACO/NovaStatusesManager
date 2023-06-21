<?php

declare(strict_types = 1);

namespace MrVaco\NovaStatusesManager\Fields;

use Illuminate\Support\Arr;
use Illuminate\Support\Stringable;
use Laravel\Nova\Contracts\FilterableField;
use Laravel\Nova\Exceptions\NovaException;
use Laravel\Nova\Fields\Field;
use Laravel\Nova\Fields\FieldFilterable;
use Laravel\Nova\Fields\Filters\SelectFilter;
use Laravel\Nova\Fields\Searchable;
use Laravel\Nova\Fields\SupportsDependentFields;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Util;
use MrVaco\NovaStatusesManager\Models\Statuses;

class Status extends Field implements FilterableField
{
    use SupportsDependentFields, FieldFilterable, Searchable;
    
    public function component(): string
    {
        $this->withMeta([
            'status' => Statuses::query()->find($this->value)
        ]);
        
        return 'status-field';
    }
    
    /**
     * The field's options callback.
     *
     * @var array<string|int, array<string, mixed>|string>|\Closure|callable|\Illuminate\Support\Collection|null
     *
     * @phpstan-var TOption|(callable(): (TOption))|(\Closure(): (TOption))|null
     */
    public $optionsCallback;
    
    /**
     * Set the options for the select menu.
     *
     * @param  array<string|int, array<string, mixed>|string>|\Closure|callable|\Illuminate\Support\Collection  $options
     *
     * @return $this
     *
     * @phpstan-param TOption|(callable(): (TOption))|(\Closure(): (TOption))                                   $options
     */
    public function options($options): static
    {
        $this->optionsCallback = $options;
        
        return $this;
    }
    
    /**
     * Display values using their corresponding specified labels.
     *
     * @return $this
     */
    public function displayUsingLabels(): static
    {
        $this->displayUsing(function($value)
        {
            if (is_null($value) || $this->isValidNullValue($value))
            {
                return $value;
            }
            
            return collect($this->serializeOptions(false))
                       ->where('value', $value)
                       ->first()['label'] ?? $value;
        });
        
        return $this;
    }
    
    /**
     * Enable subtitles within the related search results.
     *
     * @return $this
     *
     * @throws \Exception
     */
    public function withSubtitles(): static
    {
        throw NovaException::helperNotSupported(__METHOD__, __CLASS__);
    }
    
    /**
     * Prepare the field for JSON serialization.
     *
     * @return array
     */
    public function serializeForFilter(): array
    {
        return transform($this->jsonSerialize(), function($field)
        {
            return Arr::only($field, [
                'uniqueKey',
                'name',
                'attribute',
                'options',
                'searchable',
            ]);
        });
    }
    
    /**
     * Serialize options for the field.
     *
     * @param  bool  $searchable
     *
     * @return array<int, array<string, mixed>>
     *
     * @phpstan-return array<int, array{group: string, label: string, value: TOptionValue}>
     */
    protected function serializeOptions($searchable): array
    {
        /** @var TOption $options */
        $options = value($this->optionsCallback);
        
        if (is_callable($options))
        {
            $options = $options();
        }
        
        return collect($options ?? [])->map(function($label, $value) use ($searchable)
        {
            $label = $label instanceof Stringable ? (string) $label : $label;
            $value = Util::safeInt($value);
            
            if ($searchable && isset($label['group']))
            {
                return [
                    'label' => $label['group'] . ' - ' . $label['label'],
                    'value' => $value,
                ];
            }
            
            return is_array($label) ? $label + ['value' => $value] : ['label' => $label, 'value' => $value];
        })->values()->all();
    }
    
    /**
     * Prepare the field for JSON serialization.
     *
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        $this->withMeta([
            'options' => $this->serializeOptions($searchable = $this->isSearchable(app(NovaRequest::class))),
        ]);
        
        return array_merge(parent::jsonSerialize(), [
            'searchable' => $searchable,
        ]);
    }
    
    protected function makeFilter(NovaRequest $request): SelectFilter
    {
        return new SelectFilter($this);
    }
}
