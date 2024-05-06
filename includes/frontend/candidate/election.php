<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Animated Card</title>
  <style>
    .card-container {
	   display: grid;
	   grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
	   grid-gap: 50px;
	   justify-content: center;
      align-items: center;
      height: max-content;
		width: 85%;
		background-color: blue;
		margin: auto;
		/* padding: 50px; */
    }

    .card {
      height: 400px;
      background-color: #fff;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      border-radius: 8px;
      overflow: hidden;
      transition: transform 0.3s, filter 0.3s;
		margin: 50px;
      width: 300px;
		display: inline-block;
    }

    .card.highlight {
      transform: scale(1.1);
    }

    .card.highlight:nth-child(2) {
      animation: highlight 1s ease-in-out 1 forwards;
      filter: none;
    }

    @keyframes highlight {
      0% {
        transform: scale(1);
      }
      50% {
        transform: scale(1.1);
      }
      100% {
        transform: scale(1);
      }
    }
  </style>
</head>
<body>
  <div class="card-container">
    <div class="card"></div>
    <div class="card"></div>
    <div class="card"></div>
    <div class="card"></div>
    <div class="card"></div>
    <div class="card"></div>
    <div class="card"></div>
    <div class="card"></div>
    <div class="card"></div>
    <div class="card"></div>
    <div class="card"></div>
  </div>

  <script>
    window.addEventListener('load', function() {
      const cards = document.querySelectorAll('.card');
      cards[1].classList.add('highlight');
    });
  </script>
</body>
</html>

