<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Page with sidebar-page</title>
  <style>
* {
	font-family: Arial, Helvetica, sans-serif;
	padding: 0px;
	margin: 0px;
}
.sidebar-page {
	grid-area: menu;
	position: fixed;
	top: 350px;
	left: 250px;
	z-index: 0.5;
}
.sidebar-page ul li, a {
	list-style: none;
	text-decoration: none;
	font-style: italic;
	font-size: 1.25em;
	margin: 15px 0px;
	color: black;
	
}
.main-content { grid-area: main;
	margin-right: 100px;
	margin-left: 100px;
	padding-left: 400px;
	padding-right: 225px;
 }

.container {
  display: grid;
  grid-template-areas:
    'footer footer footer footer menu';
  /* background-color: #2196F3; */
  background-color: lightgray;
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
	<div>
<pre>
 - Election Page
   	
   	- View-Status (if election has either
   			i. started/is running
   			ii. ended
   			)
   	
   	Title/electionID
   	Level
   	View
   	Time-Table
   	Location
   	Authentication
	Description
	
	Can-I-Vote ?
	Can-I-Run-As-A-Candidate?
	
	Roles:-
	   Position, Place, Who-Can-Run, Description
	Parties:-
	   logo, party-name, party-id, description, looking-for-candidates(status) , status 




   - Candidate Tasks	
      who can't send requests?
	-> who has already sent request in any role
	-> when the party trying is closed
	-> when the candidate is blocked
	-> election is running or ended
<pre>
</div>
</body>
</html>
