<?php

/**
 * Copyright (C) 2015 FeatherBB
 * based on code by (C) 2008-2015 FluxBB
 * and Rickard Andersson (C) 2002-2008 PunBB
 * License: http://www.gnu.org/licenses/gpl.html GPL version 2 or higher
 */

use FeatherBB\Core\Url;

// Make sure no one attempts to run this script "directly"
if (!defined('FEATHER')) {
    exit;
}

?>
<div class="blockform">
	<h2><span><?php _e('Login') ?></span></h2>
	<div class="box">
		<form id="login" method="post" action="<?php echo $feather->urlFor('login') ?>" onsubmit="return process_form(this)">
			<input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">
			<div class="inform">
				<fieldset>
					<legend><?php _e('Login legend') ?></legend>
					<div class="infldset">
						<input type="hidden" name="form_sent" value="1" />
						<label class="conl required"><strong><?php _e('Username') ?> <span><?php _e('Required') ?></span></strong><br /><input type="text" name="req_username" size="25" maxlength="25" tabindex="1" /><br /></label>
						<label class="conl required"><strong><?php _e('Password') ?> <span><?php _e('Required') ?></span></strong><br /><input type="password" name="req_password" size="25" tabindex="2" /><br /></label>

						<div class="rbox clearb">
							<label><input type="checkbox" name="save_pass" value="1" tabindex="3" /><?php _e('Remember me') ?><br /></label>
						</div>

						<p class="clearb"><?php _e('Login info') ?></p>
						<p class="actions"><span><a href="<?php echo $feather->urlFor('register') ?>" tabindex="5"><?php _e('Not registered') ?></a></span> <span><a href="<?php echo $feather->urlFor('resetPassword') ?>" tabindex="6"><?php _e('Forgotten pass') ?></a></span></p>
					</div>
				</fieldset>
			</div>
			<p class="buttons"><input type="submit" name="login" value="<?php _e('Login') ?>" tabindex="4" /></p>
		</form>
	</div>
</div>