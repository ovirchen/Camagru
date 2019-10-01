
<section class="main-slider">
    <div class="profile">
        <div class="profile-info">
            <?php
            require_once "Photo.php";
            require_once "User.php";
                $photo = new Photo();
                if (isset($_GET['id'])) {
                    $result = $photo->getProfilePhoto($_GET['id']);
                    if (!$result)
                        $result['path'] = "images/profiles/takeapicture.jpg";
                    echo '<img class="profile-photo" src="/' . $result['path'] . '" alt=""> ';
                    $us = new User();
                    $us->getUserById($_GET['id']);
                    echo "<div class='username'>
                            <p>" . $us->getUsername() . "</p>
                          </div>";
                }
                else {
                    $user = $_SESSION['user'];
                    $result = $photo->getProfilePhoto($user['id']);
                    if (!$result)
                        $result['path'] = "images/profiles/takeapicture.jpg";
                    echo '<img class="profile-photo" src="/' . $result['path'] . '" alt=""> ';
                    echo "<div class='username'>
                            <p>" . $user['username'] . "</p>
                          </div>";
                }
                if (!isset($_GET['id']) || (isset($_SESSION['user']) && ($_SESSION['user']['id'] == $_GET['id']))) {
                    echo '<div>
                            <form action="http://localhost:8080/profile/edit" method="POST">
                                <button class="edit_profile">Edit profile</button>
                            </form>
                          </div>
                          <div class="add-photo">
                            <p>Load new picture:</p>
                            <form enctype = "multipart/form-data" action = "http://localhost:8080/profile/add_photo" method = "POST" >
                              <input type = "hidden" name = "MAX_FILE_SIZE" value = "300000" />
                              <input class="filename" name = "filename" type = "file" />
                              <input class="button" type = "submit" value = "OK" />
                           </form >
                          </div>';
                }
            ?>
        </div>
        <?php include 'application/views/profile_photoes.php'; ?>
    </div>
</section>

<!--<script type='text/javascript'>alert('THE GAME');</script>-->