<?php
session_start; //Session started
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1, width=device-width, height=device-height, shrink-to-fit=no" />

	<link rel="stylesheet" type="text/css" href="style.css">

	<!--Bootstrap & Font Awesome CSS-->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">

	<!--JQuery & JQuery Mobile JS-->
	<script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
	<script src="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>

	<!--Hide the Loading text-->
	<script>
		$.mobile.loading().hide();

	</script>
</head>

<body>

	<script>
		$("body").css({
			"overflow": "hidden",
			'position': 'fixed'
		});

	</script>

	<section class="container-global">
		<div class="container-status">
			<div class="row align-items-center h-100">
				<div class="col-3">
					<img class="img" src="images/moral2.png" />
				</div>
				<div class="col-3">
					<img class="img" src="images/moral2.png" />
				</div>
				<div class="col-3">
					<img class="img" src="images/moral2.png" />
				</div>
				<div class="col-3">
					<img class="img" src="images/moral2.png" />
				</div>

			</div>
		</div>



		<div class="container-content">
			<div class="container-text">
				<p>Quam ob rem cave Catoni anteponas ne istum quidem ipsum, quem Apollo, ut ais, sapientissimum iudicavit.</p>
			</div>

			<div class="container-cards">
				<div class="demo__card">
					<img class="demo__card__img" style="display: block;" src="images/card3.png" />
					<div class="demo__card__choice m--reject"></div>
					<div class="demo__card__choice m--like"></div>
					<div class="demo__card__drag"></div>
				</div>
				<div class="demo__card">
					<img class="demo__card__img" style="display: block;" src="images/Card2.png" />
					<div class="demo__card__choice m--reject"></div>
					<div class="demo__card__choice m--like"></div>
					<div class="demo__card__drag"></div>
				</div>
				<div class="demo__card">
					<img class="demo__card__img" style="display: block;" src="images/card1.png" />
					<div class="demo__card__choice m--reject"></div>
					<div class="demo__card__choice m--like"></div>
					<div class="demo__card__drag"></div>
				</div>
			</div>
		</div>



		<div class="container-footer">
			<div class="row align-items-center h-50">
				<div class="col-7">

					<h4 id="name">
						<?php
						$_SESSION["username"] = $_POST["username"];
						echo $_SESSION["username"];
						?>
					</h4>

				</div>
				<div class="col-5">
					<h3 id="year">2019</h3>
				</div>
			</div>

			<div class="row">
				<div class="col-7">
					<div id="duration">
						<h4><b>
								<?php
									$_SESSION["score"] = 0;
									echo $_SESSION["score"]; 
								?>
							</b> years</h4>
					</div>
				</div>
				<div class="col-5">
					<div id="row-status" class="row">
						<div class="col-3 box">1</div>
						<div class="col-3 box">2</div>
						<div class="col-3 box">3</div>
						<div class="col-3 box">4</div>
					</div>
				</div>

			</div>
		</div>


	</section>




	<script>
		$(document).ready(function() {

			var animating = false;
			var cardsCounter = 0;
			var numOfCards = 3;
			var decisionVal = 140;
			//80
			var pullDeltaX = 0;
			var deg = 0;
			var $card, $cardReject, $cardLike;

			function pullChange() {
				animating = true;
				deg = pullDeltaX / 10;
				$card.css("transform", "translateX(" + pullDeltaX + "px) rotate(" + deg + "deg)");

				var opacity = pullDeltaX / 100;
				var rejectOpacity = (opacity >= 0) ? 0 : Math.abs(opacity);
				var likeOpacity = (opacity <= 0) ? 0 : opacity;
				$cardReject.css("opacity", rejectOpacity);
				$cardLike.css("opacity", likeOpacity);
			};

			function release() {

				if (pullDeltaX >= decisionVal) {
					$card.addClass("to-right");
				} else if (pullDeltaX <= -decisionVal) {
					$card.addClass("to-left");
				}

				if (Math.abs(pullDeltaX) >= decisionVal) {
					$card.addClass("inactive");

					setTimeout(function() {
						$card.addClass("below").removeClass("inactive to-left to-right");
						cardsCounter++;
						if (cardsCounter === numOfCards) {
							cardsCounter = 0;
							$(".demo__card").removeClass("below");
						}
					}, 300);
				}

				if (Math.abs(pullDeltaX) < decisionVal) {
					$card.addClass("reset");
				}

				setTimeout(function() {
					$card.attr("style", "").removeClass("reset")
						.find(".demo__card__choice").attr("style", "");

					pullDeltaX = 0;
					animating = false;
				}, 300);
			};

			$(document).on("mousedown touchstart", ".demo__card:not(.inactive)", function(e) {
				if (animating) return;

				$card = $(this);
				$cardReject = $(".demo__card__choice.m--reject", $card);
				$cardLike = $(".demo__card__choice.m--like", $card);
				var startX = e.pageX || e.originalEvent.touches[0].pageX;

				$(document).on("mousemove touchmove", function(e) {
					var x = e.pageX || e.originalEvent.touches[0].pageX;
					pullDeltaX = (x - startX);
					if (!pullDeltaX) return;
					pullChange();
				});

				$(document).on("mouseup touchend", function() {
					$(document).off("mousemove touchmove mouseup touchend");
					if (!pullDeltaX) return; // prevents from rapid click events
					release();
				});
			});

		});

	</script>

</body>

</html>
