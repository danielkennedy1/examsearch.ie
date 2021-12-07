<?php

namespace App\Policies;

//WAS CHANGED
use App\Models\MyComment as Comment;

class MyCommentPolicy
{
    /**
     * Can user create the comment
     *
     * @param $user
     * @return bool
     */
    public function create($user) : bool
    {
        //return true;
        return true;
    }

    /**
     * Can user delete the comment
     *
     * @param $user
     * @param Comment $comment
     * @return bool
     */
    public function delete($user, Comment $comment) : bool
    {
        //was changed
        return $user->id == $comment->user_id | $user->email == "danielrkennedy03@gmail.com";
    }

    /**
     * Can user update the comment
     *
     * @param $user
     * @param Comment $comment
     * @return bool
     */
    public function update($user, Comment $comment) : bool
    {
        //was changed
        return $user->getKey() == $comment->user_id;
    }

    /**
     * Can user reply to the comment
     *
     * @param $user
     * @param Comment $comment
     * @return bool
     */
    public function reply($user, Comment $comment) : bool
    {
        return $user->getKey() != $comment->commenter_id;
    }
}

