;(function ($, window, undefined) {
	$(function() {
		$.getJSON('https://alpha-api.app.net/stream/0/users/40838/posts', function(data) {
			data = data['data'][0];
			console.log(data);
			$('.appdotnet .post-content').html(function() {
			    var tweet = data['text'].replace(/[A-Za-z]+:\/\/[A-Za-z0-9-_]+\.[A-Za-z0-9-_:%&\?\/.=]+/g, function(url) { 
			        var wrap = document.createElement('div');
			        var anch = document.createElement('a');
			        anch.href = url;
			        anch.target = "_blank";
			        anch.innerHTML = url;
			        wrap.appendChild(anch);
			        return wrap.innerHTML;
			    });
			    tweet = tweet.replace(/(^|\s)@(\w+)/g, '$1<a href="http://alpha.app.net/$2" target="_blank">@$2</a>');
			    return tweet.replace(/(^|\s)#(\w+)/g, '$1<a href="http://alpha.app.net/hashtags/$2" target="_blank">#$2</a>');
			});
			$('.appdotnet .post-time a')
				.attr('href', data['canonical_url'])
				.text($.timeago(data['created_at']));
			$('.appdotnet .followers-count').text(data['user']['counts']['followers']);
		});
		
		$.getJSON('http://api.twitter.com/1/statuses/user_timeline/pandamonia.json?count=1&include_rts=true&exclude_replies=false&callback=?', function(data) {
			data = data[0];
			console.log(data);
			$('.twitter .post-content').html(function() {
			    var tweet = data['text'].replace(/[A-Za-z]+:\/\/[A-Za-z0-9-_]+\.[A-Za-z0-9-_:%&\?\/.=]+/g, function(url) { 
			        var wrap = document.createElement('div');
			        var anch = document.createElement('a');
			        anch.href = url;
			        anch.target = "_blank";
			        anch.innerHTML = url;
			        wrap.appendChild(anch);
			        return wrap.innerHTML;
			    });
			    tweet = tweet.replace(/(^|\s)@(\w+)/g, '$1<a href="http://twitter.com/$2" target="_blank">@$2</a>');
			    return tweet.replace(/(^|\s)#(\w+)/g, '$1<a href="http://search.twitter.com/search?q=%23$2" target="_blank">#$2</a>');
			});
			$('.twitter .post-time a')
				.attr('href', 'https://twitter.com/pandamonia/status/' + data['id_str'])
				.text($.timeago(data['created_at']));
			$('.twitter .followers-count').text(data['user']['followers_count']);
		});
	});
})(jQuery, this);