
<section class="main-slider">
    <div class="profile">
        <div class="profile-info">
            <?php
            require_once "Photo.php";
            require_once "User.php";
            $photo = new Photo();
            if (isset($_SESSION['user'])) {
                $result = $photo->getProfilePhoto($_SESSION['user']['id']);
                if (!$result)
                    $result['path'] = "images/profiles/takeapicture.jpg";
                echo '<img class="profile-photo" src="/' . $result['path'] . '" alt="">';
                echo '<div class="username">
                            <p>' . $_SESSION['user']['username'] . '</p>
                       
                          </div>
                          <div>
                              <form action="http://localhost:8080/profile/delete" method="POST">
                                    <button class="delete_profile">Delete profile</button>
                              </form>
                          </div>
                          <div class="add-photo">
                            <p>New profile picture:</p>
                            <form enctype = "multipart/form-data" action = "http://localhost:8080/profile/add_profile_photo" method="POST" >
                              <input type = "hidden" name = "MAX_FILE_SIZE" value = "300000" />
                              <input class="filename" name = "filename" type = "file" />
                              <input class="button" type = "submit" value = "OK" />
                           </form >
                          </div>
         </div>';
            }


            echo '<div class="profile-photoes">
                      <form class="login" action="http://localhost:8080/register/edit" method="POST">
                        <div>
                            <label for="username">New username</label>
                            <input id="username" type="text" name="username" value="" maxlength=30
                                   placeholder="'. $_SESSION['user']['username'] .'">
                        </div>
                        <div>
                            <label for="firstname">New first name</label>
                            <input id="firstname" type="text" name="firstname" value="" maxlength=255
                                   placeholder="';
                            if ($_SESSION['user']['firstname'] != "")
                                echo $_SESSION['user']['firstname'];
                            else
                                echo "none";
                            echo '">
                        </div>
                        <div>
                            <label for="lastname">New last name</label>
                            <input id="lastname" type="text" name="lastname" value="" maxlength=255
                                   placeholder="';
                            if ($_SESSION['user']['lastname'] != "")
                                echo $_SESSION['user']['lastname'];
                            else
                                echo "none";
                            echo '">
                        </div>
                        <div>
                            <label for="email">New email</label>
                            <input id="email" type="email" name="email" value="" maxlength=255
                                   placeholder="' . $_SESSION['user']['email'] . '">
                        </div>
                        <div>
                            <label for="password">New password</label>
                            <input id="password" type="password" name="password" value="" minlength=6
                                   maxlength=255 placeholder="******">
                        </div>
                        <div>
                            <label for="password2">New password again</label>
                            <input id="password2" type="password" name="password" value="" minlength=6
                                   maxlength=255 placeholder="******">
                        </div>
                        <div>
                            <input class="button" type="submit" value="OK">
                        </div>
                    </form>
                </div>';?>
    </div>
</section>
<script src="/js/profile.js" type="text/javascript"></script>
