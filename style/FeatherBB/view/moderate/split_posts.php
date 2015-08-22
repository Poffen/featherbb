<?php

/**
 * Copyright (C) 2015 FeatherBB
 * based on code by (C) 2008-2012 FluxBB
 * and Rickard Andersson (C) 2002-2008 PunBB
 * License: http://www.gnu.org/licenses/gpl.html GPL version 2 or higher
 */
 
// Make sure no one attempts to run this script "directly"
if (!defined('FEATHER')) {
    exit;
}

?>
<div class="blockform">
	<h2><span><?php _e('Split posts') ?></span></h2>
	<div class="box">
		<form id="subject" method="post" action="">
			<input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">
			<div class="inform">
				<fieldset>
					<legend><?php _e('Confirm split legend') ?></legend>
					<div class="infldset">
						<input type="hidden" name="posts" value="<?php echo implode(',', array_map('intval', array_keys($posts))) ?>" />
						<label class="required"><strong><?php _e('New subject') ?> <span><?php _e('Required') ?></span></strong><br /><input type="text" name="new_subject" size="80" maxlength="70" /><br /></label>
						<label><?php _e('Move to') ?>
						<br /><select name="move_to_forum">
								<?php echo $list_forums ?>
							</optgroup>
						</select>
						<br /></label>
						<p><?php _e('Split posts comply') ?></p>
					</div>
				</fieldset>
			</div>
			<p class="buttons"><input type="submit" name="split_posts_comply" value="<?php _e('Split') ?>" /> <a href="javascript:history.go(-1)"><?php _e('Go back') ?></a></p>
		</form>
	</div>
</div>