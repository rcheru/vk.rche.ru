jQuery.fn.spoiler = function(userspoiler) {
	var options = {
		setclass : '',
		title : false,
		onlink : false
	}
	jQuery.extend(options, userspoiler);
	var title = "", text = "", css = false;
	getTitle = function(obj) {
		if (!options.title) {
			title = obj.children("span").text();
		} else {
			title = obj.attr("title");
		}
		return title;
	}
	getText = function(obj) {
		if (!options.onlink) {
			text = obj.text();
		} else {
			text = obj.attr("spoiler");
		}
		return text;
	}
	chekTitle = function(title, text) {
		if (title == "") {
			var words = text.split(" ");
			for (i = 0; i < words.length; i++)
				if (words[i] != "" && words[i] != "\n") {
					title = words[i];
					words.length = i - 1;
				}
		}
		return title;
	}
	return this
			.each(function() {
				if (!css) {
					jQuery("head")
							.append(
									"<style>.spoiler {display: none;} .link {display: block; cursor: pointer;}</style>");
					css = true;
				}
				obj = jQuery(this);
				title = getTitle(obj);
				text = getText(obj);
				title = chekTitle(title, text);
				obj.addClass("link").html(title).after(
						"<p class=\"spoiler " + options.setclass + "\">" + text
								+ "</p>");
			});
};
jQuery(".link").live("click", function() {
	jQuery(this).next("p.spoiler").slideToggle();
	return false;
});