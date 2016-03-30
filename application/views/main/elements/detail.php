<div class="email-content-header pure-g">
	<div class="pure-u-1-2">
		<h1 class="email-content-title"><?=$post->title?></h1>
		<p class="email-content-subtitle">
			From <a><?=get_username($post->user_id)?></a> at <span><?=$post->date?></span>
		</p>
	</div>

	<div class="email-content-controls pure-u-1-2">
<?php
	foreach($post->tags as $tag) :
?>
		<button class="pure-button button-xsmall">
			<span class="email-label" style="background: <?='#' . get_hex($tag->tag)?>; margin:0 !important;"></span>
			<?=$tag->tag?>
		</button>
<?php endforeach; ?>
		<!-- <button class="secondary-button pure-button">Reply</button>
		<button class="secondary-button pure-button">Forward</button>
		<button class="secondary-button pure-button">Move to</button> -->
	</div>
</div>

<div class="email-content-body">
	<p>
<?php
	foreach($post->files as $file) :
?>
		<a href="<?=base_url('uploads/'.$file->name)?>"><?=$file->name?></a>
<?php endforeach; ?>
	</p>
	<p>
		<?=nl2br($post->contents)?>
	</p>

	<h2 style="margin-top:50px; margin-bottom:0;">Comments</h2>
<?php
	foreach($post->comments as $comment) :
?>
	<div class="pure-g">
		<div class="pure-u-2-24" style="margin-bottom:20px;">
			<img src="<?=get_profile_picture($comment->user_id)?>" width="60" height="60" />
		</div>
		<div class="pure-u-22-24">
			<?=get_username($comment->user_id)?> : <?=nl2br($comment->contents)?>
<?php
	foreach($comment->files as $file) :
?>
			<br>
			<span style="float:right;">
				<a href="<?=base_url('uploads/comment/'.$file->name)?>"><?=$file->name?></a>
			</span>
<?php endforeach; ?>
			<br>
			<span style="float:right;">
				<?=$comment->date?>
			</span>
		</div>
	</div>
<?php endforeach; ?>
	

	<p class="comment-container">
		<form class="pure-form pure-form-aligned" action="<?=base_url('main/comment_action')?>" method="post" enctype="multipart/form-data">
			<fieldset>
				<div class="pure-control-group">
					<label for="profile_picture" class="pure-u-1-5">
						<img src="<?=get_profile_picture($this->session->userdata('user_id'))?>" width="100" height="100">
					</label>
					<textarea class="pure-u-3-5" name="contents" rows="4"></textarea>
					<div class="pure-1" style="text-align:right;">
						<input type="file" name="file">
						<input type="hidden" name="post_id" value="<?=$post->id?>">
						<button type="submit" class="pure-button pure-button-primary pure-u-1-5">Comment</button>
					</div>
				</div>
			</fieldset>
		</form>
	</p>
</div>