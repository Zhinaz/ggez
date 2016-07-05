<!doctype html> 
<html lang="en"> 
<head> 
	<meta charset="UTF-8" />
	<script type="text/javascript" src="js/phaser.min.js"></script>
    
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
  
    <title>Molbak - GGEZ</title>
  
    <link rel="shortcut icon" href="/images/favicon.ico"/>
    <link rel="stylesheet" type="text/css" href="dist/css/bootstrap.min.css">
    <!-- Optional Bootstrap theme -->
    <link rel="stylesheet" href="dist/css/custom-bootstrap.css">

</head>
<body>

<?php include 'includes/upper-body.php';?>

		<script type="text/javascript">

		var game = new Phaser.Game(800, 600, Phaser.AUTO, '', { preload: preload, create: create, update: update });

		function preload() {

			game.load.image('sky', 'assets/sky.png');
		    game.load.image('ground', 'assets/platform.png');
		    game.load.image('star', 'assets/star.png');
		    game.load.spritesheet('dude', 'assets/kartoffelhovedmand.png', 32, 48);
		    game.load.spritesheet('enemy-saw', 'assets/enemy-saw.png', 72, 72);
		}

		var platforms;
		var saws;

		function create() {


		    //  We're going to be using physics, so enable the Arcade Physics system
		    game.physics.startSystem(Phaser.Physics.ARCADE);

		    //  A simple background for our game
		    game.add.sprite(0, 0, 'sky');

		    //  The platforms group contains the ground and the 2 ledges we can jump on
		    platforms = game.add.group();
		    platforms.enableBody = true;

		    // Here we create the ground.
		    var ground = platforms.create(600, game.world.height - 64, 'ground');
		    ground.scale.setTo(2, 2);

		    //  This stops it from falling away when you jump on it
		    ground.body.immovable = true;

		    var ledge2 = platforms.create(-100, 250, 'ground');

		    ledge2.body.immovable = true;

		    ledge2.scale.setTo(2, 1);

		    ledge3 = platforms.create(300, 540, 'ground');

		    ledge3.body.immovable = true;

		    ledge3.scale.setTo(0.2, 1.9);

		    ledge4 = platforms.create(-300, 540, 'ground');

		    ledge4.body.immovable = true;

		    ledge4.scale.setTo(1, 1.9);

		    ledge5 = platforms.create(350, 187, 'ground');

		    ledge5.body.immovable = true;

		    ledge5.scale.setTo(0.2, 2.1);

		 	createPlayer ();

		 	saws = game.add.group();
		 	saws.enableBody = true;

	    	var saw1 = game.add.sprite(162, 540, 'enemy-saw');
    		saws.add(saw1);

	    	saw1.animations.add('spin');
	    	saw1.animations.play('spin', 25, true);

			var saw2 = game.add.sprite(225, 540, 'enemy-saw');
    		saws.add(saw2);

	    	saw2.animations.add('spin');
	    	saw2.animations.play('spin', 25, true);

	    	var saw3 = game.add.sprite(100, 540, 'enemy-saw');
    		saws.add(saw3);

	    	saw3.animations.add('spin');
	    	saw3.animations.play('spin', 25, true);

			var saw4 = game.add.sprite(380, 540, 'enemy-saw');
    		saws.add(saw4);

	    	saw4.animations.add('spin');
	    	saw4.animations.play('spin', 25, true);

	    	var saw5 = game.add.sprite(450, 540, 'enemy-saw');
    		saws.add(saw5);

	    	saw5.animations.add('spin');
	    	saw5.animations.play('spin', 25, true);

	    	var saw6 = game.add.sprite(522, 540, 'enemy-saw');
    		saws.add(saw6);

	    	saw6.animations.add('spin');
	    	saw6.animations.play('spin', 25, true);

		    stars = game.add.group();
		    stars.enableBody = true;

		    for (var i = 0; i < 12; i++)
		    {
		        //  Create a star inside of the 'stars' group
		        var star = stars.create(i * 70, 0, 'star');

		        //  Let gravity do its thing
		        star.body.gravity.y = 600;
		        star.body.collideWorldBounds = true;
		        
		        //  This just gives each star a slightly random bounce value
		        star.body.bounce.y = 1; // + Math.random() * 0.2
		    }

		    scoreText = game.add.text(16, 16, 'score: 0', { fontSize: '32px', fill: '#000' });

		}

		var movementSpeed = 180;

		var score = 0;
		var scoreText;

		function update() {


		    //  Collide the player and the stars with the platforms
		    game.physics.arcade.collide(player, platforms);
		    game.physics.arcade.collide(stars, platforms);
		    game.physics.arcade.overlap(player, saws, killPlayer, null, this);

		cursors = game.input.keyboard.createCursorKeys();

		     //  Reset the players velocity (movement)
		    player.body.velocity.x = 0;

		    if (cursors.left.isDown)
		    {
		        //  Move to the left
		        player.body.velocity.x = -movementSpeed;

		        player.animations.play('left');
		    }
		    else if (cursors.right.isDown)
		    {
		        //  Move to the right
		        player.body.velocity.x = movementSpeed;

		        player.animations.play('right');
		    }
		    else
		    {
		        //  Stand still
		        player.animations.stop();

		        player.frame = 4;
		    }

		    //  Allow the player to jump if they are touching the ground.
		    if (cursors.up.isDown && player.body.touching.down)
		    {
		        player.body.velocity.y = -250;
		    }

			else if (cursors.down.isDown){
				player.body.velocity.y = 150;
			}
		   


		}


		function createPlayer () {

			// The player and its settings
		    player = game.add.sprite(32, game.world.height - 400, 'dude');

		    //  We need to enable physics on the player
		    game.physics.arcade.enable(player);

		    //  Player physics properties. Give the little guy a slight bounce.
		    player.body.bounce.y = 0;
		    player.body.gravity.y = 400;
		    player.body.collideWorldBounds = true;

		    //  Our two animations, walking left and right.
		    player.animations.add('left', [0, 1, 2, 3], 10, true);
		    player.animations.add('right', [5, 6, 7, 8], 10, true);

		}

		function killPlayer (player, saw) {

			player.kill();
			score++;
			scoreText.text = 'Deaths= ' + score;
			createPlayer ();
		}

		</script>


<?php include 'includes/lower-body.php';?>

</body>
</html>