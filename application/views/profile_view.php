
<section class="main-slider">
    <div class="profile">
        <div class="profile-info">
            <?php
            require_once "Photo.php";
            require_once "User.php";
                $photo = new Photo();
                if (isset($_GET['id'])) {
                    $result = $photo->getProfilePhoto($_GET['id']);
                    echo '<img class="profile-photo" src="' . $result['path'] . '" alt=""> ';
                    $us = new User();
                    $us->getUserById($_GET['id']);
                    echo "<p>" . $us->getUsername() . "</p>";
                }
                else {
                    $user = $_SESSION['user'];
                    $result = $photo->getProfilePhoto($user['id']);
                    echo '<img class="profile-photo" src="' . $result['path'] . '" alt=""> ';
                    echo "<p>" . $user['username'] . "</p>";
                }
                if (!isset($_GET['id']) || (isset($_SESSION['user']) && ($_SESSION['user']['id'] == $_GET['id']))) {
                    echo '<form enctype = "multipart/form-data" action = "http://localhost:8080/profile/add_photo" method = "POST" >
                              <input type = "hidden" name = "MAX_FILE_SIZE" value = "100000" />
                              <input name = "filename" type = "file" />
                              <input class="button" type = "submit" value = "OK" />
                           </form >';
                }
            ?>
        </div>
        <div class="profile-photoes">
            <?php
                require_once "User.php";
                if (!$data)
                    echo "<p>Photoes coming soon!</p>";
                else {
                    $len = -1;
                    while (++$len < count($data)) {
                        $user = new User();
                        $user->getUserById($data[$len]['user_id']);
                        echo '<div class="element-wrapper">
                                <div class="photo-wrapper">
                                    <img class="image-item" src=' . $data[$len]['path'] . ' alt="">
                                </div>
                                <div class="likes-wrapper">
                                    <div class="icons">
                                        <img class="icon-item" src="images/like.png" alt="">
                                        <span class="likes-item">' . $data[$len]['likes'] . '</span>
                                    </div>
                                    <a href="/profile?id='. $user->getId() .'">
                                        <div>
                                            ' . $user->getUsername() . '
                                        </div>
                                    </a>
                                </div>
                                <div class="comments-wrapper">
                                    <span>Comment</span>
                                </div>
                                <form class="comment-form" action="" method="POST">
                                    <input type="text" placeholder="Leave your comment">
                                    <input type="submit" value="send">
                                </form>
                              </div>';
                    }
                }
            ?>
        </div>

<!--        --><?php
//            echo "Welcome to profile!"; ?>
    </div>
</section>