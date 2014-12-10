
<!-- journal view -->

{{ post }}

{{ if category }}
<article  itemscope itemtype="http://schema.org/{{ category:itemscope }}">
	{{else}}
	<article  itemscope itemtype="http://schema.org/Article">
		{{endif}}
		<h3 itemprop="name">{{ title }}</h3>
		<h6>{{ helper:lang line="journal:written_by_label" }} <strong  itemprop="author">{{ created_by:display_name }}</strong>, <time class="timeformat" itemprop="datePublished" datetime="{{ helper:date format="Y-m-d H:i:s" timestamp=created_on }}">
			{{ helper:date timestamp=created_on }}
		</time></h6>

		<div class="row" style="display:inline;">
			{{if teaser_image == ''}}

			<div class="preview postHead">
				{{ teaser }}
			</div>
			{{else}}

			<div class="preview  postHead">
				<img src="{{ url:site }}files/large/{{ teaser_image:id }}" alt="{{ teaser_image:name }}" class="img teaserImg-{{teaser_image_displ_prop:key}}"/>
				{{ teaser }}
			</div>

			{{endif}}
		</div> <!-- /row --> 

		<div class="post_body">
			{{ body }}
		</div>
		<h5><a href="{{ session:data name="journal_backlink" }}#{{slug}}" title="Back to the journal">&larr; Zur&uuml;ck</a></h5>

		<div class="post_meta">
			{{ if keywords }}
			<div class="keywords">
				{{ keywords }}
				<span class="label secondary radius"><a href="{{ url:site }}journal/tagged/{{ keyword }}">{{ keyword }}</a></span>
				{{ /keywords }}
			</div>
			{{ endif }}
		</div>
	</article>
	{{ /post }}

	<?php if (Settings::get('enable_comments')): ?>

	<div id="comments">
		<br>

		<div id="existing-comments">
			<h4><?php echo lang('comments:title') ?></h4>
			<?php echo $this->comments->display() ?>
		</div>

		<?php if ($form_display): ?>

		{{ if session:messages != ''}}

			<script type="text/javascript">//<![CDATA[
			window.location.href = "{{ url:current }}#commentsMsg";
			//]]></script>

			<span id="commentsMsg">
				{{ session:messages success="commentsMsg label success radius medium-5 small-12" notice="commentsMsg label notice radius medium-5 small-12" error="commentsMsg label alert warning radius medium-5 small-12" }}
			</span>
			{{ endif }}

			<?php echo $this->comments->form() ?>

		</div>
	<?php else: ?>
	<?php echo sprintf(lang('journal:disabled_after'), strtolower(lang('global:duration:'.str_replace(' ', '-', $post[0]['comments_enabled'])))) ?>
		</div> <!-- kommentar fix -->
<?php endif ?>

<?php endif ?>


