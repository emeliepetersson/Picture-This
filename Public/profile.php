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
    <?php foreach ($userPosts as $post) : ?>
        <article>
            <header>
                <h2>
                    <?php echo $post['first_name'] . " " . $post['last_name']; ?>
                </h2>
                <footer><?php echo $post['date'] ?></footer>
                <header>
                    <img src="/uploads/<?php echo $post['image'] ?>" alt="">
                    <p><?php echo $post['description'] ?></p>
        </article>
    <?php endforeach; ?>
<?php endif; ?>
<?php require __DIR__ . '/views/bottom-bar.php'; ?>
<?php require __DIR__ . '/views/footer.php'; ?>
