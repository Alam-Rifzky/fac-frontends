<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?= $data->judul ?></title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
	<?php if (count($data->reqdbaccess)>0): ?>
		
	<?php include_once $data->homedir.'view/aolintegration/nav/nav-main-menu.php'; ?>
 	
	<?php endif ?>
	<div class="container-fluid p-5 bg-primary text-white text-center">
		<?php include_once $data->homedir.'view/aolintegration/fragments/headerone.php'; ?>
	</div>

	<?php if (count($data->reqaccess)>0): ?>
		
	
	<div class="container mt-3">
	  <h2>My Detail</h2>
	  <table class="table table-striped">
	    <thead>
	      <tr>
	        <th>Name</th>
	        <th>Workspace</th>
	        <th>Action</th>
	      </tr>
	    </thead>
	    <tbody>
	    <?php if (count($data->listdata)>0): ?>
	    	<?php foreach ($data->listdata as $key): ?>
	      	<tr>
	      		<td><?= $data->namauser ?></td>
	      		<td><?= $key['sworkspacename'] ?></td>
	      		<td><a href="<?= $data->requestaccesspage.$key['sid'] ?>" class="btn btn-secondary">Request Access</a></td>
	      	</tr>
	      <?php endforeach ?>
	    <?php else: ?>
	    	<tr><td class="text-center" colspan="3">No Available Data to Display, Please Register New API ID</td></tr>
	    <?php endif ?>
	      
	    </tbody>
	  </table>
	</div>
	<?php else: ?>
		<!-- <div class="container mt-3">
			<p>You currently do not have access to Request API Function</p>
		</div> -->
	<?php endif ?>

	<?php if (count($data->acccreate)>0): ?>
	<div class="container mt-3">
		<a href="<?= $data->registernewapipage ?>" class="btn btn-primary">Register New API</a>
	</div>
	<?php else: ?>
		<!-- <div class="container mt-3">
			<p>You currently do not have access to API Registration Function</p>
		</div> -->
	<?php endif ?>
	<br>
	<div class="container mt-3">
		<p>Tutorial Link: <a href="<?= $data->linktuts ?>" target="_blank">Click Me.</a></p>
	</div>

	<?php if (count($data->listdatabase)>0): ?>
		<div class="container mt-3 pt-3">
			<h3 class="text-center">Last Accessed DB</h3>
			<table class="table table-striped">
				<caption></caption>
				<thead>
					<tr>
						<th>Database Name</th>
						<th>Workspace</th>
						<th>Expired Until</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($data->listdatabase as $key): ?>
						<tr>
							<td><?= $key['sdbname'] ?></td>
							<td><?= $key['sworkspacename'] ?></td>
							<td><?= $key['dsessionexp'] ?></td>
							<td><a href="<?= $data->apimenupage.$key['id'] ?>">Go to API</a></td>
						</tr>
					<?php endforeach ?>
				</tbody>
			</table>
		</div>
	<?php else: ?>
		<!-- <div class="container mt-3">
			<p>No one accessed database in your workspace.</p>
		</div> -->	
	<?php endif ?>

	<?php if (count($data->activitylog)>0): ?>
		<div id="myactivities" class="container mt-3 pt-3">
			<h3 class="text-center">My Activities</h3>
			<table class="table table-striped">
				<caption></caption>
				<thead>
					<tr>
						<th>Document Name</th>
						<th>Feature</th>
						<th>Batch Number</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($data->activitylog as $key): ?>
						<tr>
							<td><?= $key['docname'] ?></td>
							<td><?= $key['tipe'] ?></td>
							<?php if (intval($key['total'])>0): ?>
								<td><a href="<?= $data->batchresponsedet.$key['batchid'] ?>"><?= $key['batchid'] ?></a></td>
								<td><a href="<?= $data->batchresponsedet.$key['batchid'] ?>">See Status</a></td>
							<?php else: ?>
								<td><?= $key['batchid'] ?></td>
								<td><a title="click to resume" href="<?= $data->resumeworkdbselectpage.$key['docname'].'/'.$key['batchid'] ?>">Unprocessed</a></td>
							<?php endif ?>
							
						</tr>
					<?php endforeach ?>
				</tbody>
			</table>
		</div>
	<?php endif ?>
	

</body>
</html>