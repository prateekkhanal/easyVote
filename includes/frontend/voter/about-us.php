<?php

	include "../../../sidebar/sidebar.php";

?>
    <title>About Us - easyVote</title>
<style>
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f4f4f4;
}

header {
    background-color: #3540A2D9;
    color: white;
    padding: 1.5rem 0;
    text-align: center;
	margin: 40px;
}

header h1 {
    margin: 0;
}

header p {
    margin: 0.5rem 0 0;
	font-style: italic;
}

main {
    padding: 2rem;
}

section {
    margin-bottom: 2rem;
    background-color: white;
font-size: 23px;
    padding: 3rem;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

section h2 {
    margin-top: 0;
    color: #3540A2D9;
}

ul {
    padding: 0;
}

ul li {
    background: url('checkmark.png') no-repeat left center;
    background-size: 1rem;
    margin-bottom: 0.5rem;
}

footer {
    text-align: center;
    padding-top: 5px;
    padding-bottom: 10px;
    background-color: #3333338c;
    color: white;
    position: absolute;
	font-size: 18px;
    width: 1415px;
    bottom: 0;
	 z-index: 4;
	position: fixed;
	bottom: 0px;
	height: 40px;
	margin-left: 250px;;
}

</style>
<div class="main">
    <header>
        <h1>About Us</h1>
        <p>Welcome to our Election Portal, where transparency and democracy meet.</p>
    </header>
    <main>
        <section id="anonymous-viewers">
            <h2>Anonymous Viewers</h2>
            <p>As an anonymous viewer, you can:</p>
            <ul>
                <li>Spectate elections</li>
            </ul>
        </section>
        
        <section id="voters">
            <h2>Voters</h2>
            <p>As a voter, you can:</p>
            <ul>
                <li>Search elections</li>
                <li>Explore elections, candidates, parties, and roles</li>
                <li>Contact managers</li>
                <li>Check if you meet voting criteria</li>
                <li>Pin your favorite elections for frequent visits</li>
                <li>Vote for your preferred candidate if you meet all voting criteria</li>
                <li>View election status (running) and results (ended)</li>
            </ul>
        </section>
        
        <section id="candidates">
            <h2>Candidates</h2>
            <p>As a candidate, you can:</p>
            <ul>
                <li>Explore roles and parties</li>
                <li>Check if you meet the criteria to run as a candidate</li>
                <li>Contact managers</li>
                <li>Send candidate requests</li>
                <li>Check and update your candidate profile</li>
                <li>Delete or undo your requests (if not verified)</li>
            </ul>
        </section>
        
        <section id="managers">
            <h2>Managers</h2>
            <p>As a manager, you can:</p>
            <ul>
                <li>Create elections, parties, and roles</li>
                <li>Add and remove assistant managers</li>
                <li>Control election time, visibility, and access</li>
                <li>Restrict voter and candidate participation</li>
                <li>View and update candidate requests</li>
                <li>Update elections, parties, and roles</li>
                <li>Check election status (if national elections are verified by admin)</li>
                <li>Contact candidates and admins</li>
            </ul>
        </section>
        
    </main>
</div>
    <footer>
        <p>&copy; 2024 Election Portal. All rights reserved.</p>
    </footer>
