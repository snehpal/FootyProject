<?php 

isset($_REQUEST['s']) ? $s= strip_tags($_REQUEST['s']) : $s='';
isset($_REQUEST['fid']) ? $fid= strip_tags($_REQUEST['fid']) : $fid='';
isset($_REQUEST['pidTeams']) ? $pidTeams= strip_tags($_REQUEST['pidTeams']) : $pidTeams='';
isset($_REQUEST['tidTeams']) ? $tidTeams= strip_tags($_REQUEST['tidTeams']) : $tidTeams='';
isset($_REQUEST['team_name']) ? $team_name= strip_tags($_REQUEST['team_name']) : $team_name='';
isset($_REQUEST['player_name']) ? $player_name= strip_tags($_REQUEST['player_name']) : $player_name='';
isset($_REQUEST['pos']) ? $pos= strip_tags($_REQUEST['pos']) : $pos='';
isset($_REQUEST['x']) ? $x= strip_tags($_REQUEST['x']) : $x='';
isset($_REQUEST['tnum']) ? $tnum= strip_tags($_REQUEST['tnum']) : $tnum='';
isset($_REQUEST['date']) ? $date= strip_tags($_REQUEST['date']) : $date='';
isset($_REQUEST['team1']) ? $team1= strip_tags($_REQUEST['team1']) : $team1='';
isset($_REQUEST['team2']) ? $team2= strip_tags($_REQUEST['team2']) : $team2='';
isset($_REQUEST['group']) ? $group= strip_tags($_REQUEST['group']) : $group='';
isset($_REQUEST['postuser'])? $postuser = strip_tags($_REQUEST['postuser']):$postuser="";
isset($_REQUEST['postpass'])? $postpass = strip_tags($_REQUEST['postpass']):$postpass="";
isset($_REQUEST['newuser'])? $newuser = strip_tags($_REQUEST['newuser']):$newuser="";
isset($_REQUEST['newpass'])? $newpass = strip_tags($_REQUEST['newpass']):$newpass="";
isset($_REQUEST['newemail'])? $newemail = strip_tags($_REQUEST['newemail']):$newemail="";
isset($_REQUEST['score']) ? $score= strip_tags($_REQUEST['score']) : $score='';
isset($_REQUEST['winner']) ? $winner= strip_tags($_REQUEST['winner']) : $winner='';
isset($_REQUEST['P'])? $P = strip_tags($_REQUEST['P']):$P="";
isset($_REQUEST['W'])? $W = strip_tags($_REQUEST['W']):$W="";
isset($_REQUEST['D'])? $D = strip_tags($_REQUEST['D']):$D="";
isset($_REQUEST['L'])? $L = strip_tags($_REQUEST['L']):$L="";
isset($_REQUEST['GS'])? $GS = strip_tags($_REQUEST['GS']):$GS="";
isset($_REQUEST['GA']) ? $GA= strip_tags($_REQUEST['GA']) : $GA='';
isset($_REQUEST['GD']) ? $GD= strip_tags($_REQUEST['GD']) : $GD='';
isset($_REQUEST['PTS']) ? $PTS= strip_tags($_REQUEST['PTS']) : $PTS='';
isset($_REQUEST['aTeams']) ? $aTeams= strip_tags($_REQUEST['aTeams']) : $aTeams='';
isset($_REQUEST['pTeams']) ? $pTeams= strip_tags($_REQUEST['pTeams']) : $pTeams='';
isset($_REQUEST['name1']) ? $name1= strip_tags($_REQUEST['name1']) : $name1='';
isset($_REQUEST['App'])? $App = strip_tags($_REQUEST['App']):$App="";
isset($_REQUEST['CS'])? $CS = strip_tags($_REQUEST['CS']):$CS="";
isset($_REQUEST['Assists'])? $Assists = strip_tags($_REQUEST['Assists']):$Assists="";
isset($_REQUEST['YC'])? $YC = strip_tags($_REQUEST['YC']):$YC="";
isset($_REQUEST['RC'])? $RC = strip_tags($_REQUEST['RC']):$RC="";




function verify($num){
        if ($num=!Null){
                if(is_numeric($num)){;
                        echo "Enter a number";
                }else{
                        pass;
                }
        }
}

