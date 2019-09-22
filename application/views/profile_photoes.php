<div class="profile-photoes">
    <?php
    require_once "User.php";
    if (!$data)
        echo "<div class='login'>
                            <p>Photoes coming soon!</p>
                           </div>";
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
                                        <img class="icon-item" id="like" src="images/like.png" photo_id="'.
                $data[$len]['id'] .'" user_id="';
                if (isset($_SESSION['user']))
                    echo $_SESSION['user']['id'];
                else
                    echo 0;
                $photo = new Photo();
                $photo->setId($data[$len]['id']);
                    echo '">
                                        <span class="likes-item">' . $photo->countLikes() . '</span> 
                                    </div>
                                        <a href="/profile?id='. $user->getId() .'">
                                        <div>
                                            ' . $user->getUsername() . '
                                        </div>
                                    </a>
                                </div>
                                <div class="comments-wrapper">
                                    <span>';
                                    if ($res = $photo->getLastComment()) {
                                        $user->getUserById($res['user_id']);
                                        echo $user->getUsername(). ': ' .$res['text'];
                                    }
                                    else
                                        echo 'Comment';
                                    echo '</span>
                                </div>
                                <form class="comment-form">
                                    <input name="comment" type="text" placeholder="Leave your comment">
                                    <input class="add-comment" type="submit" value="send" 
                                    photo_id="'. $data[$len]['id'] . '" user_id="';
                if (isset($_SESSION['user']))
                    echo $_SESSION['user']['id'];
                else
                    echo 0;
                echo '">
                                </form>
                              </div>';
        }
    }
    ?>
</div>

