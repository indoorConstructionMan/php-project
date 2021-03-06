<div class="row">
    <div class="col s4 offset-s4 padding5 min-width-400">
        <form method="post" action="login" autocomplete="off" class="slidein-top-components">
            <div class="row">
                <div class="col s12">
                    <div class="center promo promo-example">
                        <i class="material-icons moss emerald-text icon">lock_open</i>
                    </div>
                </div>
            </div>
            <div class="row"> 
                <div class="input-field col s12">
                    <input class="clouds-text moss-border bold flow-text" id="email" type="text" name="email" value="<?= (isset($_SESSION['view_vars']['data']['email'])) ? $_SESSION['view_vars']['data']['email'] : ''; ?>" required>
                    <label for="email" class="moss-text flow-text">email address or username</label>
                </div>
            </div>
            <div class="row"> 
                <div class="input-field col s12">
                    <input class="clouds-text moss-border bold flow-text" id="password" type="password" name="password" required>
                    <label for="password" class="moss-text flow-text">password</label>
                </div>
            </div>
            <? require('/View/_partials/error_message.php'); ?>
            <div class="row">
                <button type="submit" class="col s12 moss-text bold pulse-text-shadow hvr-buzz" style="">login</button>
                <a href="register" class="form-link moss-text" style="">click here to create an account</a>
                <a href="guest_login" class="form-link clouds-text" style="">sign in as guest</a>
            </div>
        </form>
    </div>
</div>