function connect(&$db){
        $mycnf="/etc/finalproject-mysql.conf";
        if (!file_exists($mycnf)) {
                echo "Error File Not Found: $mycnf";
                exit;
        }

        $mysql_ini_array=parse_ini_file($mycnf);
        $db_host=$mysql_ini_array['host'];
        $db_user=$mysql_ini_array['user'];
        $db_pass=$mysql_ini_array['pass'];
        $db_port=$mysql_ini_array['port'];
        $db_name=$mysql_ini_array['dbName'];
        $db = mysqli_connect($db_host, $db_user, $db_pass, $db_name, $db_port);

        if (!$db){
                echo "Error Connecting to DB: " .mysqli_connect_error();
                exit;
        }
}

function authenticate($db,$postuser, $postpass){
        $_SESSION['ip']=$_SESSION['REMOTE_ADDR'];
        $_SESSION['HTTP_USER_AGENT']=md5($SERVER['SERVER_ADDR'].$_SERVER['HTTP_USER_AGENT']);
        $_SESSION['created']=time();
        $ip=$_SERVER['REMOTE_ADDR'];
        $whitelist=array('198.18.0.26','198.18.1.50');
        if (!in_array($ip,$whitelist,true)){
                logincheck($db);
        }
        $query="select userid, email, password, salt from users where username=?";
        if ($stmt=mysqli_prepare($db,$query)){
                mysqli_stmt_bind_param($stmt,"s",$postuser);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_bind_result($stmt,$userid,$email,$password,$salt);
                while (mysqli_stmt_fetch($stmt)){
                        $userid=$userid;
                        $password=$password;
                        $salt=$salt;
                        $email=$email;

                }
                mysqli_stmt_close($stmt);
                $epass=hash('sha256',$postpass.$salt);
                if ($epass==$password){
                        session_regenerate_id();
                        $_SESSION['userid']=$userid;
                        $_SESSION['email']=$email;
                        $_SESSION['authenticated']="yes";
                        $_SESSION['ip']=$_SERVER['REMOTE_ADDR'];
                        $action=1;
                        loginattempt($db,$postuser,$action);
                }else{
                        echo "Failed to Login";
                        $action=0;
                        loginattempt($db,$postuser,$action);
                        error_log("ERROR: Login failure for " . $_SERVER['REMOTE_ADDR'],0);
                        header("Location: /final_project/login.php");
                        exit;
                }
        }
}

function checkAuth(){
        if (isset($SESSION['HTTP_USER_AGENT'])){
                if ($_SESSION['HTTP_USER_AGENT'] != md5($_SERVER['SERVER_ADDR'].$_SERVER['HTTP_USER_AGENT'])){
                        error_log(print_r("HTTP error", TRUE));
                        logout();
                }else{
                        logout();
                }
        }
        if (isset($_SESSION['ip'])){
                if ($_SESSION['ip']!=$_SERVER['REMOTE_ADDR']){
                        error_log(print_r("IP error", TRUE));
                        logout();
                }
        }else{

                logout();
        }

        if (isset($_SESSION['created'])){
                if (time() - $_SESSION['created'] > 1800){
                        error_log(print_r("session error", TRUE));
                        logout();
                }
        }else{
                logout();
        }

        if ("POST" == $_SERVER["REQUEST_METHOD"]){
                if (isset($_SERVER["HTTP_ORIGIN"])){
                        if ($_SERVER["HTTP_ORIGIN"]!="https://100.66.1.32"){
                                error_log(print_r("origin error", TRUE));
                                logout();
                        }
                }else{
                        logout();
                }
        }

}

function loginattempt($db, $postuser, $action){
        $ip=$_SERVER['REMOTE_ADDR'];
        if ($stmt=mysqli_prepare($db, "insert into login set loginid='', ip=?, user=?, date=now(), action=?;")){
                mysqli_stmt_bind_param($stmt, "sss",$ip, $postuser, $action);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);
        }
}

function logincheck($db){
        $ip=$_SERVER['REMOTE_ADDR'];
        $query="select ip,count(ip) from login where date >= date_sub(NOW(), interval +1 hour) and ip='$ip' and action=0 having count(*)>=5";
        $result=mysqli_query($db,$query);
        while($row=mysqli_fetch_row($result)){
                if ($row[0]==$ip){
                        echo "You have exceeded the number of attempts allowed";
              
                        exit;
                }
        }
}



function logout(){
        session_destroy();
        header("Location: /final_project/main_page.php");
}

function admincheck(){
        if ($_SESSION ['userid'] != 1){
                echo"
                ERROR: Only admin is allowed to add character";
        }
}

?>




