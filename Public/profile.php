<?php
require __DIR__ . '/views/header.php';

if (!isset($_SESSION['user'])) { // Make this into a function!!!
    redirect('/');
}

$userPosts = displayPostsFromUser($pdo);
$userId = (string) $_SESSION['user']['id']; //convert user id into string to be able to use it in the function to get data from table
$userProfile = getUserProfile($pdo, $userId);
?>

<header>
    <h1><?php echo $_SESSION['user']['first_name'] . " " . $_SESSION['user']['last_name']; ?></h1>
    <img src="/uploads/<?php echo $userProfile['profile_image'] ?>" alt="profile image" width="100px">
    <p><?php echo $userProfile['biography'] ?></p>
    <a href="/settings.php"><button class="btn btn-primary">Edit profile</button></a>
</header>
<?php if (!$userPosts) : ?>
    <p>There is no photos...</p>
<?php else : ?>
    <?php foreach ($messages as $message) : ?>
        <div class="alert alert-success">
            <?php echo $message; ?>
        </div><!-- /alert -->
    <?php endforeach; ?>
    <?php foreach ($userPosts as $post) : ?>
        <article class="post">
            <header>
                <h2>
                    <?php echo $post['first_name'] . " " . $post['last_name']; ?>
                </h2>
                <footer><?php echo $post['date'] ?></footer>

            </header>
            <img class="post-image" src="/uploads/<?php echo $post['image'] ?>" alt="">
            <div class="description-wrapper">
                <form action='/app/posts/delete.php' method="post">
                    <input type="hidden" name="delete-post" value="<?php echo $post['id'] ?>">
                    <button type="submit" class="btn btn-primary">Delete</button>
                </form>
                <form action='/app/posts/edit.php' method="post">
                    <input type="hidden" name="post-id" value="<?php echo $post['id'] ?>">
                    <button type="button" class="edit-button btn btn-primary">Edit</button>
                </form>
                <img class="like" src="/images/like.svg" alt="like button">
                <img class="dislike" src="/images/dislike.svg" alt="dislike button">
                <p class="like-counter">0</p>
                <p class="description"><?php echo $post['description'] ?></p>
            </div>
        </article>
    <?php endforeach; ?>
<?php endif; ?>
<?php require __DIR__ . '/views/bottom-bar.php'; ?>
<?php require __DIR__ . '/views/footer.php'; ?>
