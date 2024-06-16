<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Page with sidebar-page</title>
  <style>
.sidebar-page { grid-area: menu; }
.main-content { grid-area: main; }

.container {
  display: grid;
  grid-template-areas:
    'footer footer footer footer menu';
  gap: 10px;
  background-color: #2196F3;
  padding: 10px;
}

.grid-container > div {
  background-color: rgba(255, 255, 255, 0.8);
  text-align: center;
  padding: 20px 0;
  font-size: 30px;
}
	
  </style>
</head>
<body>
  <div class="container">
    <div class="main-content">
      <h2 id="election">Main Content</h2>
      <p>This is the main content of the page.</p>
      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed ac nisl nec sem finibus eleifend. Donec sit amet tempor metus. Duis non tortor convallis, vehicula quam id, efficitur nunc. Aliquam erat volutpat.</p>
      <p>Curabitur vestibulum magna sit amet ligula fermentum, vel volutpat nunc suscipit. Integer eu ante sed urna facilisis feugiat vel eget magna. Nulla facilisi. Vivamus fermentum neque nec metus pellentesque eleifend.</p>
      <p>Quisque accumsan augue eu elit bibendum scelerisque. Integer efficitur libero ac aliquam commodo. Proin non felis in dui eleifend ullamcorper eu et ipsum. Sed nec mi eu libero gravida cursus ut ac mauris.</p>
      <p>Donec nec consequat mauris. Vestibulum vel dui vitae justo suscipit vestibulum non a risus. Nulla ut fringilla sem, a porta justo. Duis malesuada augue in justo dignissim, eget dignissim libero eleifend.</p>
      <p>Quisque a nisi tortor. Sed condimentum massa in purus vulputate, ut cursus urna fermentum. Mauris aliquam, mi ut luctus posuere, urna quam feugiat justo, in bibendum nisi enim et eros.</p>
      <h2 id="roles">Roles</h2>
      <p>This is the main content of the page.</p>
      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed ac nisl nec sem finibus eleifend. Donec sit amet tempor metus. Duis non tortor convallis, vehicula quam id, efficitur nunc. Aliquam erat volutpat.</p>
      <p>Curabitur vestibulum magna sit amet ligula fermentum, vel volutpat nunc suscipit. Integer eu ante sed urna facilisis feugiat vel eget magna. Nulla facilisi. Vivamus fermentum neque nec metus pellentesque eleifend.</p>
      <p>Quisque accumsan augue eu elit bibendum scelerisque. Integer efficitur libero ac aliquam commodo. Proin non felis in dui eleifend ullamcorper eu et ipsum. Sed nec mi eu libero gravida cursus ut ac mauris.</p>
      <p>Donec nec consequat mauris. Vestibulum vel dui vitae justo suscipit vestibulum non a risus. Nulla ut fringilla sem, a porta justo. Duis malesuada augue in justo dignissim, eget dignissim libero eleifend.</p>
      <p>Quisque a nisi tortor. Sed condimentum massa in purus vulputate, ut cursus urna fermentum. Mauris aliquam, mi ut luctus posuere, urna quam feugiat justo, in bibendum nisi enim et eros.</p>
      <h2 id="candidates">Candidates</h2>
      <p>This is the main content of the page.</p>
      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed ac nisl nec sem finibus eleifend. Donec sit amet tempor metus. Duis non tortor convallis, vehicula quam id, efficitur nunc. Aliquam erat volutpat.</p>
      <p>Curabitur vestibulum magna sit amet ligula fermentum, vel volutpat nunc suscipit. Integer eu ante sed urna facilisis feugiat vel eget magna. Nulla facilisi. Vivamus fermentum neque nec metus pellentesque eleifend.</p>
      <p>Quisque accumsan augue eu elit bibendum scelerisque. Integer efficitur libero ac aliquam commodo. Proin non felis in dui eleifend ullamcorper eu et ipsum. Sed nec mi eu libero gravida cursus ut ac mauris.</p>
      <p>Donec nec consequat mauris. Vestibulum vel dui vitae justo suscipit vestibulum non a risus. Nulla ut fringilla sem, a porta justo. Duis malesuada augue in justo dignissim, eget dignissim libero eleifend.</p>
      <p>Quisque a nisi tortor. Sed condimentum massa in purus vulputate, ut cursus urna fermentum. Mauris aliquam, mi ut luctus posuere, urna quam feugiat justo, in bibendum nisi enim et eros.</p>
      <h2 id="votes">Votes</h2>
      <p>This is the main content of the page.</p>
      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed ac nisl nec sem finibus eleifend. Donec sit amet tempor metus. Duis non tortor convallis, vehicula quam id, efficitur nunc. Aliquam erat volutpat.</p>
      <p>Curabitur vestibulum magna sit amet ligula fermentum, vel volutpat nunc suscipit. Integer eu ante sed urna facilisis feugiat vel eget magna. Nulla facilisi. Vivamus fermentum neque nec metus pellentesque eleifend.</p>
      <p>Quisque accumsan augue eu elit bibendum scelerisque. Integer efficitur libero ac aliquam commodo. Proin non felis in dui eleifend ullamcorper eu et ipsum. Sed nec mi eu libero gravida cursus ut ac mauris.</p>
      <p>Donec nec consequat mauris. Vestibulum vel dui vitae justo suscipit vestibulum non a risus. Nulla ut fringilla sem, a porta justo. Duis malesuada augue in justo dignissim, eget dignissim libero eleifend.</p>
      <p>Quisque a nisi tortor. Sed condimentum massa in purus vulputate, ut cursus urna fermentum. Mauris aliquam, mi ut luctus posuere, urna quam feugiat justo, in bibendum nisi enim et eros.</p>
    </div>
    <div class="sidebar-page">
      <ul>
			<h2>Navigation</h2>
        <li><a href="#election">Election</a></li>
        <li><a href="#roles">Roles</a></li>
        <li><a href="#candidates">Candidates</a></li>
        <li><a href="#votes">Votes</a></li>
      </ul>
    </div>
  </div>
</body>
</html>
