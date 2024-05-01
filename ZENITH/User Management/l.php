<!DOCTYPE html>
<html>
   <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MBAA Page</title>
    <link rel="stylesheet" href="LandingStyle.css">
    <link href="https://fonts.googleapis.com/css?family=Dosis&display=swap" rel="stylesheet">
    <style>
        body {
          font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
            position: relative;
        }
        .hero {
            background-image: url('pics/sol.jpg');
            background-size: cover;
            background-position: center;
            width: 100%;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative; 
        }
        .navbar {
            position: absolute;
            top: 20px;
            left: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 95%; 
            padding: 20px;
    
           
        }
        .back a{
            text-decoration: none;
            color: white;
            padding: 10px 20px;
            font-size: 20px;
            border-radius: 8px;
            background: indianred;
        }
            .back a:hover{
            border: 1px solid indianred;
            background: transparent;
        }

        
        
        .navbar img {
            max-height: 65px;
        }
        .navbar .brand {
            margin-right: auto;
            margin-left: 20px;
            font-size: 24px;
        }
        .navbar .mission-vision {
            margin-right: 20px;
            font-size: 18px;
            display: flex;
        }
        .navbar .mission-vision div {
            margin-right: 10px;
            cursor: pointer; 
        }
        .navbar .mission-vision div:hover {
            text-decoration: underline; 
        }
        .navbar .btn {
            font-size: 20px;
        }
        .Marines-box {
            position: absolute;
            top: calc(100% + 10px);
            font-size: 17px;
            background-color: rgba(255, 255, 255, 0.7);
            color: black;
            padding: 10px;
            border-radius: 5px;
            width: calc(100% - 40px); 
            display: none; /* Initially hide content */
            z-index: 1; /* Ensure content is above background */
            max-width: 300px; /* Set maximum width */
        }
        .Marine {
            position: absolute;
            top: 5px;
            right: 20px;
            font-size: 17px;
            background-color: rgba(255, 255, 255, 0.7);
            color: black;
            padding: 20px;
            border-radius: 5px;
            width: 700px;
            margin-top: 10%;
            margin-right: 25%;
            display: flex; /* Use flexbox */
            flex-direction: row; /* Arrange items in a row */
            align-items: center; /* Center items vertically */
            gap: 10px; /* Add space between items */
        }
        .Marines-box h2{
           font-weight: bold;
        }
        
    </style>
   </head>
   <body>
        <div class="hero">
            <div class="navbar">
                <img src="pics/pmc logo.png" alt="Logo">
                <div class="brand">Marine Barracks Arturo Asuncion</div>
                <div class="back">
                    <a href="index.html"> 🡸 </a>
                </div>
            </div>
        </div>

        <div class="Marines-box mission-content">
            <h2>Mission</h2>
            <p>Add your Mission content here.</p>
        </div>
        <div class="Marines-box vision-content">
            <h2>Vision</h2>
            <p>Add your Vision content here.</p>
        </div>
        <div class="Marine">
          <h2></h2>
          <p><b>M</b>any are called but only few are chosen To join the toughest organization of Philippine Marines Molded to be a warrior and defender of our Motherland In toughest battles we excel and in valor and honor, we stand.
              <br>
              <br>
              <b>A</b>s we grow and celebrate our 71st birthday We have imprinted our significance day by day
              From community relations to combat operations
              Your Marines is taking the lead in doing commendable actions.
              <br>
              <br>
              <b>R</b>eady as always, and never unruly A disciplined individual wherever we may be We take responsibility in the actions we make We care so much of the actuations we take.
              <br>
              <b>I</b> am a Marine, agile, strong-willed, and mannered My life is lived for the country and people that I serve
              An absentee individual to any occasions of my family Because my own family will always be my last priority.
              <br>
              <br>
              <b>N</b>o MERCY is given to our country's enemy
              Who will cross the line and provoke our duty
              We will fight until the last breath we take
              We will let our enemies feel their dangerous fate.
              <br>
              <br>
              <b>E</b>liminating ASG, CTG, and other lawless groups is my mission And living a peaceful and progressive life is my vision This dream is quite delusional and hard to attain But my faithfulness to my duty will always remain.
              <br>
              <br>
              <b>S</b>eeing myself with the Corps has made my life more worthy Crossing danger zones with rifle and leading a combat company A different path that only the bravest women get interested Wears no makeup but remains pleasing, loved, and respected. #OABJAA</p>
      </div>
    
       
      
   </body>
</html>
