
<section class="main-slider">
    <div class="registration">
        <!--        <div id="createBox" style="display: none;">-->
        <div id="createBoxContent">
            <form class="" action="main/register" method="POST">
                <div>
                    <label for="username">Username*</label>
                    <input id="username" type="text" name="username" value="" maxlength=30
                           placeholder="username" required>
                </div>
                <div>
                    <label for="firstname">First name</label>
                    <input id="firstname" type="text" name="firstname" value="" maxlength=255
                           placeholder="first name">
                </div>
                <div>
                    <label for="lastname">Last name</label>
                    <input id="lastname" type="text" name="lastname" value="" maxlength=255
                           placeholder="last name">
                </div>
                <div>
                    <label for="email">Email</label>
                    <input id="email" type="email" name="email" value="" maxlength=255
                           placeholder="email@.com">
                </div>
                <div>
                    <label for="password">Password</label>
                    <input id="password" type="password" name="password" value="" minlength=6
                           maxlength=255 placeholder="******" required>
                </div>
                <div>
                    <input class="button" type="submit" value="OK">
                </div>
            </form>
        </div>
        <!--        </div>-->
    </div>
</section>
