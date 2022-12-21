<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Post;
use App\User;
use Carbon\Carbon;

class PostController extends Controller
{
  public function index()
  {
    $posts = Post::all();
    $users = User::all();
    $displayItem = [];

    for ($i = 0; $i < $users->count(); $i++) {
      $item = $posts->where('user_id', $users->get($i)->id);
      if ($item->isNotEmpty()) {
        foreach ($item as $data) {
          $displayItem[] = [
            'user_id' => $data->user_id,
            'post_id' => $data->id,
            'user_name' => $users->get($i)->name,
            'body' => $data->body,
            'created_at' => (new Carbon($data->created_at))->format('Y/m/d H:i:s'),
          ];
        }
      }
    }
    if ($displayItem) {
      array_multisort(array_map("strtotime", array_column($displayItem, "created_at")), SORT_DESC, $displayItem);
      foreach ($displayItem as $item) {
        $item['created_at'] =  (new Carbon($item['created_at']))->format('Y/m/d H:i');
      }
      $formatDisplayItem = array_map(function ($item) {
        $item['created_at'] = (new Carbon($item['created_at']))->format('Y/m/d H:i');
        return $item;
      }, $displayItem);
    }
    return view('post', compact('formatDisplayItem'));
  }

  public function create(Request $request)
  {
    $this->validate($request, Post::$rules);
    $post = new Post;
    $form = $request->all();
    unset($form['_token']);

    // データベースに保存
    $post->fill($form);
    $post->save();

    return redirect('post');
  }

  public function delete(Request $request)
  {
    $post = Post::find($request->id);
    // 削除する
    $post->delete();
    return redirect('post');
  }
}
