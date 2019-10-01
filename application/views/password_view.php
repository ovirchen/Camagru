
<section class="main-slider">
    <div class="registration">
        <?php
        echo '<form class="login" action="http://localhost:8080/register/new_password" method="POST">
                <input name="id" value="' . $data['id'] . '" type="hidden">'; ?>
            <div>
                <label for="password">New password</label>
                <input id="password" type="password" name="password" value="" minlength=6 maxlength=255 required
                       placeholder="******">
            </div>
            <div>
                <label for="password">Repeat password</label>
                <input id="password2" type="password" name="password2" value="" minlength=6 maxlength=255 required
                       placeholder="******">
            </div>
            <div>
                <input class="button" type="submit" value="OK">
            </div>
        </form>
    </div>
</section>
