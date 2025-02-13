<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PageRequest extends FormRequest
{
    /** @var array|int[] $per_pages */
    protected static array $per_pages = [10, 25, 50, 100, 200];

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->mergeIfMissing([
            'page' => 1,
            'per_page' => 25,
            'direction' => $this->input('direction', 'asc'),
        ]);
    }

    public function rules(): array
    {
        return [
            'page' => ['bail', 'nullable', 'int', 'min:1'],
            'per_page' => ['bail', 'nullable', 'int', 'in:' . implode(',', self::$per_pages)],
            'direction' => ['bail', 'nullable', 'in:asc,desc'],
            'order_by' => ['nullable'],
        ];
    }
}
