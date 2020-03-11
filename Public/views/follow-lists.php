<div class="follow-lists">
    <button class="button small-button followers-button">Followers</button>
    <ul class="followers-list">
        <h3>Followers</h3>
        <?php foreach ($followers as $follower) { ?>
            <li><a href="/user-profiles.php?user-id=<?php echo $follower['user_id'] ?>"><?php echo $follower['first_name'].' '.$follower['last_name'] ?></a></li>
        <?php } ?>
        <button class="button small-button back" type="button">Back</button>
    </ul>
    <button class="button small-button following-button">Following</button>
    <ul class="following-list">
        <h3>Following</h3>
        <?php foreach ($followings as $following) { ?>
            <li><a href="/user-profiles.php?user-id=<?php echo $following['following_user_id'] ?>"><?php echo $following['first_name'].' '.$following['last_name'] ?></a></li>
        <?php } ?>
        <button class="button small-button back" type="button">Back</button>
    </ul>
</div>
