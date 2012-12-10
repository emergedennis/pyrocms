<div class="nivo-container">

	{{ if items_exist == false }}
		<p>There are no items.</p>
	{{ else }}
		<div class="nivo-data">
			<table cellpadding="0" cellspacing="0">
				<tr>
					<th>{{ helper:lang line="nivo:name" }}</th>
					<th>{{ helper:lang line="nivo:slug" }}</th>
				</tr>
				<!-- Here we loop through the $items array -->
				{{ items }}
				<tr>
					<td>{{ name }}</td>
					<td>{{ slug }}</td>
				</tr>
				{{ /items }}
			</table>
		</div>
	
		{{ pagination:links }}
	
	{{ endif }}
	
</div>