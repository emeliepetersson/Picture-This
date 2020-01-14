# Picture This
<img src="https://media.giphy.com/media/2tSodgDfwCjIMCBY8h/giphy.gif" width="100%">
You're going to create a Instagram clone we call Picture This.

> Instagram allows users to upload photos and videos to the service, which can be edited with various filters, and organized with tags and location information. Users can browse other users' content by tags and view trending content. Users can "like" photos, and follow other users to add their content to a feed  - [Wikipedia](https://en.m.wikipedia.org/wiki/Instagram)

## Assignment instructions
The assignment is to create an Instagram clone with CSS, HTML, Javascript and PHP.

### Features
Below you'll find a list of user stories the Picture This application must include.

- As a user I should be able to create an account.

- As a user I should be able to login.

- As a user I should be able to logout.

- As a user I should be able to edit my account email, password and biography.

- As a user I should be able to upload a profile avatar image.

- As a user I should be able to create new posts with image and description.

- As a user I should be able to edit my posts.

- As a user I should be able to delete my posts.

- As a user I should be able to like posts.

- As a user I should be able to remove likes from posts.

### Extra features

- As a user I should be able to follow and unfollow other users.

- As a user I should be able to view a list of posts by users I follow.

- As a user I'm able to delete my account along with all posts and comments.


#### Requirements
Below you'll find a list of requirements which need to be fulfilled in order to complete the project. 

- The project should implement nice looking graphical user interface.
    
- The application should be written in HTML, CSS, JavaScript and PHP.

- The application should be built using a SQLite database with at least three different tables.

- The application should be responsive and be built using the method mobile-first.

- The application should be implement secure hashed passwords when signing up.

- The project's PHP files should declare strict types.

- The project can't contain any PHP errors, warning or notices.


## Installation instructions
Clone down the project to you computer:
- $ git clone https://github.com/emeliepetersson/Picture-This.
- Start your server.
- Open the index.php file in your browser.

## Testers

## Code review
By <a href="https://github.com/mikaelaalu"> Mikaela Lundsgård </a>

[Functions#157](https://github.com/emeliepetersson/Picture-This/blob/f179a9477426095c204a62dd8f53f3ba3e3f5c18/Public/app/functions.php#L157) - Remeber to add @param $userId INT

[Upload#12](https://github.com/emeliepetersson/Picture-This/blob/f179a9477426095c204a62dd8f53f3ba3e3f5c18/Public/upload.php#L12) and
[User-profiles#22](https://github.com/emeliepetersson/Picture-This/blob/f179a9477426095c204a62dd8f53f3ba3e3f5c18/Public/user-profiles.php#L22) - It would be good to put this into a function to make your code more DRY

[Upload#17](https://github.com/emeliepetersson/Picture-This/blob/f179a9477426095c204a62dd8f53f3ba3e3f5c18/Public/upload.php#L17) and
[Users-profiles#27](https://github.com/emeliepetersson/Picture-This/blob/f179a9477426095c204a62dd8f53f3ba3e3f5c18/Public/user-profiles.php#L27) - It would be good to put this into a function aswell, to make your code more DRY


[Edit-settings#99](https://github.com/emeliepetersson/Picture-This/blob/f179a9477426095c204a62dd8f53f3ba3e3f5c18/Public/app/users/edit-settings.php#L99) - Sanitize email before insert into database

[Edit-settings#100](https://github.com/emeliepetersson/Picture-This/blob/f179a9477426095c204a62dd8f53f3ba3e3f5c18/Public/app/users/edit-settings.php#L100) - Sanatize name before insert into database

[Edit-settings#101](https://github.com/emeliepetersson/Picture-This/blob/f179a9477426095c204a62dd8f53f3ba3e3f5c18/Public/app/users/edit-settings.php#L101) - Sanatize last name before insert into database

[Signup#13](https://github.com/emeliepetersson/Picture-This/blob/f179a9477426095c204a62dd8f53f3ba3e3f5c18/Public/app/users/signup.php#L13) - Could be good to have validation for length on passwords, now it’s able to have a password with only one letter

[Functions#262](https://github.com/emeliepetersson/Picture-This/blob/f179a9477426095c204a62dd8f53f3ba3e3f5c18/Public/app/functions.php#L262) - Dosent says what the function returns 

[Functions#1](https://github.com/emeliepetersson/Picture-This/blob/f179a9477426095c204a62dd8f53f3ba3e3f5c18/Public/app/functions.php#L1) - In some functions descriptions you start with upper case, and in some you start with lower case

[Functions#31](https://github.com/emeliepetersson/Picture-This/blob/f179a9477426095c204a62dd8f53f3ba3e3f5c18/Public/app/functions.php#L31) - Really good function!

It was fun and inspiring reading your code, great job!

## License
See [The MIT License](https://github.com/emeliepetersson/Picture-This/blob/master/LICENSE).
