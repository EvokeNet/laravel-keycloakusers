<div>
    <select {{ $attributes->merge(['class' => 'border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm']) }}>
        <option value="null" disabled>{{ __('Please select') }}</option>

        @foreach($options as $option)
            <option @if($option->id == $selected) 'selected="selected"' @endif value="{{ $option->id }}">
                {{ $option->name }}
            </option>
        @endforeach
    </select>
</div>
