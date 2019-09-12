
<section class="main-slider">
    <div class="profile">
        <div class="profile-info">
            <?php
            require_once "Photo.php";
                $user = $_SESSION['user'];
                $photo = new Photo();
                $result = $photo->getProfilePhoto($user['id']);
//                var_dump($result);
//                die();
                echo '<img class="profile-photo" src="' . $result['path'] . '" alt=""> ';
                echo  "<p>". $user['username'] ."</p>";
            ?>
            <form enctype="multipart/form-data" action="http://localhost:8080/profile/add_photo" method="POST">
                <input type="hidden" name="MAX_FILE_SIZE" value="100000" />
                <input name="filename" type="file" />
                <input class="button" type="submit" value="OK" />
            </form>
        </div>
        <div class="profile-photoes">
            <?php
            require_once "User.php";
            //            var_dump($data);
            if (!$data)
                echo "<p>Photoes coming soon!</p>";
            else
            {
                $len = -1;
                while (++$len < count($data)) {
                echo '<div class="element">
                    <img src=' . $data[$len]['path'] . ' alt="">
                    <img class="icon" src="images/like.png" alt="">
                    <a class="likes">' . $data[$len]['likes'] . '</a>';
                    $user = new User();
                    $user->getUserById($data[$len]['user_id']);
                    echo '<a>' . $user->getUsername() . '</a>
                    <div class="comment">
                        <a>Comment</a>
                    </div>
                </div>';
                }
            }
            ?>
        </div>

<!--        --><?php
//            echo "Welcome to profile!"; ?>
    </div>
</section>