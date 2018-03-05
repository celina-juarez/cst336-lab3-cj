
<!DOCTYPE html>
<html>
    <head>
        <link href = "css/styles.css" rel = "stylesheet" type = "text/css" />
    </head>
    <body>
        <header>
            <h2>Silverjack</h2>
        </header>
        <?php
            $player1 = array('name' => 'Chino', 'imgUrl' => './img/user_pics/chino.png', 'hand' => array(), 'points' => 0);
            $player2 = array('name' => 'Celina', 'imgUrl' => './img/user_pics/celina.jpg', 'hand' => array(), 'points' => 0);
            $player3 = array('name' => 'Miguel', 'imgUrl' => './img/user_pics/miguel.jpg', 'hand' => array(), 'points' => 0);
            $player4 = array('name' => 'Oscar', 'imgUrl' => './img/user_pics/Oscar_Ramirez.jpg', 'hand' => array(), 'points' => 0);
            
            $numPlayers = 4;
            
            $player1Displayed = false;
            $player2Displayed = false;
            $player3Displayed = false;
            $player4Displayed = false;
            
            $heartsUsed = array(0,0,0,0,0,0,0,0,0,0,0,0,0);
            $clubsUsed = array(0,0,0,0,0,0,0,0,0,0,0,0,0);
            $diamondsUsed = array(0,0,0,0,0,0,0,0,0,0,0,0,0);
            $spadesUsed = array(0,0,0,0,0,0,0,0,0,0,0,0,0);
            
            $totalPoints = 0;
            
            $allCards = array(
                $heartsUsed,
                $diamondsUsed,
                $spadesUsed,
                $clubsUsed
                );
            
            $allPlayers = array(
                $player1,
                $player2,
                $player3,
                $player4
                );
                
            $playersDisplayed = array(
                $player1Displayed,
                $player2Displayed,
                $player3Displayed,
                $player4Displayed
                );
                
            $allPoints = array();
                
            function printGameState(&$allPlayers,&$allCards,&$allPoints, &$playersDisplayed, &$totalPoints){
                
                global $numPlayers;
                $numbers = range(0, 3);
                shuffle($numbers);
                
                for($i=0;$i<$numPlayers;$i++){
                    display($allPoints, $allPlayers[$numbers[$i]], $allCards, $totalPoints);
                } 
            }
            
            function display(&$allPoints, &$player, &$allCards, &$totalPoints){
                    echo "<div id = gamePrint>";
                    echo $player['name']. "                               ";
                    echo "<img id = pic src='" . $player['imgUrl'] . "' width='100' height='125' />";
                    generateDeck($player,$allCards);
                    displayhand($player);
                    $totalPoints += $player['points'];
                    if($player['points']< 43)
                        array_push($allPoints, $player['points']);
                    echo "<br><br><br><br>";
            }
            
            function displayHand(&$player){
                
                for($i=0; $i<count($player['hand']); $i++){
                    echo "<img id='playerCards' src=" . $player['hand'][$i] . " />";
                }
                echo "</div>";
                echo "<div id = points>";
                echo "\t\t" . $player['points'] . " points<br>";
                echo "</div>";
                echo "<br><br><br><br>";
                
            }
            
            function generateDeck(&$player,&$allCards)
            {
                $count = 0;
                
                while($player['points'] <= 38){
                    $again = true;
                    do{
                        $suit = rand(1,4);
                        $card = rand(1,13);
                        if($allCards[$suit-1][$card-1] == 0)
                        {
                            $again = false;
                            $allCards[$suit-1][$card-1] = 1;
                        }
                    }while($again);
                    

                    switch ($suit) {
                        case 1:
                            $player['hand'][$count] = "./img/cards/hearts/" . "$card" . ".png";
                            $player['points'] += $card;
                            break;
                        case 2:
                            $player['hand'][$count] = "./img/cards/diamonds/" . "$card" . ".png";
                            $player['points'] += $card;
                            break;
                        case 3:
                            $player['hand'][$count] = "./img/cards/spades/" . "$card" . ".png";
                            $player['points'] += $card;
                            break;
                        case 4:
                            $player['hand'][$count] = "./img/cards/clubs/" . "$card" . ".png";
                            $player['points'] += $card;
                            break;
                    }
                    $count++;
                }
            }
            
            function getWinner(&$allPoints, &$allPlayers, &$totalPoints){
                $multiples = 1;
                $max = $allPoints[0];
                for($i = 1; $i < sizeof($allPoints); $i++)
                {
                    if($allPoints[$i] > $max)
                    {
                        $max = $allPoints[$i];
                    }
                    else if($allPoints[$i] == $max)
                        $multiples++;
                }
                $totalPoints -= $max;
                
                if($max == NULL)
                {
                    echo "All players lost...";
                }
                else if($multiples == 1)
                {
                    foreach($allPlayers as $player)
                    {
                        if($player['points'] == $max)
                        {
                            echo $player['name'];
                            echo " wins ";
                            echo $totalPoints;
                            echo " points.";
                        }
                    }
                }
                else
                {
                    echo "There's a tie... ";
                    echo "</br>";
                    
                    foreach($allPlayers as $player)
                    {
                        if($player['points'] == $max)
                        {
                            echo $player['name'];
                            echo " has a total of ";
                            echo $totalPoints;
                            echo " points.";
                        }
                        echo "</br>";
                    }
                }
                
                
            }
            
            printGameState($allPlayers,$allCards, $allPoints, $playersDisplayed, $totalPoints);
        ?>
        <div id = "winner">
            <br />
            <?php
                getWinner($allPoints, $allPlayers, $totalPoints);
            ?>
            <br />
            <form>
                <input id = "button" type="submit" value ="Play Again"/>
            </form>
        </div>
    </body>
</html>