@foreach ($discussions as $discussion)
    <a href="{{ route('firefly.discussion.show', [$discussion->id, $discussion->slug]) }}" class="card mb-3">
        <div class="card-body">
            <div class="discussion-item d-flex justify-content-between align-items-center">
                <div>
                    <h3 class="mb-0">{{ $discussion->title }}</h3>

                    <div class="discussion-item-meta">
                        {{ $discussion->user->name }}
                        <span class="mx-2">{{ $discussion->created_at->diffForHumans() }}</span>
                        {{ $discussion->reply_count }}
                    </div>
                </div>

                <div class="d-flex">
                    @foreach ($discussion->groups as $group)
                        <div class="group-display rounded-circle mb-0" data-toggle="tooltip" data-placement="top" title="{{ $group->name }}" style="background: {{ $group->color }};"></div>
                    @endforeach
                </div>
            </div>
        </div>
    </a>
@endforeach
