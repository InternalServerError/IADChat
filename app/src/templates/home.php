<!DOCTYPE html>
<html>
 
<head>
	<title>IAD T'chat</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
 
<body>
	<nav class="navbar navbar-dark bg-dark">
		<span class="navbar-brand mb-0 h1">IAD T'chat</span>
		<span><a class="btn btn-danger" href="/login/logout" role="button">Déconnexion</a></span>
	</nav>

	<div class="container-fluid">
		<div class="row">
			<div class="col-xl-8" id="messages-container" style="max-height: 85vh; overflow: hidden;">
				<ul class="list-group list-group-flush" id="messages-list" style="max-height: 85vh; overflow: auto;">
				<?php foreach ($messages as $message) {  ?>
					<li class="list-group-item">
						<div class="row">
							<div class="col-xl-3">
							    [<?php echo $message->getPostedAt() ?>]
								<?php echo $message->getAuthor() ?> 
							</div>
							<div class="col-xl-9">
								<?php echo $message->getText() ?>
							</div>
						</div>
					</li>
				<?php } ?>
				</ul>
			</div>
			<div class="col-xl-4 border-left" id="users-list" style="height:90vh;">
				<nav class="navbar navbar-light bg-light">
					<span class="navbar-brand mb-0 h1">Utilisateurs connectés</span>
				</nav>
				<ul class="list-group list-group-flush">
				<?php foreach ($users as $user) {  ?>
					<li class="list-group-item"><?php echo $user->getNickname() ?></li>
				<?php } ?>
				</ul>
			</div>
		</div>
		<div class="row">
			<div class="col-xl-8 fixed-bottom">
				<div class="input-group mb-3">
					<input type="text" class="form-control" placeholder="Message" aria-label="Message" aria-describedby="button-addon2" name="new-message">
					<div class="input-group-append">
						<button class="btn btn-outline-secondary" type="button" id="button-addon2">Envoyer</button>
					</div>
				</div>
			</div>
		</div>
	</div>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			let container = $("#messages-list");
			container[0].scrollTop = container[0].scrollHeight;

			setInterval(function() {
				$.ajax({
					url: 'message/messages',
					method: 'GET'
				})
				.done(function(data) {
					let container = $("#messages-list");
					let oMessages = $.parseJSON(data);

					let messages = "";
					for (let index in oMessages) {
						messages += 
							'<li class="list-group-item">'
								+ '<div class="row">'
									+ '<div class="col-xl-3">'
										+ '[' + oMessages[index].postedAt + ']' + ' '
										+ oMessages[index].author 
									+ '</div>'
									+ '<div class="col-xl-9">'
										+ oMessages[index].text
									+' </div>'
								+ '</div>'
							+ '</li>';
					}
					container.empty();
					container.html(messages);
					container[0].scrollTop = container[0].scrollHeight;
				});

				$.ajax({
					url: 'user/users',
					method: 'GET'
				})
				.done(function(data) {
					let oUsers = $.parseJSON(data);
					let container = $("#users-list > ul")

					let users = "";
					for (let index in oUsers) {
						users += '<li class="list-group-item">' + oUsers[index].nickname + '</li>'
					}
					container.empty();
					container.html(users);
				})
			}, 5000);
		});
		$("#button-addon2").on('click', function(event) {
			event.stopImmediatePropagation();
			event.preventDefault();
			let that = $(this);
			let message = that.parent().siblings("input[type=text]").val();

			if (message.length > 0) {
				$.ajax({
					url: 'message/new',
					method: 'POST',
					data: {
						text: that.parent().siblings("input[type=text]").val()
					}
				})
				.done(function(data) {
					data = $.parseJSON(data);
					that.parent().siblings("input[type=text]").val("");
					let newItem = 
						'<li class="list-group-item">'
							+ '<div class="row">'
								+ '<div class="col-xl-3">'
									+ '[' + data.postedAt + ']' + ' '
									+ data.author
								+ '</div>'
								+ '<div class="col-xl-8">'
									+ data.text
								+' </div>'
							+ '</div>'
						+ '</li>';
					$("#messages-list").append(newItem);

					let container = $("#messages-list");
					container[0].scrollTop = container[0].scrollHeight;
				})
			}
		});
	</script>
</body>
 
</html>