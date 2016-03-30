<div id="list" class="pure-u-1">

</div>

<div id="main" class="pure-u-1">
	<div class="email-content">
		
	</div>
</div>

<script type="text/javascript">
var page = 1;
var loading_list = false;
var selected_tags = [];

$(function() {
	load_list(page);
	callbacks();

	setTimeout(function() {
		$('.email-item').first().click();
	}, 1000);

	$('#list').scroll(function() {
		if(!loading_list) {
			if(($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight)) {
				load_list(++page);
			}
		}
	});

	$('.tag-list').click(function(e) {
		e.preventDefault();
		var tag = $(this).data('tag');
		$(this).toggleClass('active');

		if(index = $.inArray(tag, selected_tags) >= 0) {
			selected_tags.splice(index, 1);
		} else {
			selected_tags.push(tag);
		}

		page = 1;
		$('#list').empty();
		load_list(page);
	});

	$('.tag-list-all').click(function(e) {
		e.preventDefault();
		$('.tag-list').removeClass('active');
		selected_tags = [];

		page = 1;
		$('#list').empty();
		load_list(page);
	});
});

function load_list(page) {
	loading_list = true;

	var data = {
		page: page,
		selected_tags: selected_tags
	};

	$.ajax({
		url: "<?=base_url('main/get_list')?>",
		type: 'POST',
		dataType : "html",
		data: data,
		success: function(res) {
			$('#list').append(res);
			callbacks();
			loading_list = false;
		}
	});
}

function callbacks() {
	$('.email-item').unbind('click').bind('click', function() {
		$('.email-item').removeClass('email-item-selected');
		$(this).addClass('email-item-selected');
		var post_id = $(this).data('post-id');
		var href = '<?=base_url('main/detail?post_id=')?>' + post_id;
		$('.email-content').empty();
		$('.email-content').load(href);
	});
}
</script>