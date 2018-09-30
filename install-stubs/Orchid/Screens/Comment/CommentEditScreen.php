<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Comment;

use App\Orchid\Layouts\Comment\CommentEditLayout;
use Illuminate\Http\Request;
use Orchid\Press\Models\Comment;
use Orchid\Screen\Layouts;
use Orchid\Screen\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;

class CommentEditScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'platform::systems/comment.title';
    /**
     * Display header description.
     *
     * @var string
     */
    public $description = 'platform::systems/comment.description';

    /**
     * Query data.
     *
     * @param \Orchid\Press\Models\Comment $comment
     *
     * @return array
     */
    public function query(Comment $comment): array
    {
        return [
            'comment' => $comment,
        ];
    }

    /**
     * Button commands.
     *
     * @return array
     */
    public function commandBar(): array
    {
        return [
            Link::name(trans('platform::common.commands.save'))
                ->icon('icon-check')
                ->method('save'),
            Link::name(trans('platform::common.commands.remove'))
                ->icon('icon-trash')
                ->method('remove'),
        ];
    }

    /**
     * Views.
     *
     * @return array
     */
    public function layout(): array
    {
        return [
            Layouts::columns([
                'CommentEdit' => [
                    CommentEditLayout::class,
                ],
            ]),
        ];
    }

    /**
     * @param Comment $comment
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(Comment $comment, Request $request)
    {
        $comment
            ->fill($request->get('comment'))
            ->save();

        Alert::info(trans('platform::systems/comment.Comment was saved'));

        return redirect()->route('platform.systems.comments');
    }

    /**
     * @param Comment $comment
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function remove(Comment $comment)
    {
        $comment->delete();

        Alert::info(trans('platform::systems/comment.Comment was removed'));

        return redirect()->route('platform.systems.comments');
    }
}