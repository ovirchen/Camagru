
<section class="main-slider">
    <div class="photoes">
        <?php
            require_once "User.php";
//            var_dump($data);
            if (!$data)
                echo "Photoes coming soon!";
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
</section>
