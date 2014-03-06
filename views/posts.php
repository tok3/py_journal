	

<h3>{{ category:title }}</h3>


{{ if posts }}
{{ posts }}
{{ session:data name="journal_backlink" value=url:current }}

<div class="post">

	<h3 id="{{ slug }}">{{ theme:image file="link.png" }} <a href="{{ url }}">{{ title }}</a></h3>
	<div class="meta">

		<div class="date">
			<h6>{{ helper:lang line="journal:posted_label" }}
				<strong>{{ helper:date timestamp=created_on }}</strong>
			</h6>
		</div>

		{{ if category }}
		<div class="category">
			<h6>
				{{ helper:lang line="journal:category_label" }}
				<span><a href="{{ url:site }}journal/category/{{ category:slug }}">{{ category:title }}</a></span>
			</h6>
		</div>
		{{ endif }}

	</div> <!-- /meta -->
	<div class="row"  style="display:inline;">
		{{if teaser_image == ''}}
		<div class="preview">{{ teaser }}
		</div>
		{{else}}
		<div class="preview">
			<img src="{{ url:site }}files/large/{{ teaser_image:id }}" alt="{{ teaser_image:name }}" class="img teaserImg-{{teaser_image_displ_prop:key}}"/>
			{{ teaser }}
		</div>

		{{endif}}
	</div> <!-- /row --> 
	<h5 class="right"><a href="{{ url }}">{{ helper:lang line="journal:read_more_label" }}</a></h5>
	<br>
	<div class="post_meta">
		{{ if keywords }}
		<div class="keywords">
			{{ keywords }}

			<span class="label secondary radius"><a href="{{ url:site }}journal/tagged/{{ keyword }}">{{ keyword }}</a></span>
			{{ /keywords }}
		</div>
		{{ endif }}
	</div>

	<hr>
</div>
{{ /posts }}
{{ else }}

{{ helper:lang line="journal:currently_no_posts" }}

{{ endif }}
{{ pagination }}
