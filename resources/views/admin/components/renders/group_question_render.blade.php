@forelse($groups as $key => $group)
    <option value="{{ $group->id }}">{{ $group->title }}</option>
@empty
@endforelse
