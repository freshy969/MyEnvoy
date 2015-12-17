<div id="social_icons">
    <div class="row">
        <div class="col ten">
            <a href="https://github.com/LaCodon/MyEnvoy" target="_blank" class="noa">
                <img src="/img/github-square-social-media.png" width="48" height="48" alt="MyEnvoy on GitHub">
            </a>
        </div>
    </div>
</div>
<div id="center_content" class="center">
    <div class="row">
        <div class="col ten center_txt">
            <h2><?php echo t('resetpw_h2'); ?></h2>
        </div>
    </div>
    <div class="row">
        <form action="/<?php echo APPLICATION_LANG . '/index/resetpwform.do' ?>" method="post">
            <div class="col ten">
                <div class="form_group">
                    <input type="hidden" id="email" name="email" required value="<?php echo Security::htmloutput($this->email); ?>">
                    <input type="hidden" id="hash" name="hash" required value="<?php echo Security::htmloutput($this->hash); ?>">
                </div>
                <div class="form_group">
                    <label for="newpw"><?php echo t('resetpwform_newpwd'); ?></label>
                    <input type="password" id="newpw" name="newpw" placeholder="<?php echo t('resetpwform_newpwd'); ?>" required pattern=".{8,}">
                </div>
                <div class="form_group">
                    <input class="btn btn_success right" type="submit" value="<?php echo t('resetpwform_btn_reset'); ?>">
                </div>
            </div>
        </form>
    </div>
    <div class="row margin">
        <div class="col five">
            <a href="/<?php echo APPLICATION_LANG ?>" class="ash5"><?php echo t('register_link_login') ?></a>
        </div>
        <div class="col five">
            <a href="/<?php echo APPLICATION_LANG ?>/register" class="right ash5"><?php echo t('login_link_register') ?></a>
        </div>
    </div>
</div>