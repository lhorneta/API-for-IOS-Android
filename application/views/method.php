<div class="container">

	<div id="content">
		<div class="row">
		  <div class="col-md-3 sidebar">
		  	<?php $this->load->view('sidebar', $sidebar); ?>
		  </div>
		  <div class="col-md-9 content">
		  	<h3><?=$method['method']?></h3>
		  	<p class="lead"><?=$method['description']?></p>
		  	
		  	<div class="well well-sm"><span class="label label-primary method"><?=$method['transmethod']?></span> /<?=$method['method']?></div>
		  	
		  	<h4>Example</h4>
		  	<p class="text-primary"><?=base_url()?><?=$method['method']?></p>
		  	<?php $params = unserialize($method['parameters']); ?>
		  	<h4>Params</h4>
		  	<table class="table">
				<thead>
					<tr>
						<td><b>Param</b></td>
						<td><b>Descriptions</b></td>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($params as $k => $p) { ?>
					<tr>
						<td><?=$k?></td>
						<td><?=$p?></td>
					</tr>	
					<?php } ?>
				</tbody>
			</table>
			<?php $success_response = $this->Tools->processresponse($method['success_response']); ?>
			<h4>Success response for example:</h4>
		  	<pre class="code"><?=$success_response?></pre>
		  	<br>
		  	<?php $error_response = $this->Tools->processresponse($method['error_response']); ?>
			<h4>Error response for example:</h4>
		  	<pre class="code"><?=$error_response?></pre>
		  	<br>
		  	<?php $errors = explode(",", $method['errors']); ?>
		  	<h4>Possible errors in response:</h4>
		  	<table class="table">
				<?php foreach ($errors as $k => $e) { ?>
				<tr>
					<td><b><?=$k+1?>.</b> <?=$e?></td>
				</tr>	
				<?php } ?>
			</table>
		  </div>
		  
		</div>
	
	</div>
</div>