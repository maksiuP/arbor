@push('scripts')
    <livewire:styles>
    <livewire:scripts>
@endpush

<div class="flex flex-col md:flex-row space-x-2 space-y-2">

    <div class="flex-grow space-y-2 flex flex-col items-center">

        <div class="w-full p-4 bg-white rounded-lg shadow-lg">
            <table>
                @foreach ($activities as $activity)
                    <tr wire:key="{{ $activity->id }}">

                        <td class="tnum text-right">
                            {{ $activity->created_at->format('Y-m-d h:s') }}
                        </td>

                        <td>
                            @if($activity->log_name == 'people')

                                <a href="{{ route('people.history', $activity->subject) }}" class="a">
                                    {{ __('people.person').' №'.$activity->subject->id }}
                                </a>

                                @if($activity->description == 'changed-visibility')
                                    {{ $activity->properties['attributes']['visibility'] ? __('activities.made_visible') : __('activities.made_invisible') }}
                                @else
                                    {{ __('activities.'.$activity['description']) }}
                                @endif

                                @if($activity->causer)
                                    {{ __('activities.by') }} <strong>{{ $activity->causer->username }}</strong>
                                @endif

                            @elseif($activity->log_name == 'marriages')

                                <a href="{{ route('marriages.history', $activity->subject) }}" class="a">
                                    {{ __('marriages.marriage').' №'.$activity->subject->id }}
                                </a>

                                (<a href="{{ route('people.show', $activity->subject->woman_id) }}" class="a">{{ strtolower(__('marriages.woman')) }}</a>,
                                <a href="{{ route('people.show', $activity->subject->man_id) }}" class="a">{{ strtolower(__('marriages.man')) }}</a>)

                                {{ __('activities.'.$activity['description']) }}

                                @if($activity->causer)
                                    {{ __('activities.by') }} <strong>{{ $activity->causer->username }}</strong>
                                @endif

                            @elseif($activity->log_name == 'users')

                                {{ __('users.user').' №'.$activity->subject->id }}
                                {{ __('activities.'.$activity['description']) }}

                                @if($activity->causer)
                                    {{ __('activities.by') }} <strong>{{ $activity->causer->username }}</strong>
                                @endif

                            @endif
                        </td>

                    </tr>
                @endforeach
            </table>
        </div>

        {{ $activities->links() }}

    </div>

    <div class="flex-shrink-0 p-1">
        <x-dashboard-menu active="activitylog"/>
    </div>

</div>
