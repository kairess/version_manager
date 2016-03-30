<div id="main" class="pure-u-1 no-nav">
	<div class="email-content">
		<div class="email-content-header pure-g">
			<div class="pure-u-1-2">
				<h1 class="email-content-title">New post</h1>
				<p class="email-content-subtitle">
					Good luck!
				</p>
			</div>

			<div class="email-content-controls pure-u-1-2">
				<button class="secondary-button pure-button">Reply</button>
				<button class="secondary-button pure-button">Forward</button>
				<button class="secondary-button pure-button">Move to</button>
			</div>
		</div>

		<div class="email-content-body">
			<form class="pure-form pure-form-aligned" action="<?=base_url('main/upload_action')?>" method="post" enctype="multipart/form-data">
				<fieldset>
					<div class="pure-control-group">
						<label for="title" class="pure-u-1-4">Title</label>
						<input id="title" class="pure-u-3-4" type="text" placeholder="Title(optional)" name="title">
					</div>

					<div class="pure-control-group">
						<label for="version" class="pure-u-1-4">Version</label>
						<input id="version" class="pure-u-3-4" type="text" placeholder="14.008(optional)" name="version">
					</div>

					<div class="pure-control-group">
						<label for="tags" class="pure-u-1-4">Tags</label>
						<div class="pure-u-3-4">
							<a href="#" class="add-tag pure-button button-xsmall">펌웨어</a>
							<a href="#" class="add-tag pure-button button-xsmall">마스터</a>
							<a href="#" class="add-tag pure-button button-xsmall">슬레이브</a>
							<a href="#" class="add-tag pure-button button-xsmall">버그</a>
							<a href="#" class="add-tag pure-button button-xsmall">잡담</a>
						</div>
					</div>

					<div class="pure-control-group">
						<label for="tags" class="pure-u-1-4"></label>
						<ul id="tags" class="pure-u-3-4" style="margin-top:0px;"></ul>
						<div id="tag_list"></div>
					</div>

					<div class="pure-control-group">
						<label for="contents" class="pure-u-1-4">Contents</label>
						<textarea id="contents" class="pure-u-3-4" placeholder="Contents" rows="10" name="contents"></textarea>
					</div>

					<div class="pure-control-group">
						<label for="file" class="pure-u-1-4">File</label>
						<input id="file" type="file" class="pure-u-3-4" name="file">
					</div>

					<div class="pure-control-group">
						<label for="file" class="pure-u-1-4"></label>
						<div class="pure-u-3-4">
							<button type="submit" class="pure-button pure-button-primary">Post</button>
						</div>
					</div>
				</fieldset>
			</form>
		</div>
	</div>
</div>
<script type="text/javascript">
$(function() {
	var tag_source = [
<?php
	foreach($tags as $tag) :
?>
		"<?=$tag->tag?>",
<?php endforeach; ?>
	];

	$('#tags').tagit({
		fieldName: 'tags[]',
		autocomplete: {
			delay: 0,
			minLength: 1,
			source: tag_source,
			appendTo: '#tag_list'
		},
		showAutocompleteOnFocus: 1,
		// singleFieldDelimiter: "|",
		placeholderText: "Tags(optional)"
	});

	$('.add-tag').click(function(e) {
		e.preventDefault();
		$("#tags").tagit("createTag", $(this).text());
	})
});
</script>