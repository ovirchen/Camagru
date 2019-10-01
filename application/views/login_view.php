
<section class="main-slider">
    <div class="registration">
        <form class="login" action="login/login" method="POST">
            <div>
                <label for="username">Username</label>
                <input id="username" type="text" name="username" value="" maxlength=30
                       placeholder="username" required>
            </div>
            <div>
                <label for="password">Password</label>
                <input id="password" type="password" name="password" value="" minlength=6 maxlength=255 required
                       placeholder="******">
            </div>
            <div class="forgot_password">
                <a href="register/reset_password">Click here if you forgot your password...</a>
            </div>
            <div>
                <input class="button" type="submit" value="OK">
            </div>
            <div class="ifyouwant">
                <a href="register">If you want to register...</a>
            </div>
        </form>
    </div>
</section>