<!DOCTYPE html>
<html>
<body>
<style>
progress {
-webkit-appearance: none; -moz-appearance: none; appearance: none;height: 40px; width: 800px; border-radius: 10px;
}
progress::-webkit-progress-value {
  background-color: green;
  border-radius: 0px;
}
progress::-moz-progress-bar {
  background-color: green;
  border-radius: 0px;
}

</style>
<h1>The progress element</h1>

<label for="file">Downloading progress:</label>
<progress id="file" value="50" max="100"> 32% </progress>

<script>
</script>

</body>
</html>

