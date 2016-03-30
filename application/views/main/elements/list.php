<?php
	foreach($posts as $post) :
?>
	<div class="email-item pure-g <?=$post->exist_files?'email-item-unread':''?>" data-post-id="<?=$post->id?>">
		<div class="pure-u">
			<img class="email-avatar" height="64" width="64" src="<?=get_profile_picture($post->user_id)?>">
		</div>

		<div class="pure-u-3-4">
			<h5 class="email-name"><?=get_username($post->user_id)?></h5>
			<h4 class="email-subject">
				<?=$post->title?> 
<?php
	if($post->exist_files) :
?>
					<span class="file_size">(<?=$post->file_size?:''?>)</span>
<?php endif; ?>
				<span class="version"><?=get_postmeta_value('version', $post->id)?></span>
			</h4>
			<p class="email-desc">
				<?=mb_substr($post->contents, 0, 50, 'UTF-8')?>
			</p>
			<p class="email-desc">
<?php
	foreach($post->tags as $tag) :
?>
		<button class="pure-button button-xsmall">
			<span class="email-label" style="background: <?='#' . get_hex($tag->tag)?>; margin:0 !important;"></span>
			<?=$tag->tag?>
		</button>
<?php endforeach; ?>
			</p>
		</div>
	</div>
<?php endforeach; ?>