$(function() {
	var noClick = function() {
		$(this).click(function() { return false; })
	}

	miAjax.setup('.halfWidthLeft', {
		selector: '#paging a',
	});

	$(".draggableItems li")
		.live("mouseover", function() {
			if (!$(this).data("init")) {
				$(this).data("init", true);
				$(this).draggable({
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

	$(".droppable ol")
		.sortable()
		.droppable({
			drop: function(event, ui) {
				$(ui.draggable)
					.clone(false)
					.attr('style', '')
					.appendTo(this)
					.unbind()
					.effect("highlight", {}, 3000)
					.siblings('li.empty').hide();
			}
		});
	$(".droppable li")
		.droppable({
			accept: '.draggableItems li',
			greedy: true,
			hoverClass: 'ui-state-active',
			drop: function(event, ui) {
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
});