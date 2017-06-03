<?php
include_once('/var/www/html/final_project/header.php');
include_once('/var/www/html/final_project/header2.php');
include_once('/var/www/html/final_project/finalproject-lib.php');


connect($db);
verify($s);
verify($fid);
$s=htmlspecialchars($s);

switch($s){
        case 0:
        default:
		echo "<center><table><tr><td><b><u> Fixtures & Results </b></u> </td></tr> \n";
                if($stmt=mysqli_prepare($db,"select distinct Date, Team_1, score, Team_2 from Season,Teams")){
                        mysqli_stmt_execute($stmt);
                        mysqli_stmt_bind_result($stmt,$date,$Team_1,$score,$Team_2);
                        while (mysqli_stmt_fetch($stmt)){
				$date=htmlspecialchars($date);
                                $name=htmlspecialchars($Team_1);
                                $score=htmlspecialchars($score);
                                $name=htmlspecialchars($Team_2);
                                echo "<tr>
				<td>$date</td>
				<td><a href=index.php?&s=1>$Team_1</a></td>
                                <td>$score</td>
                                <td><a href=index.php?s=1>$Team_2</a></td></tr>";
                        }
                mysqli_stmt_close($stmt);
                }
                echo"</table>";
                break;
	
	case 1:
		echo "<center><tr> <td> <b><u> Select the Team </b></u></td> </tr><br><br>";
		$tidTeams=mysqli_real_escape_string($db, $tidTeams);
		if ($stmt=mysqli_prepare($db,"select distinct Teams.idTeams,Name from Teams")){
                
		        mysqli_stmt_bind_param($stmt,'s',$tidTeams);
                        mysqli_stmt_execute($stmt);
                        mysqli_stmt_bind_result($stmt, $pidTeams,$name);
         
                	while(mysqli_stmt_fetch($stmt))
                	{

                   		$pidTeams=htmlspecialchars($pidTeams);
                       		$name=htmlspecialchars($name);
                        	echo"<a href=index.php?pidTeams=$pidTeams&s=2>$name</a> <br>";
             		}
			
                	mysqli_stmt_close($stmt);
		}
               	echo "
                <tr><td><input type=hidden name=pidTeams value=$pidTeams></td></tr>
     		<tr><td><input type=hidden name=s value=2></td></tr>
		</form>";
                break;

 
	case 2:
                echo "<center><tr><td><b><u> Player Statstics </b></u></td></tr><br>";
;
		$pidTeams=mysqli_real_escape_string($db, $pidTeams);
                if($stmt=mysqli_prepare($db,"select Teams.idTeams, Pos, Players.name, App, Players.GS, Assists, CS, YC, RC from Players, Teams where Players.idTeams=Teams.idTeams and Teams.idTeams=$pidTeams")){
                        mysqli_stmt_bind_param($stmt,"ssssssss",$tidTeams);
                        mysqli_stmt_execute($stmt);
                        mysqli_stmt_bind_result($stmt,$tidTeams,$Pos,$name,$App,$GS,$Assists,$CS,$YC,$RC);
                        while (mysqli_stmt_fetch($stmt)){
                                $Pos=htmlspecialchars($Pos);
				$name=htmlspecialchars($name);
                                $App=htmlspecialchars($App);
                                $GS=htmlspecialchars($GS);
                                $Assists=htmlspecialchars($Assists);
				$CS=htmlspecialchars($CS);
				$YC=htmlspecialchars($YC);
				$RC=htmlspecialchars($RC);
                                echo "<tr><td><a href=index.php>$Pos</a></td>
                                <td><a href=index.php?&s=0&name=$name>$name</a></td>
                                <td><a href=index.php?&s=0&App=$App>$App</a></td>
                                <td><a href=index.php?&s=0^GS=$GS>$GS</a></td>
				<td><a href=index.php?&s=0&Assists=$Assists>$Assists</a></td>
                                <td><a href=index.php?&s=0&CS=$CS>$CS</a></td>
                                <td><a href=index.php?&s=0&YC=$YC>$YC</a></td>
				<td><a href=index.php?&s=0&RC=$RC>$RC</a></td></tr><br>";
                        }
                        mysqli_stmt_close($stmt);
                
		}
		

                break;
	case 3:
		echo "<center><table><tr><td><b><u> Group A </b></u></td></tr> \n";
	
                if($stmt=mysqli_prepare($db,"select distinct name,P,W,D,L,GS,GA,GD,PTS from Teams,Season where name in (select Team_1 from Season where Groups=0);")){
                        mysqli_stmt_execute($stmt);
                        mysqli_stmt_bind_result($stmt,$name,$P,$W,$D,$L,$GS,$GA,$GD,$PTS);
                        while (mysqli_stmt_fetch($stmt)){
                                $name=htmlspecialchars($name);
                                $P=htmlspecialchars($P);
                                $W=htmlspecialchars($W);
                                $D=htmlspecialchars($D);
				$L=htmlspecialchars($L);
				$GS=htmlspecialchars($GS);
				$GA=htmlspecialchars($GA);
				$GD=htmlspecialchars($GD);
				$PTS=htmlspecialchars($PTS);
                                echo "<tr><td><a href=index.php>$name</a></td>
				<td>$P</td><td>$W</td><td> $D </td><td>$L </td><td>$GS</td> <td>$GA</td> <td>$GD</td> <td>$PTS</td></tr>";
                        }
                mysqli_stmt_close($stmt);
                }
                echo"</table>";

		echo "<center><table><tr><td><b><u> Group B </b></u></td></tr> \n";
              
                if($stmt=mysqli_prepare($db,"select distinct name,P,W,D,L,GS,GA,GD,PTS from Teams,Season where name in (select Team_1 from Season where Groups=1);")){
                        mysqli_stmt_execute($stmt);
                        mysqli_stmt_bind_result($stmt,$name,$P,$W,$D,$L,$GS,$GA,$GD,$PTS);
                        while (mysqli_stmt_fetch($stmt)){
                                $name=htmlspecialchars($name);
                                $P=htmlspecialchars($P);
                                $W=htmlspecialchars($W);
                                $D=htmlspecialchars($D);
                                $L=htmlspecialchars($L);
                                $GS=htmlspecialchars($GS);
                                $GA=htmlspecialchars($GA);
                                $GD=htmlspecialchars($GD);
                                $PTS=htmlspecialchars($PTS);
                                 echo "<tr><td><a href=index.php>$name</a></td>
                                <td>$P</td><td>$W</td><td> $D </td><td>$L </td><td>$GS</td> <td>$GA</td> <td>$GD</td> <td>$PTS</td></tr>";

                        }
                mysqli_stmt_close($stmt);
                }
                echo"</table>";

		echo "<center><table><tr><td><b><u> Group C </b></u></td></tr> \n";
           
                if($stmt=mysqli_prepare($db,"select distinct name,P,W,D,L,GS,GA,GD,PTS from Teams,Season where name in (select Team_1 from Season where Groups=2);")){
                        mysqli_stmt_execute($stmt);
                        mysqli_stmt_bind_result($stmt,$name,$P,$W,$D,$L,$GS,$GA,$GD,$PTS);
                        while (mysqli_stmt_fetch($stmt)){
                                $name=htmlspecialchars($name);
                                $P=htmlspecialchars($P);
                                $W=htmlspecialchars($W);
                                $D=htmlspecialchars($D);
                                $L=htmlspecialchars($L);
                                $GS=htmlspecialchars($GS);
                                $GA=htmlspecialchars($GA);
                                $GD=htmlspecialchars($GD);
                                $PTS=htmlspecialchars($PTS);
                                echo "<tr><td><a href=index.php>$name</a></td>
                                <td>$P</td><td>$W</td><td> $D </td><td>$L </td><td>$GS</td> <td>$GA</td> <td>$GD</td> <td>$PTS</td></tr>";

                        }
                mysqli_stmt_close($stmt);
                }
                echo"</table>";

		echo "<center><table><tr><td><b><u> Group D </b></u></td></tr> \n";
                
                if($stmt=mysqli_prepare($db,"select distinct name,P,W,D,L,GS,GA,GD,PTS from Teams,Season where name in (select Team_1 from Season where Groups=3);")){
                        mysqli_stmt_execute($stmt);
                        mysqli_stmt_bind_result($stmt,$name,$P,$W,$D,$L,$GS,$GA,$GD,$PTS);
                        while (mysqli_stmt_fetch($stmt)){
                                $name=htmlspecialchars($name);
                                $P=htmlspecialchars($P);
                                $W=htmlspecialchars($W);
                                $D=htmlspecialchars($D);
                                $L=htmlspecialchars($L);
                                $GS=htmlspecialchars($GS);
                                $GA=htmlspecialchars($GA);
                                $GD=htmlspecialchars($GD);
                                $PTS=htmlspecialchars($PTS);
                                echo "<tr><td><a href=index.php>$name</a></td>
                                <td>$P</td><td>$W</td><td> $D </td><td>$L </td><td>$GS</td> <td>$GA</td> <td>$GD</td> <td>$PTS</td></tr>";

                        }
                mysqli_stmt_close($stmt);
                }
                echo"</table>";


                break;

	case 4:
		echo "<center><table><tr><td><b><u> Knockout Rounds </b></u></td></tr>";
		echo "<center><tr><td><b><u> QuaterFinals </u></b></td></tr><br>\n \n";
                if($stmt=mysqli_prepare($db,"select Date, Team_1, score, Team_2 from Season where groups=4 or groups=5;")){
                        mysqli_stmt_execute($stmt);
                        mysqli_stmt_bind_result($stmt,$date,$Team_1,$score,$Team_2);
                        while (mysqli_stmt_fetch($stmt)){
                                $date=htmlspecialchars($date);
                                $name=htmlspecialchars($Team_1);
                                $score=htmlspecialchars($score);
                                $name=htmlspecialchars($Team_2);
                                echo "<tr><td><a href=index.php>$date</a></td>
                                <td><a href=index.php>$Team_1</a></td>
                                <td><a href=index.php>$score</a></td>
                                <td><a href=index.php>$Team_2</a></td></tr>";
                        }
                mysqli_stmt_close($stmt);
                }
		echo "<center><tr><td><b><u> SemiFinals </u></b></td></tr><br>\n \n";
                if($stmt=mysqli_prepare($db,"select Date, Team_1, score, Team_2 from Season where groups=6 or groups=7;")){
                        mysqli_stmt_execute($stmt);
                        mysqli_stmt_bind_result($stmt,$date,$Team_1,$score,$Team_2);
                        while (mysqli_stmt_fetch($stmt)){
                                $date=htmlspecialchars($date);
                                $name=htmlspecialchars($Team_1);
                                $score=htmlspecialchars($score);
                                $name=htmlspecialchars($Team_2);
                                echo "<tr><td><a href=index.php>$date</a></td>
                                <td><a href=index.php>$Team_1</a></td>
                                <td><a href=index.php>$score</a></td>
                                <td><a href=index.php>$Team_2</a></td></tr>";
                        }
                mysqli_stmt_close($stmt);
                }
		echo "<center><tr><td><b><u> Final </u></b></td></tr><br>\n \n";
                if($stmt=mysqli_prepare($db,"select Date, Team_1, score, Team_2 from Season where groups=8;")){
                        mysqli_stmt_execute($stmt);
                        mysqli_stmt_bind_result($stmt,$date,$Team_1,$score,$Team_2);
                        while (mysqli_stmt_fetch($stmt)){
                                $date=htmlspecialchars($date);
                                $name=htmlspecialchars($Team_1);
                                $score=htmlspecialchars($score);
                                $name=htmlspecialchars($Team_2);
                                echo "<tr><td><a href=index.php>$date</a></td>
                                <td><a href=index.php>$Team_1</a></td>
                                <td><a href=index.php>$score</a></td>
                                <td><a href=index.php>$Team_2</a></td></tr>";
				echo "<tr><td><b> JUVENTUS ARE THE CHAMPIONS </b></td></tr></table>";

                        }
                mysqli_stmt_close($stmt);
                }
	
		break;
}

?>
