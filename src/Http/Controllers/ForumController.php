<?php

namespace Firefly\Http\Controllers;

use Firefly\Models\Discussion;
use Firefly\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ForumController extends Controller
{
    /**
     * Show the forum index.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $groups = Group::all();

        $discussions = Discussion::query()
            ->withIsBeingWatched($request->user())
            ->withIsAnswered()
            ->withSearch($request->get('search'))
            ->leftJoin('posts', function ($join) {
                $join->on('posts.discussion_id', '=', 'discussions.id');
                $join->whereNull('posts.deleted_at');
            })
            ->select(['discussions.*', DB::raw('max(posts.created_at) as last_post_at')])
            ->groupBy('discussions.id')
            ->orderBy('last_post_at', 'desc')
            ->orderBy('discussions.created_at', 'desc')
            ->paginate(config('firefly.pagination.discussions'));

        return view('firefly::index')
            ->with(compact('groups', 'discussions'))
            ->withSearch($request->get('search'));
    }
}
