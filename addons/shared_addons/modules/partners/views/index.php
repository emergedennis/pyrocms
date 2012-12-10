<div class="partners-container">

	{{ if items_exist == false }}
		<p>There are no items.</p>
	{{ else }}
		<div class="partners-data">
			<h2>Partners</h2>

			{{ items }}
			<div class="row">
				<div class="span2">
					<img src="<?php echo BASE_URL.UPLOAD_PATH.'partners/{{ img }}'; ?>">
				</div>
				<div class="span10">
					<h4>{{ title }}</h4>
					<div class="partner-desc">
					<p>{{ desc }}</p>
					</div>
					<div class="partner-url">
					<a href="{{ url }}" target="_blank">Visit Partner Website</a>
					</div>
				</div>
			</div>
			<hr>
			{{ /items }}




			
		</div>
	
		{{ pagination:links }}
	
	{{ endif }}
	
</div>