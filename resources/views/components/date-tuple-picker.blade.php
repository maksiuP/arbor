@props(['name', 'label', 'initial-from', 'initial-to'])

<div {{ $attributes->merge(['class' => 'flex flex-col']) }}
    x-data="dateTuplePickerData(
        @encodedjson([
            'year' => $initialSimplePickerValues()['y'] ?? '',
            'month' => $initialSimplePickerValues()['m'] ?? '',
            'day' => $initialSimplePickerValues()['d'] ?? '',
            'from' => optional($initialFrom)->format('Y-m-d'),
            'to' => optional($initialTo)->format('Y-m-d'),
            'advancedPicker' => $errors->has($name.'_from') || $errors->has($name.'_to') || ! $simplePickerCanBeUsed(),
        ])
    )">
    <div class="w-full pb-1 flex items-center">
        <label for="{{ $name }}_year" class="font-medium text-gray-700">{{ $label }}</label>
        <button type="button" @click.prevent="advancedPicker = ! advancedPicker"
            x-text="advancedPicker ? '{{ __('misc.date.simple') }}' : '{{ __('misc.date.advanced') }}'"
            class="ml-2 a underline leading-none text-sm">
            toggle
        </button>
    </div>
    <div class="w-full">
        <div class="flex flex-nowrap items-center justify-between">
            <div x-show="! advancedPicker"
                class="flex-grow flex-shrink flex">
                <div class="flex items-center">
                    <input
                        type="text" class="form-input w-16 rounded-r-none z-10"
                        :class="{ 'invalid': ! dateIsValid }"
                        x-model="year" x-ref="year"
                        @keyup="
                            updateAdvanced();
                            if ($event.target.selectionStart == 4 && $event.keyCode >= 48 && $event.keyCode <= 57) {
                                $refs.month.focus()
                            }"
                        placeholder="{{ __('misc.date.yyyy') }}"
                        maxlength=4>
                    <input
                        type="text" class="form-input w-12 rounded-none focus:z-20"
                        :class="{ 'invalid': ! dateIsValid }"
                        style="margin: 0 -1px 0 -1px"
                        x-model="month" x-ref="month"
                        @keyup="
                            updateAdvanced();
                            if ($event.target.selectionStart == 2 && $event.keyCode >= 48 && $event.keyCode <= 57) {
                                $refs.day.focus()
                            } else if ($event.target.selectionStart == 0 && $event.keyCode == 8) {
                                $refs.year.focus()
                            }"
                        placeholder="{{ __('misc.date.mm') }}"
                        maxlength=2>
                    <input
                        type="text" class="form-input w-12 rounded-l-none z-10"
                        :class="{ 'invalid': ! dateIsValid }"
                        x-model="day" x-ref="day"
                        @keyup="
                            updateAdvanced()
                            if ($event.target.selectionStart == 0 && $event.keyCode == 8) {
                               $refs.month.focus()
                            }"
                        placeholder="{{ __('misc.date.dd') }}"
                        maxlength=2>
                </div>
            </div>
            <div x-show="advancedPicker"
                class="flex-grow flex-shrink flex flex-wrap -mb-2">
                <div class="flex-grow-0 flex items-center mb-2 mr-1">
                    <p class="text-gray-900">{{ __('misc.date.between') }}</p>
                    <input
                        type="text" class="form-input w-32 ml-1 @error($name.'_from') invalid @enderror"
                        x-model="from" x-ref="from" name="{{ $name }}_from"
                        placeholder="{{ __('misc.date.format') }}"
                        size="12" maxlength=10>
                </div>
                <div class="flex-grow-0 flex items-center mb-2">
                    <p class="text-gray-900">{{ __('misc.date.and') }}</p>
                    <input
                        type="text" class="form-input w-32 ml-1 @error($name.'_to') invalid @enderror"
                        x-model="to" x-ref="to" name="{{ $name }}_to"
                        placeholder="{{ __('misc.date.format') }}"
                        size="12" maxlength=10>
                </div>
            </div>
        </div>
        @error($name.'_from')
            <div class="w-full leading-none mt-1">
                <small class="text-red-500">{{ $message }}</small>
            </div>
        @enderror
        @error($name.'_to')
            <div class="w-full leading-none mt-1">
                <small class="text-red-500">{{ $message }}</small>
            </div>
        @enderror
    </div>
</div>
