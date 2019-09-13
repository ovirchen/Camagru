
<section class="main-slider">
    <div class="profile-photoes">
        <?php
            require_once "User.php";
//            var_dump($data);
            if (!$data)
                echo "Photoes coming soon!";
            else
            {
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
                                <a href="/profile?id='.$user->getId().'">
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
</section>
