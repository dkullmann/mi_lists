$(function() {
	var templates = {
		dropRow: '<li id="Row-<%id%>" class="ui-droppable"><a href="<%url%>"><%title%></a><ul class="actions tree-options"><li class="ui-droppable"><a class="mini-icon mini-close" href="#">x</a></li></ul></li>'
	};

	var callbacks = {
/**
 * ONLY show a flash message
 */
	flashMessage: function (data) {
			if (typeof (data.message) === "undefined") {
				return;
			}
			var isError = (data.returnCode === '0')?' error':'';
			var message = $('<div class="statusMessage message' + isError + '">' + data.message + '</div>')
				.hide()
				.prependTo('#content')
				.show("slide", { direction: "up" }, 1000)
				.effect("highlight", {}, 3000)
				.hide("slide", { direction: "up" }, 1000);
			return false;
		},

		homePreview: function (data) {
			el = $('<div><iframe src="' + data.data + '" width="100%" height="100%" frameborder=0 ></iframe></div>');
			el
				.appendTo('body')
				.dialog({
					title: data.message,
					width: 1100,
					height: 500
				});
			$.unblockUI();
			return false;
		}
	}

	var noClick = function() {
		$(this).click(function() { return false; })
	}

	var addRow = function(id, ol, after) {
		$(ui.draggable)
			.clone(false)
			.attr('style', '')
			.appendTo(ol)
			.unbind()
			.effect("highlight", {}, 3000)
			.siblings('li.empty').hide();
	}

	miAjax.setup('.halfWidthLeft', {
		selector: '#paging a',
	});

	$(".draggableItems li ul.tree-options").hide();
	$("ul.tree-options li a.mini-arrowthick-1-n, ul.tree-options li a.mini-arrowthick-1-s", "div.halfWidthRight").each(function() {
		$(this).parent().hide();
	});

	$(".draggableItems li")
		.live("mouseover", function() {
			if (!$(this).data("init")) {
				$(this).data("init", true);
				$(this).draggable({
					greedy: true,
					containment: '#main',
					scroll: false,
					revert: true,
					activeClass: 'ui-state-hover',
					start: function() {
						$(this).bind('click', noClick);
					},
					stop: function() {
						$(this).css('position', 'relative');
						$(this).unbind('click', noClick);
					}
				});
			}
	});

	$(".droppable, .droppable h3, .droppable ol")
		.droppable({
			accept: '.draggableItems li',
			greedy: true,
			drop: function(event, ui) {
				if ($(this).hasClass('droppable')) {
					var div = $(this);
				} else {
					var div = $(this).parents('div.droppable', ui.draggable);
				}
				var ol = div.children('ol');
				//addRow(ui.draggable, ol);
				//return;

				$(ui.draggable)
					.clone(false)
					.attr('style', '')
					.appendTo(ol)
					.unbind()
					.effect("highlight", {}, 3000)
					.siblings('li.empty').hide();
			}
		});

	$(".droppable ol").sortable()
	$(".droppable li")
		.droppable({
			accept: '.draggableItems li',
			greedy: true,
			hoverClass: 'ui-state-active',
			drop: function(event, ui) {
				//addRow(ui.draggable, false, this);
				//return;

				var clone = $(ui.draggable);
				$(ui.draggable)
					.clone(false)
					.unbind()
					.attr('style', '')
					.insertAfter(this)
					.effect("highlight", {}, 3000)
					.siblings('li.empty').hide();
			}
		});

	$("a.mini-close").click(function() {
		$.get($(this).attr('href'));
		$(this).parents('li.ui-droppable').hide("slide", { direction: "up" }, 1000);
		return false;
	});

	$("#MiListsSave").submit(function() {
		$.blockUI();
		var results = {};
		$('.halfWidthRight div ol').each(function() {
			var section = $(this).attr('id').replace('section-', '');
			$(this).children().each(function() {
				var id = $(this).attr('id').replace('Row-', '');
				results["data[" + section + "][" + id + "]"] = id;
			});
		});
		results["submit"] = 'Grabar';
		$.ajax({
			type: 'POST',
			url: $(this).attr('action') + '.json',
			data: results,
			success: function (data) {
				if (typeof(data) === "string") {
					$('this').html(data);
					return false;
				}
				if (typeof (callbacks[data.callback]) === 'function' && callbacks[data.callback](data) === false) {
					return;
				}
				callbacks.flashMessage(data);
				if (data.result == 'success') {
				} else {}
				$.unblockUI();
			},
			dataType: 'json'
		});
		return false;
	});

	$("a#MiListsPreview").click(function() {
		$.blockUI();
		var results = {};
		$('.halfWidthRight div ol').each(function() {
			var section = $(this).attr('id').replace('section-', '');
			$(this).children().each(function() {
				var id = $(this).attr('id').replace('Row-', '');
				results["data[" + section + "][" + id + "]"] = id;
			});
		});
		results["submit"] = 'Preview';
		$.ajax({
			type: 'POST',
			url: $(this).attr('href').replace('_preview', '') + '.json',
			data: results,
			success: function (data) {
				if (typeof(data) === "string") {
					$('this').html(data);
					return false;
				}
				if (typeof (callbacks[data.callback]) === 'function' && callbacks[data.callback](data) === false) {
					return;
				}
				callbacks.flashMessage(data);
				if (data.result == 'success') {
				} else {}
				$.unblockUI();
			},
			dataType: 'json'
		});
		return false;
	});
});