<form class="like-form" method="post">
    <input type="text" name="post-id" value="<?php echo $post['id'] ?>" hidden>
    <button type="submit" class="like-form-button <?php echo $postIsliked ? "dislike" : "like" ?>"><img src="/images/<?php echo $postIsliked ? "dislike.svg" : "like.svg" ?>" alt="like button"></button>
</form>
<p class="like-counter"><?php echo $amountOfLikes ?></p>
