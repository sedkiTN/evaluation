<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Evaluation</title>
	<meta name="description" content="" />
	<link href="dist/css/bootstrap.min.css" rel="stylesheet">

	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
	<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<script type="text/javascript" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
	<script>
		$(document).ready( function () {
			$('#myTable').DataTable({
				'processing': true,
		      	'serverSide': true,
		      	'serverMethod': 'post',
		      	'ajax': {
		          	'url':'server_processing.php'
		      	},
		      	'columns': [
		         	{ data: 'nom', orderable: true },
		         	{ data: 'dateAjout', orderable: true },
					{ data: 'nbJour', orderable: false },
		         	{ data: 'stock', orderable: false },
		         	{ data: 'ca', orderable: false }
		      	],
				"lengthMenu": [[2, 25, 50, -1], [2, 25, 50, "All"]],
				'order': [[1, 'desc']],
	            'paging': true,
				"pageLength": 2,
			});
		} );
	</script>
</head>
<body>
	<div class="container">
  		<div class="py-5 text-center">
    		<h2>Table des produits</h2>
  		</div>

		<div class="row">
			<div class="col-12 mb-4">
				<table class="table col" id="myTable">
					<thead>
						<tr>
							<th>Nom Produit</th>
							<th>Date d'ajout</th>
							<th>Depuis <small>(en jours)</small></th>
							<th>Stock</th>
							<th>Chiffre d'affaire</th>
						</tr>
					</thead>
				</table>
			</div>
		</div>
	</div>
	
	<footer class="my-5 pt-5 text-muted text-center text-small">
		<p class="mb-1">Sedki BEN ALI</p>
	</footer>
</body>
</html>